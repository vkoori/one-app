<?php

namespace App\Database;

interface MigrateContract
{
	public function up(): string;
	public function down(): string;
}