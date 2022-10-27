<?php

namespace App\Database\Model;

use App\Controllers\Shell\Model\BaseModel;
use One\Database\Mysql\EventBuild;

/**
 * Class Jobs
 * @property int $id 
 * @property string $payload 
 * @property int $attempts 
 * @property string $executed_at 
 * @property string $available_at 
 * @property string $created_at 
 */
class Jobs extends BaseModel
{
    CONST TABLE = 'jobs';
    CONST updated_at = false;

    public function onBeforeInsert(EventBuild $call, array &$data, bool $is_multi)
    {
        parent::onBeforeInsert(call: $call, data: $data, is_multi: $is_multi);

        $data['payload'] = serialize($data['payload']);
    }
}