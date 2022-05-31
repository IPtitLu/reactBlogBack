<?php

namespace App\Manager;

use App\Entity\User;
use Firebase\JWT\JWT;

class TokenManager
{
    private static string $key = 'azerty123';

    public function generateJWT(User $user): string
    {
        return JWT::encode([
            'userId' => $user->getId(),
            'email' => $user->getUserIdentifier(),
            'expired_at' => time() + 30,
        ], self::$key, 'HS256');
    }
}
