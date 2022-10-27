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
            CREATE TABLE `jobs` (
                `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
                `attempts` tinyint(3) UNSIGNED NOT NULL,
                `executed_at` timestamp NULL DEFAULT NULL,
                `available_at` timestamp NULL DEFAULT NULL,
                `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ";
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): string
    {
        return "DROP TABLE `jobs`";
    }
};