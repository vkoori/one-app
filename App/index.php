<?php

define('_APP_PATH_', __DIR__);
define('_APP_PATH_VIEW_', __DIR__ . '/View');

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../vendor/vkoori/one/src/run.php';
require __DIR__ . '/config.php';

try {
    $req = request();
    $res = response($req);

    $router = new \One\Http\Router();
    list($req->class, $req->func, $mids, $action, $req->args, $req->as_name) = $router->explain($req->method(), $req->uri(), $req, $res);
    $f = $router->getExecAction($mids, $action, $req, $res);
    echo $f();
} catch (\One\Exceptions\ShellException $e) {
    echo colorLog(str: $e->getMessage(), type: 'e');
} catch (\Throwable $e) {
    echo (new \App\One\Exception\Errors)->render($e);
}
