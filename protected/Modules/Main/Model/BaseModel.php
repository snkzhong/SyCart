<?php

namespace Main\Model;

use RedBean_Facade as R;

class BaseModel
{
	protected $table;
	protected $dbSource = 'default';

	public static function model($source='default', $className=null)
	{
		if (!$className) {
			$className = __CLASS__;
		}

		$model =  new $className;

		$dbSource = $source;
		if (!$dbSource) {
			$dbSource = $model->dbSource;
		}
		
		$dbConfig = config('database.'.$dbSource);

		$dsn = "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']}";
		$dbUser = $dbConfig['user'];
		$dbPwd = $dbConfig['password'];

		if ($dbSource!='default') {
			R::addDatabase( $dbSource, $dsn, $dbUser, $dbPwd);
			R::selectDatabase( $dbSource );
		}
		else {
			R::setup($dsn, $dbUser, $dbPwd);
		}

		return $model;
	}

	public function getTable($table='')
	{
		$theTable = '';
		if ($table) {
			$theTable = $table;
		}
		else {
			$theTable = $this->table;
		}

		return $theTable;
	}

	public static function getSql()
	{
		return R::$adapter->getSql();
	}

	public function insert($kvs=array(), $table='')
	{
		$table = $this->getTable($table);
		$sql = "INSERT INTO `".$table."`";
		if ($kvs) {
			$sql.= "(".implode(',', array_keys($kvs)).") ";
			$sql.= "VALUES('".implode("','", array_values($kvs))."')";
		}
		R::exec($sql);
		return R::$adapter->getInsertID();
	}

	public function update($kvs=array(), $where=null, $table='')
	{
		$sets = array();
		foreach ($kvs as $key => $value) {
			$sets[] = $key . ' = ?';
		}
		$params = array_values($kvs);

		list($whereConf, $params2) = $this->buildWhereConf($where);
		$params = array_merge($params, $params2);

		$sql = "UPDATE `".$this->getTable($table)."` SET ".implode(',', $sets) . ' WHERE ' . $whereConf;
		R::exec($sql, $params);
	}

	public function delete($where=null, $table='')
	{
		list($whereConf, $params) = $this->buildWhereConf($where);

		$sql = "DELETE FROM `".$this->getTable($table)."` WHERE ".$whereConf;
		echo $sql;
		R::exec($sql, $params);
	}

	// public function find($where='1', $params=array(), $table='')
	// {
	// 	if (!is_array($params)) {
	// 		$params = (array)$params;
	// 	}

	// 	$rs = R::find($this->getTable($table), $where, $params);
	// 	return $rs ? $rs : array();
	// }

	// public function findOne($where='1', $params=array(), $table='')
	// {
	// 	if (!is_array($params)) {
	// 		$params = (array)$params;
	// 	}

	// 	$rs = R::findOne($this->getTable($table), $where, $params);
	// 	return $rs ? $rs : array();
	// }

	// public function findAll($where='1', $params=array(), $table='')
	// {
	// 	if (!is_array($params)) {
	// 		$params = (array)$params;
	// 	}
		
	// 	$rs = R::findAll($this->getTable($table), $where, $params);
	// 	return $rs ? $rs : array();
	// }

	public function getRow($where=null, $table='')
	{
		list($whereConf, $params) = $this->buildWhereConf($where);

		$sql = "SELECT * FROM `".$this->getTable($table)."` WHERE ".$whereConf." LIMIT 1 ";

		$rs = R::getRow($sql, $params);
		return $rs ? $rs : array();
	}

	public function getAll($where=null, $table='')
	{
		list($whereConf, $params) = $this->buildWhereConf($where);

		$sql = "SELECT * FROM `".$this->getTable($table)."` WHERE ".$whereConf;
		return R::getAll($sql, $params);
	}

	public function getCol($column, $where=null, $table='')
	{
		$selectColumn = '';
		if (is_string($column)) {
			$selectColumn = $column;
		}
		elseif (is_array($column)) {
			$selectColumn = implode(', ', $column);
		}

		list($whereConf, $params) = $this->buildWhereConf($where);
		$sql = "SELECT ".$selectColumn." FROM ".$this->getTable($table)." WHERE ".$whereConf;
		return R::getCol($sql, $params);
	}

	public function getCell($column, $where=null, $table='')
	{
		$selectColumn = '';
		if (is_string($column)) {
			$selectColumn = $column;
		}
		elseif (is_array($column)) {
			$selectColumn = implode(', ', $column);
		}

		list($whereConf, $params) = $this->buildWhereConf($where);
		$sql = "SELECT ".$selectColumn." FROM ".$this->getTable($table)." WHERE ".$whereConf." LIMIT 1";
		return R::getCell($sql, $params);
	}

	private function buildWhereConf($where=null)
	{
		$wheres = $params = array();
		$whereConf = '';
		if (is_array($where) && $where) {
			foreach ($where as $key => $value) {
				$wheres[] = $key . ' = ?';
				$params[] = $value;
			}
			$whereConf = implode(',', $wheres);
		}
		elseif (preg_match("/^\d+$/", $where)) {
			$whereConf = ' id = ?';
			$params[] = $where;
		}
		elseif (is_string($where)) {
			$whereConf = $where;
		}
		else {
			$whereConf = '1';
		}

		return array($whereConf, $params);
	}
}