<?php

use App\Controller\Controller;
use App\Controller\UserController;
use App\Controller\StudentController;
use App\Middleware\CheckAuthMiddleware;

chdir('app');
require 'app/bootstrap.inc.php';

header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Methods: GET,POST,PUT,DELETE");
header("Access-Control-Allow-Headers: X-Requested-With");
header("Access-Control-Allow-Origin: {$_SERVER['SERVER_PROTOCOL']}://{$_SERVER['HTTP_HOST']}");
header("Content-Type: application/json; charset=UTF-8");
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');
}
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
    {
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE");
    }
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
    {
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    }
    exit(0);
}

$route = explode('/',
    $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))[2];

$response = match ($route) {
    'auth' => (new UserController())->handleRequest(),
    'users' => CheckAuthMiddleware::run([new StudentController(), 'handleRequest']),
    default => (new Controller())->handleBadRequest(),
};

http_response_code($response['code']);

echo json_encode($response['data']);
