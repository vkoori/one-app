<?php 

namespace App\One\Bus\Queries;

use App\Database\Model\FailedJobs as ModelFailedJob;
use App\One\Bus\Dispatch\JobContract;

class FailedJob
{
	public static function store(string $uuid, JobContract $job, string $exception): array
	{
		return ModelFailedJob::insert([
			'uuid' => $uuid,
			'payload' => $job,
			'exception' => $exception
		]);
	}
}