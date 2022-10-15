<?php

namespace App\Controllers\Shell\Migration;

use One\Database\Mysql\Model;
use One\Exceptions\ShellException;

class Migrate extends MigrateSql
{
	/**
	 * @var string
	 */
	private $migration_dir = _APP_PATH_.'/Database/Migrate/';

	public function up()
	{
		if ( !$this->existMigrateTable() ) {
			$this->runQuery(sql: static::createMigrationTable());
		}

		$files = $this->getFilesNeededToMigration(
			already_up_files: $this->getAlreadyUpFiles()
		);
		$this->upFiles(files: $files);

		return count($files) 
			? colorLog("Successful Data Migration.", 's')
			: colorLog("Everything is up to date!", 'i');
	}

	public function down()
	{
		if ( !$this->existMigrateTable() ) {
			throw new ShellException("Migration table not found!");
		}

		$files = $this->runQuery(sql: self::getLastMigrate());
		if (count($files) == 0) {
			throw new ShellException("No migration found!");
		}

		$this->downFiles(
			files: array_column($files, 'file')
		);

		return colorLog("The migration was rolled back successfully.", 's');
	}

	private function downFiles(array $files)
	{
		foreach ($files as $file) {
			$class = require_once $this->migration_dir.$file;
			$this->runQuery(sql: $class->down());
			$this->runQuery(
				sql: self::rollBackMigration(), 
				build: [
					'file' => $file,
				]
			);
		}
	}

	private function upFiles(array $files)
	{
		$batch = $this->runQuery(sql: self::getNumberOfLastMigrate());
		$batch = $batch[0]['batch'] ?? 0;

		foreach ($files as $file) {
			$class = require_once $this->migration_dir.$file;
			$this->runQuery(sql: $class->up());
			$this->runQuery(
				sql: self::addMigrate(), 
				build: [
					'file' => $file,
					'batch' => $batch + 1
				]
			);
		}
	}

	private function getFilesNeededToMigration(array $already_up_files): array
	{
		$allFiles = scandir($this->migration_dir);
		$upFiles = array_diff($allFiles, ['.', '..'], $already_up_files);

		return $upFiles;
	}

	private function existMigrateTable(): bool
	{
		$migrateTable = $this->runQuery(sql: static::showMigrationTable());
		return count($migrateTable);
	}

	public function getAlreadyUpFiles(): array
	{
		$files = $this->runQuery(sql: static::getMigratedFiles());
		return array_column($files, 'file');
	}

	private function runQuery(string $sql, array $build=[]): array
	{
		return Model::cache(0)->query(sql: $sql, build: $build)->toArray();
	}

}
