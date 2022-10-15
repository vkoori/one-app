<?php

namespace App\Controllers\Shell\Model;

use One\Database\Mysql\EventBuild;
use One\Database\Mysql\Model;

class BaseModel extends Model
{
	CONST created_at = true;
	CONST updated_at = true;

	public function onBeforeUpdate(EventBuild $call, array $data)
	{
		if (self::created_at) {
			$data['created_at'] = date('Y-m-d h:i:s');
		}
		if (self::updated_at) {
			$data['updated_at'] = date('Y-m-d h:i:s');
		}
		return $call->update($data);
	}

	public function onBeforeInsert(EventBuild $call, array $data)
	{
		if (self::updated_at) {
			$data['updated_at'] = date('Y-m-d h:i:s');
		}
		return $call->update($data);
	}

}
