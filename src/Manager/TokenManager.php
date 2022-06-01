<?php

namespace App\Manager;

use App\Entity\User;
use Firebase\JWT\JWT;

class TokenManager
{
    private static string $key = 'azerty123';

    public function generateJWT($user): string
    {
        return JWT::encode([
            'userId' => $user[0]->getId(),
            'email' => $user[0]->getUserIdentifier(),
            'expired_at' => time() + 30,
        ], self::$key, 'HS256');
    }
}
