<?php

namespace Main\Model;

use RedBean_Facade as R;

class UserModel extends BaseModel
{
	protected $table = 'users';
	protected $dbSource = 'slimblog';

	public static function model($source='default', $className=__CLASS__)
	{
		return parent::model($source, $className);
	}

	public static function updateName()
	{
		self::model()->update(array('name'=>'zhongQin'), 1);
	}

	public static function deleteById($id)
	{
		self::model()->delete($id);
	}

	public static function row()
	{
		return self::model()->getRow();
	}

	public static function rows()
	{
		return self::model()->getAll();
	}

	public static function cols()
	{
		return self::model()->getCol('name');
	}

	public static function cell()
	{
		return self::model()->getCell('username');
	}
}