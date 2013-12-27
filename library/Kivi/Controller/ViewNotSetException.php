<?php
namespace Kivi\Controller;

require_once "Kivi/Exception.php";

class ViewNotSetException extends \Kivi\Exception
{
	public function __construct()
	{
		$msg  = "View Object has not been set";
		$code = 933;
		parent::__construct($msg, $code);
	}
}