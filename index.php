<?php

define("DS", DIRECTORY_SEPARATOR);
define("ROOT", realpath(__DIR__) . DS);
define("CONFIG_DIR", ROOT.'config'.DS);
define("VENDOR_DIR", ROOT . "vendor" . DS . 'vendor' . DS);
define('MODULE_DIR', ROOT . "protected" . DS . 'Modules' . DS);
define('PROTECTED_DIR', ROOT . "protected" . DS);
define('VAR_DIR', PROTECTED_DIR.'Var'.DS);
define('LOG_DIR', VAR_DIR.'Logs'.DS);

define("THEMES_DIR", ROOT  . "themes" . DS);

require VENDOR_DIR . 'autoload.php';
require 'assistant.php';

$mode = detectMode(array(
	'development'	=> array('mac.local', 'localhost'),
	'testing' 		=> array('your-machine-name'),
	'production'	=> array(),
));

define('APPLICATION_MODE', $mode);


require PROTECTED_DIR . 'libs' . DS . 'FrameWork.php';

FrameWork::start()->run();