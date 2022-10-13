<?php 

namespace App\One\Exception;

use One\Exceptions\Exception;
use One\Exceptions\HttpException;
use One\Database\Mysql\DbException;
use One\Validation\ValidationException;

class Errors extends Exception
{
	public function getErrors(\Throwable $e): array
	{
		return match ($e::class) {
			HttpException::class => $this->httpException($e),
			DbException::class => $this->dbException($e),
			ValidationException::class => $this->validation($e),
			default => $this->default($e),
		};
	}

	private function httpException(HttpException $e)
	{
		return $this->errorCastToArray(message: $e->getMessage());
	}

	private function dbException(HttpException $e)
	{
		error_report($e);
		return $this->errorCastToArray(message: 'db error!');
	}

	private function validation(ValidationException $e)
	{
		return $e->getErrors();
	}

	private function default(\Throwable $e)
	{
		error_report($e);
		return $this->errorCastToArray(message: $e->getMessage());
	}

	private function errorCastToArray(string $message): array
	{
		return [
			'exception' => [$message]
		];
	}

}