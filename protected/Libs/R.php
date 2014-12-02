<?php

final class R {

	private static $data = array();

	public static function get($key) {
		return (isset(static::$data[$key]) ? static::$data[$key] : null);
	}

	public static function set($key, $value) {
		static::$data[$key] = $value;
	}

	public static function has($key) {
		return isset(static::$data[$key]);
	}

	public static function dump()
	{
		return static::$data;
	}
}