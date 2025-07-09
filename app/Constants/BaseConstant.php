<?php

namespace App\Constants;

use ReflectionClass;

abstract class BaseConstant
{
    /**
     * Get all constant values (no keys).
     */
    public static function getAll(): array
    {
        return array_values(self::getConstants());
    }

    /**
     * Get all constant keys.
     */
    public static function getKeys(): array
    {
        return array_keys(self::getConstants());
    }

    /**
     * Get constants as key => value.
     */
    public static function asArray(): array
    {
        return self::getConstants();
    }

    /**
     * Use Reflection to get constants.
     */
    private static function getConstants(): array
    {
        return (new ReflectionClass(static::class))->getConstants();
    }
}
