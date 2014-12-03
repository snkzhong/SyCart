<?php

namespace Main\Controller;

use Main\Model\CategoryModel;

use Respect\Validation\Validator as v;

class Category extends Base
{
	public static function model($source='default', $className=__CLASS__)
	{
		return parent::model($source, $className);
	}

	
}