<?php
namespace Kivi;

require_once "RegistryEntryNotFoundException.php";

class Registry
{
	protected $_data = array();
	
	protected static $_instance = null;
	
	protected function __construct()
	{
	}
	
	public static function getInstance()
	{
		if(is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}
	
	public function __get($var)
	{
		if(!isset($this->_data[$var])) {
			throw new \Kivi\RegistryEntryNotFoundException($var);
		}
		return $this->_data[$var];
	}
	
	public function __set($var, $value)
	{
		$this->_data[$var] = $value;
	}
	
	public function __isset($var)
	{
		return isset($this->_data[$var]);
	}
	
	public function __unset($var)
	{
		if(isset($this->_data[$var])) {
			unset($this->_data[$var]);
		}
	}
}