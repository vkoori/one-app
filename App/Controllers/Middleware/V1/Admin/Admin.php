<?php 

namespace App\Controllers\Middleware\V1\Admin;

use One\Database\DB;
use One\Exceptions\HttpException;

class Admin 
{
	public function handler($next)
	{
		$admin = $this->getAdmin();

		DB::enableQueryLog();
		$res = $next();
		DB::disableQueryLog();
		Log::logQueries(userId: $admin['userId']);

		return $res;
	}

	private function getAdmin(): array
	{
		$auth = $this->getAuth();

		if ( !true ) {
			throw new HttpException(
				message: __('utils.unauthorized'), 
				code: 401
			);
		}

		return [
			'userId' => 1,
			// ...
		];
	}

	private function getAuth()
	{
		$auth = request()->getHeader('authorization');

		if ( is_null($auth) ) {
			throw new HttpException(
				message: __('utils.unauthorized'), 
				code: 401
			);
		}

		return $auth;
	}
}
