<?php 

namespace App\Controllers\Middleware\V1\Transaction;

use One\Database\Mysql\Model;

class Transaction 
{
	public function handler($next)
	{
		try {
			Model::beginTransaction();
			$res = $next();
			Model::commit();
		} catch (\Throwable $e) {
			Model::rollBack();
			throw $e;
		}

		return $res;
	}

}
