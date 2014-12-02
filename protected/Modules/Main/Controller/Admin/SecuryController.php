<?php

class Admin_SecuryController extends BaseController
{
	public function login()
	{
		$data = array();
		$this->render('login.html', $data);
	}
}