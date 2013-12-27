<?php
namespace Kivi\Controller;

require_once "Kivi/Exception.php";

interface FrontControllerInterface
{
	public function setController($controller);
	public function setAction($action);
	public function setParams($params);
	public function run();
}