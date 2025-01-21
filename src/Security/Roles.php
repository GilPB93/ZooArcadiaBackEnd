<?php

namespace App\Security;

class Roles
{
    public const ROLE_ADMIN = 'ROLE_ADMIN';
    public const ROLE_VETERINAIRE = 'ROLE_VETERINAIRE';
    public const ROLE_USER = 'ROLE_USER';

    public const ROLES = [
        self::ROLE_ADMIN => 'Administrateur',
        self::ROLE_VETERINAIRE => 'Vétérinaire',
        self::ROLE_USER => 'User',
    ];

    public static function isValidRole(string $role): bool
    {
        return array_key_exists($role, self::ROLES);
    }

    public static function getRoles(): array
    {
        return array_keys(self::ROLES);
    }
}