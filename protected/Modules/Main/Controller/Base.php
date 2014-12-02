<?php

namespace Main\Controller;

class Base
{
	protected $templateBaseDir = 'front';

	public function render($template, $data=array())
	{
		sapp()->render($template, $data);
	}
}