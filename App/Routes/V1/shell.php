<?php

use One\Http\Router;

Router::shell('/route', \App\Controllers\Shell\Routing\Route::class . '@cache');
Router::shell('/model', \App\Controllers\Shell\Model\Model::class . '@generate');
Router::shell('/migrate', \App\Controllers\Shell\Migration\Migrate::class . '@up');
Router::shell('/migrate:rollback', \App\Controllers\Shell\Migration\Migrate::class . '@down');
Router::shell('/queue', \App\One\Bus\Shell\Queue::class . '@handler');
