<?php
namespace Kivi\Controller;

require_once "Kivi/Exception.php";

class ControllerNotFoundException extends \Kivi\Exception
{
	protected $_controllerName;
	
	public function __construct($controllerName)
	{
		$controllerName = (string) $controllerName;
        $msg  = "The action controller $controllerName has not been defined";
		$code =  931;
		$this->_controllerName = $controllerName;
		parent::__construct($msg, $code);
	}
	
	public function getControllerName()
	{
		return $this->_controllerName;
	}
}