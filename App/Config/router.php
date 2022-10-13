<?php 

require_once _APP_PATH_ . '/Routes/V1/shell.php';
require_once _APP_PATH_ . '/Routes/V1/user.php';
\One\Http\Router::group(
	[
		'middle' => [
			\App\Controllers\Middleware\TestMiddle::class . '@handler'
		]
	],
	function () {
		require_once _APP_PATH_ . '/Routes/V1/general.php';
	}
);
