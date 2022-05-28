<?php

namespace App\Database\Seeder;

class Seeder
{
    public static function generateLogin(int $length = 6): string
    {
        $chars = "abcdefghijklmnopqrstuvwxyz";
        return substr(str_shuffle($chars),0, $length);
    }

    public static function generatePassword(int $length = 6): string
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        return substr(str_shuffle($chars),0, $length);
    }
}