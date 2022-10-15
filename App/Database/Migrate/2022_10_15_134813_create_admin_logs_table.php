<?php

use App\Database\MigrateContract;

return new class implements MigrateContract
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): string
    {
        return "
            CREATE TABLE `admin_logs` ( 
                `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT , 
                `userId` BIGINT(20) UNSIGNED NOT NULL , 
                `collection` VARCHAR(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL , 
                `query` TEXT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL , 
                `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP , 
                -- `updated_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP , 
                PRIMARY KEY (`id`, `created_at`)
            ) ENGINE = InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
            PARTITION BY RANGE( TO_DAYS(`created_at`) )
            (
                ". $this->partitionRangMonthly(countOfPartitions: 1) .", 
                PARTITION p_MORES VALUES LESS THAN MAXVALUE ENGINE=InnoDB 
            );
        ";
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): string
    {
        return "DROP TABLE `admin_logs`";
    }

    private function partitionRangMonthly(int $countOfPartitions): string
    {
        $Partitions = [];

        $effectiveDate = strtotime(date("y-m-d"));
        for ($i=0; $i < $countOfPartitions; $i++) { 
            $Partitions[] = "PARTITION p_".date('Ym', $effectiveDate)." VALUES LESS THAN( TO_DAYS('".date('Y-m', $effectiveDate)."-01 00:00:00') ) ENGINE=InnoDB";
            $effectiveDate = strtotime("+1 months", $effectiveDate);
        }

        return implode(",\n", $Partitions);
    }
};