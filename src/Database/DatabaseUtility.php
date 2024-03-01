<?php
declare(strict_types=1);

namespace Pulle\Crusader\Database;

class DatabaseUtility
{
    function hashPassword(string $password): string
    {
        $pepper = $_ENV["DB_PEPPER"];
        return password_hash($password . $pepper,PASSWORD_BCRYPT );

    }
    function generateSalt(): string
    {
        return bin2hex(random_bytes(8));
    }

    public function verifyPassword(string $password, string $hash): bool
    {
        $pepper = $_ENV["DB_PEPPER"];
        return password_verify($password . $pepper,$hash);
    }

}