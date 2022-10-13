<?php

namespace App\One\Events\V1\Listeners;

class Test
{
    public static function handle($event, ...$args)
    {
        var_dump($event->a, $args);
    }
}