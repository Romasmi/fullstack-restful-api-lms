<?php

namespace App\Controller;

use App\Model\User;
use JetBrains\PhpStorm\ArrayShape;

class UserController extends Controller
{
    private User $user;

    public function __construct()
    {
        parent::__construct();
        $this->user = new User();
    }

    public function handleRequest(): array
    {
        return match ($this->methodType) {
            'GET' => $this->onCheckAuth(),
            'POST' => $this->onLoginUser(),
            'DELETE' => $this->onLogoutUser(),
            default => Controller::handleBadRequest()
        };
    }

    #[ArrayShape(['data' => "array", 'code' => "int"])]
    private function onLoginUser(): array
    {
        $data = $this->getInputData();
        if ($this->user->isValidUser($data['login'], $data['password'])) {
            $user = $this->user->getByField('login', $data['login']);
            $_SESSION['userId'] = $user['id'];

            $response = $this->prepareResponse([
                'status' => 'success'
            ], 200);

            if (isset($data['remember']) && intval($data['remember']) == 1) {
                $token = uniqid();
                $this->user->setToken($data['login'], $token);
                setcookie('token', $token, time() + COOKIE_LIVETIME);
            }
        } else {
            $response = $this->prepareResponse([
                'status' => 'error'
            ], 403);
        }
        return $response;
    }

    #[ArrayShape(['data' => "array", 'code' => "int"])]
    private function onLogoutUser(): array
    {
        $this->user->clearToken($_SESSION['userId']);
        setcookie('token', '', time() - 3600);
        unset($_SESSION['userId']);

        return $this->prepareResponse([
            'status' => 'success'
        ], 200);
    }

    #[ArrayShape(['data' => "array", 'code' => "int"])]
    private function onCheckAuth(): array
    {
        if ($this->hasAuth()) {
            $response = Controller::prepareResponse([
                'status' => 'loggedIn'
            ], 200);
        } else {
            $response = Controller::prepareResponse([
                'status' => 'not auth'
            ], 200);
        }
        return $response;
    }

    public function hasAuth(): bool
    {
        if (isset($_SESSION['userId'])) {
            return true;
        }

        $token = $_COOKIE['token'] ?? false;
        if ($token && $this->user->getByField('token', $token)) {
            return true;
        }

        return false;
    }
}