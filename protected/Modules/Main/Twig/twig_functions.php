<?php

function twig_func_hello($str)
{
	return $str;
}

function twig_func_config()
{
	return call_user_func_array('config', func_get_args());
}

function twig_filter_fuck($arg)
{
	return 'fuck ' . $arg;
}

function twig_func_assets($file)
{
	return basePath().'assets'.DS.$file;
}

function twig_func_themeassets($file)
{
	return basePath().'themes'.DS.R::get('theme').DS.$file;
}