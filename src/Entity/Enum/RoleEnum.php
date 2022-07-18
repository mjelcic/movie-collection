<?php

namespace App\Entity\Enum;

abstract class RoleEnum
{
    const ADMIN = "ROLE_ADMIN";
    const USER = "ROLE_USER";

    /** @var array user friendly named type */
    protected static $roleName = [
        self::ADMIN => 'Administrator',
        self::USER => 'User',
    ];

    /**
     * @param  string $roleName
     * @return string
     */
    public static function getRoleName($key)
    {
        if (!isset(static::$roleName[$key])) {
            return "Unknown type ($key)";
        }

        return static::$roleName[$key];
    }

    /**
     * @return array<string>
     */
    public static function getAvailableRoles()
    {
        return [
            self::ADMIN,
            self::USER
        ];
    }
}