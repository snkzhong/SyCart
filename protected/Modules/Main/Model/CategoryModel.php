<?php

namespace Main\Model;

use RedBean_Facade as R;

class CategoryModel extends BaseModel
{
	protected $table = 'categories';

	public static function model($source='default', $className=__CLASS__)
	{
		return parent::model($source, $className);
	}

	public static function has($name, $language=0)
	{
		return self::model()->getRow('language_id=? AND name=?', array($language, $name), 'category_descriptions');
	}

	public static function create($parentId, $kvs=array())
	{
		$model = self::model();
		$parentCategory = $model->getRow($parentId);
		if (!$parentCategory) {
			return false;
		}

		$categoryId = $model->insert(array('parent_id'=>$parentId));
		if (!$parentCategory) {
			return false;
		}

		$category = $model->getRow($categoryId);
		$treeArr = (array)explode(',', $parentCategory['tree']);
		$treeArr[] = $categoryId;
		$tree = implode(',', $treeArr);
		$category['tree'] = $tree;
		$model->update($category, $categoryId);
	}

	public static function remove($categoryId)
	{
		$model = self::model();
		$category = $model->load($categoryId);
		$model->delete(" tree like '".$category->tree."%' ");
	}
}