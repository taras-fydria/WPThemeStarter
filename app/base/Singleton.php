<?php

namespace App\Base;

abstract class Singleton
{
    protected function __construct()
    {

    }

    protected static array $_instance = [];

    public static function get_instance()
    {
        $class = static::class;
        if (!isset(self::$_instance[$class])) {
            self::$_instance[$class] = new static();
        }

        return self::$_instance[$class];
    }
}
