<?php

return array(
	'version'	=> '1.0',

	'autoload_dir'	=> array(
		MODULE_DIR,
		PROTECTED_DIR . 'Libs' . DS,
	),

	'mode'			=> APPLICATION_MODE,
	'log.enabled' 	=> true,
	'view' 			=> new \Slim\Views\Twig(),
	'debug' 		=> true,
);