<?php
namespace Kivi\Controller;

require_once "ActionNotFoundException.php";

class Action
{
	protected $_controller;
	protected $_action;
	
	public function __construct($action, \Kivi\Controller\Base $controller)
	{
		$this->_controller = $controller;
		$this->_action     = strtolower($action);
		if(!strpos($this->_action, "Action")) {
			$this->_action .= "Action";
		}
		if(!method_exists($this->_controller, $this->_action)) {
			throw new ActionNotFoundException($action, $controller->controllerName);
		}
	}
	
	public function execute()
	{
		call_user_func(array($this->_controller, $this->_action));
	}
	
	public function getActionName()
	{
		$name = $this->_action;
		if(strpos($name, "Action")) {
			$name = substr($name, 0, strpos($name,"Action"));
		}
		return $name;
	}
}