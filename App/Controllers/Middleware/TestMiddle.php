<?php 

namespace App\Controllers\Middleware;

use One\Exceptions\HttpException;
use One\Http\Request;
use One\Http\Response;

class TestMiddle
{
	// public function __construct(...$args)
	// {
	// 	var_dump($args);
	// }

	public function handler($next)
	{
		// throw new HttpException(
		// 	message: 'test', 
		// 	code: 501
		// );

		$request->setAttr('test', 'value');

		return $next();
	}
}
