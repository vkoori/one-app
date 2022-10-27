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
            CREATE TABLE `failed_jobs` (
                `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
                `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
                `failed_at` timestamp NOT NULL DEFAULT current_timestamp(),
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
        return "DROP TABLE `failed_jobs`";
    }
};