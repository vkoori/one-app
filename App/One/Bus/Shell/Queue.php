<?php 

namespace App\One\Bus\Shell;

use App\One\Bus\Dispatch\JobContract;
use App\One\Bus\Queries\Job as QueriesJob;
use App\One\Bus\Queries\FailedJob as QueriesFailedJob;

class Queue
{
	private int $maxAttempts = 3;

	public function handler()
	{
		$queues = QueriesJob::getAvailable();

		foreach ($queues as $queue) {
			$result = $this->queueResolveManager(
				job: unserialize($queue['payload']),
				uuid: $queue['uuid'],
				attempts: $queue['attempts']
			);

			echo $result . "\n";
		}
	}

	private function queueResolveManager(JobContract $job, string $uuid, int $attempts)
	{
		try {
			$job->handle();
			QueriesJob::delete(uuid: $uuid);

			$result = colorLog(str: "Job {$uuid} finished successfully!", type: 's');
		} catch (\Throwable $e) {
			error_report($e);
			
			$this
				->jobErrorAttempt(uuid: $uuid, attempts: $attempts)
				->saveFailedJob(uuid: $uuid, job: $job, e: $e);

			$result = colorLog(str: $e->getMessage(), type: 'e');
		}

		return $result;
	}

	private function jobErrorAttempt(string $uuid, int $attempts): self
	{
		if ( $this->maxAttempts > $attempts + 1 ) {
			QueriesJob::hit(uuid: $uuid);
		} else {
			QueriesJob::delete(uuid: $uuid);
		}

		return $this;
	}

	private function saveFailedJob(string $uuid, JobContract $job, \Throwable $e): self
	{
		QueriesFailedJob::store(
			uuid: $uuid,
			job: $job,
			exception: $e->getTraceAsString()
		);

		return $this;
	}
}