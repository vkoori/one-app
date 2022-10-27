<?php 

namespace App\One\Bus\Dispatch;

use App\One\Bus\Queries\Job as QueriesJob;

class PendingDispatch
{
	/**
	 * The job.
	 *
	 * @var \App\One\Bus\Dispatch\JobContract
	 */
	protected $job;

	/**
	 * Create a new pending job dispatch.
	 *
	 * @param  mixed  $job
	 * @return void
	 */
	public function __construct(JobContract $job)
	{
		$this->job = $job;
	}

	/**
	 * Handle the object's destruction.
	 *
	 * @return void
	 */
	public function __destruct()
	{
		QueriesJob::store(job: $this->job);
	}
}