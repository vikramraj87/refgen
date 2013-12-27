<?php
namespace Kivi;

class Exception extends \Exception
{
	public function __get($var)
	{
		$lazyLoader = "get" . ucfirst($var);
		if(!method_exists($this, $lazyLoader)) {
			throw new \InvalidArgumentException("$var is not a property of" . get_class($this));
		}
		call_user_func(array($this, $lazyLoader));
	}
}