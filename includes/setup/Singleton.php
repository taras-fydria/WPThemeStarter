<?php

namespace SleepyOwl\Includes\Setup;

abstract class Singleton {
	protected function __construct() {

	}

	protected static array $_instance = [];

	public static function get_instance(): Singleton {
		$class = static::class;
		if ( !self::$_instance[ $class ] ) {
			self::$_instance[$class] = new static();
		}

		return self::$_instance[ $class ];
	}
}
