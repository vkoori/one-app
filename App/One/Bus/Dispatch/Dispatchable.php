<?php 

namespace App\One\Bus\Dispatch;

trait Dispatchable
{
	/**
	 * Dispatch the job with the given arguments.
	 *
	 * @return \Illuminate\Foundation\Bus\PendingDispatch
	 */
	public static function dispatch(...$arguments)
	{
		return new PendingDispatch(new static(...$arguments));
	}
}