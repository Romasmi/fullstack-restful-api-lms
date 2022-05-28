<?php

namespace App\Controller;

use JetBrains\PhpStorm\ArrayShape;

class Controller
{
    protected string $methodType;

    public function __construct()
    {
        $this->methodType = $_SERVER['REQUEST_METHOD'];
    }

    protected function getInputData(): array
    {
        return json_decode(file_get_contents('php://input'), TRUE);
    }

    protected function getQueryStringData(): array
    {
        return $_GET;
    }

    #[ArrayShape(['data' => "array", 'code' => "int"])]
    protected static function prepareResponse(array $data, int $status): array
    {
        return [
            'data' => $data,
            'code' => $status
        ];
    }

    #[ArrayShape(['data' => "array", 'code' => "int"])]
    public static function handleBadRequest(): array
    {
        return self::prepareResponse([
            'status' => 'error'
        ], 400);
    }

    #[ArrayShape(['data' => "array", 'code' => "int"])]
    public static function handleAuthFail(): array
    {
        return self::prepareResponse([
            'status' => 'error'
        ], 401);
    }
}