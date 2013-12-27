<?php
namespace Kivi\Controller;

require_once "Kivi/Exception.php";

class ActionNotFoundException extends \Kivi\Exception
{
	protected $_actionName;
	protected $_controllerName;
	
	public function __construct($actionName, $controllerName)
	{
		$this->_actionName = (string) $actionName;
		$this->_controllerName = (string) $controllerName;
		$msg  = sprintf(
			"The controller action %s has not been defined in the %s controller", 
			$this->_actionName,
			$this->_controllerName
		);
		$code =  932;
		parent::__construct($msg, $code);
	}
	
	public function getActionName()
	{
		return $this->_actionName;
	}
	
	public function getControllerName()
	{
		return $this->_controllerName;
	}
}