<?php

use Symfony\Component\Finder\Finder;
use Symfony\Component\Filesystem\Filesystem;

require_once PROTECTED_DIR.'Libs/Config.php';

class FrameWork extends \Slim\Slim
{
	static $autoloadDirectories;

	public static function start($params=array())
	{
		$appParams = Config::get('app');
		$autoloadDirs = $appParams['autoload_dir'];
		self::addDirectories($autoloadDirs);
		unset($appParams['autoload_dir']);
		//self::setModuleAutoloadDirs();
		
		spl_autoload_register(__NAMESPACE__ . "\\FrameWork::autoload");

		$app =  new FrameWork(array_merge($appParams, $params));
		$app->setModes();
		$app->setLog();
		
		R::set('theme', 'default');
		$app->config('templates.path', THEMES_DIR. R::get('theme').DS.'templates');
		$app->loadTwigExtensions();
		$app->loadRouters();
		return $app;
	}

	public static function setModuleAutoloadDirs()
	{
		$arr = array();
		$modsIteator = wrapObj(new Finder())->directories()->in(MODULE_DIR);
		$autoloadDirs = array('controllers', 'models', 'libs', 'helpers');
		foreach ($modsIteator as $mod) {
			foreach ($autoloadDirs as $ad) {
				$theDir = $mod->getRealpath().DS.$ad.DS;
				if (file_exists($theDir)) {
					$arr[] = $theDir;
				}
			}
		}

		self::addDirectories($arr);
	}

	public function setModes()
	{
		$this->configureMode('development', function (){
		    sapp()->config(array(
		        'log.enable' => true,
		        'debug' => true
		    ));
		});

		$this->configureMode('testing', function (){
		    sapp()->config(array(
		        'log.enable' => true,
		        'debug' => true
		    ));
		});

		$this->configureMode('production', function (){
		    sapp()->config(array(
		        'log.enable' => true,
		        'debug' => false
		    ));
		});
	}

	// public function setConfig()
	// {
	// 	$this->container->singleton('config', function ($c) {
 //            return new \Config;
 //        });
	// }

	public function setLog()
	{
		$logFile = LOG_DIR.date('Y-m-d').'.log';
		$this->environment['slim.errors'] = fopen($logFile, 'a');
	}

	public function loadRouters()
	{
		$modsIteator = wrapObj(new Finder())->directories()->in(MODULE_DIR);
		foreach (modules() as $modName) {
			$routeDir = MODULE_DIR.$modName.DS.'Routes';
			if (!file_exists($routeDir)) {
				continue;
			}

			$fileIteator = wrapObj(new Finder())->files()->name('*.php')->in($routeDir);
			foreach($fileIteator as $routerFile) {
    			require_once $routerFile->getRealpath();
			}
		}
	}

	public function loadTwigExtensions()
	{
		foreach (modules() as $modName) {
			$modTwigDir = MODULE_DIR.$modName.DS.'Twig';
			if (!file_exists($modTwigDir)) {
				continue;
			}

			$fileIteator = wrapObj(new Finder())->files()->name('*.php')->in($modTwigDir);
			foreach($fileIteator as $file) {
				if (file_exists($file->getRealpath())) {
					require_once $file->getRealpath();
				}
			}
		}

		$this->view->parserExtensions = array(
			new \Slim\Views\TwigExtension(),
			new MyTwigExtension(),
			new Twig_Extension_StringLoader()
		);
	}

	public static function addDirectories($dirs = array())
	{
		if (!is_array(static::$autoloadDirectories)) {
			static::$autoloadDirectories = array();
		}
		static::$autoloadDirectories = array_merge(static::$autoloadDirectories, $dirs);
	}	

	public static function autoload($className)
	{
		$className = str_replace('\\', '_', $className);
		foreach (static::$autoloadDirectories as $dir) {
			$arr = array_filter( explode('_', $className) );
			array_map('ucfirst', $arr);
			$classFile = implode(DS, $arr).'.php';
			//echo $classFile, "<br />";
			if (file_exists($dir.$classFile)) {
				require $dir.$classFile;
				break;
			}
		}

		parent::autoload($className);
	}

	public function setTemplatesDirectory($directory)
    {
    	$this->view->setTemplatesDirectory($directory);
    }
}