<?php

use One\Http\Router;

Router::get('/data/{asd}', [
	'use' => \App\Controllers\Api\V1\Test::class . '@data',
	/*'as' => 'test',
	'middle' => [
		\App\Controllers\Middleware\TestMiddle::class . '@handler'
	]*/
]);
