<?php

namespace App\Controllers\Api\V1;

use One\Http\Controller;

class Test extends Controller
{

    public function index()
    {
        return "hello world\n";
    }

    public function data(...$args)
    {
        return $this->json($args);
    }
}
