<?php
namespace Kivi\Controller;

require_once "Kivi/Exception.php";

class InvalidControllerException extends \Kivi\Exception
{
	public function __construct()
	{
		$msg  = "Invalid argument given in place of controller";
		$code =  933;
		parent::__construct($msg, $code);
	}
}