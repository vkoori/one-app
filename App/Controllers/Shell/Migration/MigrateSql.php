<?php

namespace App\Controllers\Shell\Migration;

class MigrateSql
{
	protected static function showMigrationTable()
	{
		return "SHOW TABLES LIKE '%migrates%'";
	}

	protected static function createMigrationTable()
	{
		return "
			CREATE TABLE IF NOT EXISTS `migrates` ( 
				`id` INT(10) UNSIGNED NOT NULL AUTO_INCREMENT , 
				`file` VARCHAR(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL , 
				`batch` INT(11) UNSIGNED NOT NULL , 
				PRIMARY KEY (`id`)
			) ENGINE = InnoDB;
		";
	}

	protected static function getMigratedFiles() {
		return "SELECT `file` FROM `migrates`";
	}

	protected static function getLastMigrate()
	{
		return "
			SELECT * 
			FROM `migrates` 
			WHERE `batch` = (".self::getNumberOfLastMigrate().")
		";
	}

	protected static function rollBackMigration()
	{
		return "DELETE FROM `migrates` WHERE `file`=:file";
	}

	protected static function addMigrate()
	{
		return "INSERT INTO `migrates`(`id`, `file`, `batch`) VALUES (Null, :file, :batch)";
	}

	protected static function getNumberOfLastMigrate()
	{
		return "SELECT MAX(`batch`) AS `batch` FROM `migrates`";
	}
}