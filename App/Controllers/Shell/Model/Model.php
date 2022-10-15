<?php

namespace App\Controllers\Shell\Model;

use One\Database\Mysql\ModelHelper;

class Model
{
	public function generate()
    {
        $modelClass = new ModelHelper(
            namespace: Enum\Model::NAMESPACE->value, 
            extend: Enum\Model::EXTEND->value
        );
        $tables = $modelClass->getTables();
        foreach ($tables as $table) {
            $modelClass
                ->set($table)
                ->createModel(dir: Enum\Model::DIRECTORY->value);
            echo colorLog("Modle {$table} generate successfuly.", 's') . PHP_EOL;
        }

        return colorLog("Operation compelete.", 's') . PHP_EOL;
    }

}
