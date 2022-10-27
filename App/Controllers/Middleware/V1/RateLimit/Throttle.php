<?php 

namespace App\Controllers\Middleware\V1\RateLimit;

use One\Exceptions\HttpException;
use One\Facades\Cache;

class Throttle
{
	/** 
	 * @var int
	 */
	private $decaySeconds;

	/** 
	 * @var int
	 */
	private $maxAttempts;

	/** 
	 * @var string 
	 */
	private $fingerprint;

	/** 
	 * @var int
	 */
	private $attempts;

	public function handler($next, int $maxAttempts=60, int $decaySeconds=60)
	{
		$this
			->setDecaySeconds($decaySeconds)
			->setMaxAttempts($maxAttempts)
			->setFingerprint()
			->setAttempts()
			->setHeader();

		if ( $this->attempts >= $maxAttempts ) {
			throw new HttpException(
				message: __('utils.rateLimit'),
				code: 429
			);
		}

		$this->hit(attempts: $this->attempts);

		$next();
	}

	private function setDecaySeconds(int $decaySeconds): self
	{
		$this->decaySeconds = $decaySeconds;

		return $this;
	}

	private function setMaxAttempts(int $maxAttempts): self
	{
		$this->maxAttempts = $maxAttempts;

		return $this;
	}

	private function setFingerprint(): self
	{
		$this->fingerprint = sha1(implode('|', [request()->method(), request()->baseUrl(), request()->uri(), request()->ip()]));

		return $this;
	}

	private function setAttempts(): self
	{
		$this->attempts = (int) Cache::get(
			key: $this->fingerprint, 
			closure: function() { return 0; },
			ttl: $this->decaySeconds
		);

		return $this;
	}

	private function hit(int $attempts): void
	{
		Cache::update(
			key: $this->fingerprint,
			val: $attempts + 1
		);
	}

	private function setHeader(): void
	{
		response()->header(key: 'X-RateLimit-Limit', val: $this->maxAttempts);
		response()->header(key: 'X-RateLimit-Remaining', val: ($this->maxAttempts - $this->attempts));
	}
}