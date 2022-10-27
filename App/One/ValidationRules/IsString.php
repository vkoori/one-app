<?php

namespace App\One\ValidationRules;

use Rakit\Validation\Rule;

class IsString extends Rule
{
    protected $message = ":attribute must be string";

    public function check($value): bool
    {
        return is_string($value);
    }
}
