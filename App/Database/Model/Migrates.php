<?php

namespace App\Database\Model;

use App\Controllers\Shell\Model\BaseModel;

/**
 * Class Migrates
 * @property int $id 
 * @property string $file 
 * @property int $batch 
 */
class Migrates extends BaseModel
{
    CONST created_at = null;
    CONST updated_at = null;

    CONST TABLE = 'migrates';
}