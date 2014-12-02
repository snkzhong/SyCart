<?php

class NoneDbResultClass implements \ArrayAccess
{
	public function __get($key)
	{
		return '';
	}

	public function __invoke()
	{
		return false;
	}

	public function offsetExists ($offset)
	{
		return false;
	}

	public function offsetGet ($offset)
	{
		return '';
	}

	public function offsetSet ($offset, $value)
	{
		return ;
	}

	public function offsetUnset ($offset)
	{
		return ;
	}
}