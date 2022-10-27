<?php

namespace App\Database\Model;

use App\Controllers\Shell\Model\BaseModel;

/**
 * Class AdminLogs
 * @property int $id 
 * @property int $userId 
 * @property string $collection 
 * @property string $query 
 * @property string $created_at 
 */
class AdminLogs extends BaseModel
{
    CONST TABLE = 'admin_logs';
}