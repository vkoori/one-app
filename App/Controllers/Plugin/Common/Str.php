<?php 

namespace App\Controllers\Plugin\Common;

class Str
{
	public static function slug(string $string): string
	{
		$string = strtolower($string);
		$string = trim($string);
		$string = str_replace(search: ' ', replace: '-', subject: $string);
		return $string;
	}

}