<?php

namespace App\One\Events\V1\Events;

class Test
{
    public $a = 1;

    public function setA($a)
    {
        $this->a = $a;
    }
}