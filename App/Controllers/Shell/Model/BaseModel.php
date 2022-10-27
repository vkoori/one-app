<?php

namespace App\Controllers\Shell\Model;

use One\Database\Mysql\EventBuild;
use One\Database\Mysql\Model;

class BaseModel extends Model
{
	CONST created_at = true;
	CONST updated_at = true;

	private $now;

	function __construct()
	{
		$this->now = date('Y-m-d H:i:s');
	}

	public function onBeforeUpdate(EventBuild $call, array &$data)
	{
		if (self::updated_at) {
			$data['updated_at'] = $this->now;
		}
	}

	public function onBeforeInsert(EventBuild $call, array &$data, bool $is_multi)
	{
		if ($is_multi) {
			foreach ($data as &$d) {
				if (self::created_at) {
					$d['created_at'] = $this->now;
				}
				if (self::updated_at) {
					$d['updated_at'] = $this->now;
				}
			}
		} else {
			if (self::created_at) {
				$data['created_at'] = $this->now;
			}
			if (self::updated_at) {
				$data['updated_at'] = $this->now;
			}
		}
	}

}
