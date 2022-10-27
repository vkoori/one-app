<?php 

namespace App\Controllers\Plugin\Common;

/**
 * 
 */
class Hash {

	public static function make(string $string): string
	{
		return password_hash(
			password: $string, 
			algo: PASSWORD_ARGON2I, 
			options: ['memory_cost' => 1024, 'time_cost' => 2, 'threads' => 2]
		);
	}

	public static function verify(string $string, string $hash): bool
	{
		return password_verify(password: $string, hash: $hash);
	}
}