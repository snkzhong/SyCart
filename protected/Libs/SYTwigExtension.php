<?php

class SYTwigExtension extends \Twig_Extension
{
	public function getName()
    {
        return 'my';
    }

	public function getFunctions()
    {
    	$functions = array();

    	$funcs = get_defined_functions();
    	foreach ($funcs['user'] as $func) {
    		if (preg_match("/^twig_func_/", $func)) {
    			$theFunc = str_replace('twig_func_', '', $func);
                
    			$functions[] = new \Twig_SimpleFunction($theFunc, $func);
    		}
    	}

    	return $functions;
    }

    public function getFilters()
    {
    	$functions = array();

    	$funcs = get_defined_functions();
    	foreach ($funcs['user'] as $func) {
    		if (preg_match("/^twig_filter_/", $func)) {
    			$theFunc = str_replace('twig_filter_', '', $func);

    			$functions[] = new \Twig_SimpleFilter($theFunc, $func);
    		}
    	}

    	return $functions;
    }

    public function getTests()
    {
    	$functions = array();

    	$funcs = get_defined_functions();
    	foreach ($funcs['user'] as $func) {
    		if (preg_match("/^twig_test_/", $func)) {
    			$theFunc = str_replace('twig_test_', '', $func);

    			$functions[] = new \Twig_SimpleTest($theFunc, $func);
    		}
    	}

    	return $functions;
    }
}