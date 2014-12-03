<?php

namespace Main\Controller;

use Main\Model\BaseModel;
use Main\Model\UserModel;

use Respect\Validation\Validator as v;

class User extends Base
{
	public function hello($name='Zhong Qin')
	{
		$data['name'] = $name;
		//UserModel::updateName();
		//UserModel::deleteById(2);
		// print_r(UserModel::row());

		\Main\Model\CategoryModel::create(1);
		//\Main\Model\CategoryModel::remove(32);
		
		$data['slider'] = sapp()->renderCrumb(dirname(__DIR__).DS.'View', 'test.html',array('name'=>'hello'));
		$this->render('index.html', $data);
	}
}