<?php

use Symfony\Component\Finder\Finder;

function detectMode($maps)
{
    $currentMachine = gethostname();
    foreach ($maps as $mode => $machines) {
        if (in_array($currentMachine, $machines)) {
            return $mode;
        }
    }

    return 'production';
}

function sapp($name='default')
{
	return FrameWork::getInstance($name);
}

function wrapObj($obj)
{
	return $obj;
}

function config($name='', $default=null)
{
	return Config::get($name, $default);
}

function modules()
{
    if ($cache = R::get('modules')) {
        return $cache;
    }

    $arr = array();
    $modsIteator = wrapObj(new Finder())->directories()->in(MODULE_DIR);
    foreach ($modsIteator as $mod) {
        $modName = $mod->getRelativePathname();
        $arr[] = $modName;
    }

    R::set('modules', $arr);
    return $arr;
}