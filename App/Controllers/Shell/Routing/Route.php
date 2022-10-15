<?php

namespace App\Controllers\Shell\Routing;

use One\Http\Router;

class Route
{
	public function cache()
    {
		Router::cacheRoutes(forceCache: true);

		return colorLog('Routes cached successfully.', 's');
    }

}
