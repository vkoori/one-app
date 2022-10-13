<?php
\One\Database\Mysql\Connect::setConfig(config('mysql', true));
// \One\Database\ClickHouse\Connect::setConfig(config('clickhouse', true));
\One\Log::setConfig(config('log', true));
\One\Http\Router::setConfig(_APP_PATH_ . '/Config/router.php');
\One\Cache\File::setConfig(config('cache.file', true));
\One\Cache\Redis::setConfig(config('cache.redis', true));
\One\Crypt\Openssl::setConfig(config('crypt', true));
\One\I18n\Lang::setConfig(_APP_PATH_ . '/Lang');
\App\One\Events\Event::run();
\One\Caller\ServiceProvider::setBindings(config('provider', true));

// 分布式配置
if (isset($argv) && strpos($argv[0], 'swoole.php') !== false) {
    \App\Cloud\Server::setConfig(config('cloud', true));
    \One\Swoole\OneServer::setConfig(config(env('server', 'protocol'), true));
    \One\Swoole\Client\Tcp::setConfig(config('client', true));
    // 加载rpc配置
    require _APP_PATH_ . '/Config/rpc.php';
}

// 解析路由
\One\Http\Router::loadRouter();
