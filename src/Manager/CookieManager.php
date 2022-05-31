<?php

namespace App\Manager;

class CookieManager
{
    public function setCookie(string $token): void
    {
        setcookie('token', $token, time() + (3600 * 24 * 365), '/', 'localhost', false, false);
    }
}
