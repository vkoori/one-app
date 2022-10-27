<?php

namespace App\Controllers;

trait EnumContract
{
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public static function keys(): array
    {
        return array_column(self::cases(), 'name');
    }

    public static function keyValues(): array
    {
        $data = [];
        foreach (self::cases() as $case) {
            $data[$case->name] = $case->value;
        }
        return $data;
    }

    public static function casesWithTranslate(): array
    {
        $data = [];
        foreach (self::cases() as $case) {
            array_push($data, [
                'name' => $case->name,
                'value' => $case->value,
                'translate' => __('enum.'.$case->name)
            ]);
        }
        return $data;
    }
}
