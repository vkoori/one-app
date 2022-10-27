<?php 

namespace App\One\Bus\Dispatch;

interface JobContract
{
	public function handle();
}