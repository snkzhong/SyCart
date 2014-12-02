<?php

class Config implements \ArrayAccess
{
	private static $_cellar;
	private static $_instance;

	public function __construct()
	{
		self::$_cellar = array();
	}

	public static function get($name, $default=null)
	{
		if (!self::$_instance) {
			self::$_instance = new Config;
		}

		return self::$_instance->fetch($name, $default);
	}

	public function offsetExists ($offset)
	{
		return is_null($this->fetch($offset)) ? false : true;
	}

	public function offsetGet ($offset, $default=null)
	{
		return $this->fetch($offset, $default);
	}

	public function offsetSet ($offset, $value)
	{
		return ;
	}

	public function offsetUnset ($offset)
	{
		return ;
	}

	private function fetch($name='', $default=null)
	{
		if (!$name) {
			return '';
		}

		$arr = explode('.', $name);
		$fileName = array_shift($arr);
		$field = implode('.', $arr);

		$cacheKey = $fileName;
		if (isset(self::$_cellar[$cacheKey])) {
			$configArr = self::$_cellar[$cacheKey];
		}
		else {
			$file = $this->determineConfigModeFile($fileName);
			$configArr = require $file;
			self::$_cellar[$cacheKey] = $configArr;
		}

		if (strlen($field)==0) {
			return $configArr;
		}

		$r = isset($configArr[$field]) ? $configArr[$field] : $default;
		return $r;
	}

	private function determineConfigModeFile($name)
	{
		$noModeFile = CONFIG_DIR.$name.'.php';
		$modeFile = CONFIG_DIR.$name.'.'.APPLICATION_MODE.'.php';
		if (file_exists($modeFile)) {
			return $modeFile;
		}
		elseif (file_exists($noModeFile)) {
			return $noModeFile;
		}
		else {
			throw new \RuntimeException("config file `{$noModeFile}` or `{$modeFile}` not exists!");
		}
	}
}