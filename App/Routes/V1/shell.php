<?php

use One\Http\Router;

Router::shell('/model', \App\Controllers\Api\V1\Test::class . '@model');
