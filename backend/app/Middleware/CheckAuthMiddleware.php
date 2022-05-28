<?php

namespace App\Middleware;

use App\Controller\Controller;
use App\Controller\UserController;

class CheckAuthMiddleware
{
    public static function run(callable $callback) : mixed
    {
        if ((new UserController())->hasAuth())
        {
            return $callback();
        }
        else
        {
            return Controller::handleAuthFail();
        }
    }
}