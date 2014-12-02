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

		$entity = BaseModel::model('slimblog')->findOne('id = ?', 1, 'users');

		$data['entity'] = $entity;
		$this->render('index.html', $data);
	}
}