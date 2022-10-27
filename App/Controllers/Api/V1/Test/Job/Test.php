<?php 

namespace App\Controllers\Api\V1\Test\Job;

use App\One\Bus\Dispatch\JobContract;
use App\One\Bus\Dispatch\Dispatchable;

class Test implements JobContract
{
	use Dispatchable;

	private $arg;

	public function __construct($arg)
	{
		$this->arg = $arg;
	}

	public function handle()
	{
		var_dump('asd');
	}
}