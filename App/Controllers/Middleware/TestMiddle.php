<?php 

namespace App\Controllers\Middleware;

use One\Exceptions\HttpException;
use One\Http\Request;
use One\Http\Response;

class TestMiddle
{
	// public function __construct(Request $request, Response $response, ...$args)
	// {
	// 	var_dump($args);
	// }

	public function handler($next, Request $request, Response $response)
	{
		// throw new HttpException(
		// 	response: $response,
		// 	message: 'test', 
		// 	code: 501
		// );

		$request->setAttr('test', 'value');

		return $next();
	}
}
