<?php 

namespace App\Controllers\Middleware\V1\Admin;

use App\Database\Model\AdminLogs;
use One\Database\DB;

class Log 
{
	public static function logQueries(int $userId): void
	{
		if (response()->getCode() < 400) {
			$queries = DB::getQueryLog();

			foreach ($queries as $query) {
				if (str_starts_with($query['sql'], 'select')) {
					continue;
				}

				$rawQuery = self::queryWithBindings(query: $query['sql'], bindings: $query['data']);
				$tableName = self::extractTableName(rawQuery: $rawQuery);

				self::saveLog(userId: $userId, tableName: $tableName, rawQuery: $rawQuery);
			}
		}
	}

	private static function queryWithBindings(string $query, array $bindings): string 
    {
		return vsprintf(
			format: str_replace('?', '%s', $query), 
			values: array_map(
				callback: function($value) {
					return is_numeric($value) ? $value : "'{$value}'";
				}, 
				array: $bindings
			)
		);
    }

	private static function extractTableName(string $rawQuery): string 
	{
		$table = '';
		$start = '`';
		$end = '`';
		if (strpos($rawQuery, $start)) { // required if $start not exist in $rawQuery
			$startCharCount = strpos($rawQuery, $start) + strlen($start);
			$firstSubStr = substr($rawQuery, $startCharCount, strlen($rawQuery));
			$endCharCount = strpos($firstSubStr, $end);
			if ($endCharCount == 0) {
				$endCharCount = strlen($firstSubStr);
			}
			$table = substr($firstSubStr, 0, $endCharCount);
		}
		return $table;
	}

	private static function saveLog(int $userId, string $tableName, string $rawQuery): int 
    {
    	return AdminLogs::insert([
    		'userId' => $userId,
    		'collection' => $tableName,
    		'query' => $rawQuery
    	]);
    }

}
