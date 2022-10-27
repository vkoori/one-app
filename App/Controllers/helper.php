<?php 

function success(?array $data=Null, null|array|string $message=Null, int $code=200): string
{
	if (!is_null($message)) {
		$message = is_array($message) ? $message : [$message];
		$message = ['text' => $message];
	}
	return response()->json($data, $message, $code);
}

function error(?array $data=Null, null|array|string $message=Null, int $code=400): string
{
	if (!is_null($message)) {
		$message = is_array($message) ? $message : [$message];
		$message = ['text' => $message];
	}
	return response()->json($data, $message, $code);
}