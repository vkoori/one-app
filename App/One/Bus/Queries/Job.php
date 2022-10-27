<?php 

namespace App\One\Bus\Queries;

use App\Database\Model\Jobs as ModelJob;

class Job
{
	public static function store(\App\One\Bus\Dispatch\JobContract $job): array
	{
		$now = date('Y-m-d H:i:s');

		return ModelJob::insert([
			'uuid' => request()->id(),
			'payload' => $job,
			'attempts' => 0,
			'executed_at' => Null,
			'available_at' => $now
		]);
	}

	public static function getAvailable(): array
	{
		$now = date('Y-m-d H:i:s');

		return ModelJob::where('available_at', '<', $now)->findAll()->toArray();
	}

	public static function delete(string $uuid): bool
	{
		return ModelJob::where('uuid', $uuid)->delete();
	}

	public static function hit(string $uuid)
	{
		return ModelJob::where('uuid', $uuid)->update([
			'attempts' => ['`attempts`+1'],
			'executed_at' => date('Y-m-d H:i:s')
		]);
	}
}