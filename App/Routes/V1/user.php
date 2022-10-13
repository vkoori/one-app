<?php

use One\Http\Router;

Router::get('/', \App\Controllers\Api\V1\Test::class . '@index');
