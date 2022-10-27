<?php

namespace App\Database\Model;

use App\Controllers\Shell\Model\BaseModel;
use One\Database\Mysql\EventBuild;

/**
 * Class FailedJobs
 * @property int $id 
 * @property string $uuid 
 * @property string $payload 
 * @property string $exception 
 * @property string $failed_at 
 */
class FailedJobs extends BaseModel
{
    CONST TABLE = 'failed_jobs';
    CONST created_at = false;
    CONST updated_at = false;


    public function onBeforeInsert(EventBuild $call, array &$data, bool $is_multi)
    {
        parent::onBeforeInsert(call: $call, data: $data, is_multi: $is_multi);

        $data['payload'] = serialize($data['payload']);
    }
}