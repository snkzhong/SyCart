<?php

namespace Main\Controller\Admin;

use Main\Controller\Base;

class SecuryController extends Base
{
	public function login()
	{
		$data = array();
		$this->render('login.html', $data);
	}
}