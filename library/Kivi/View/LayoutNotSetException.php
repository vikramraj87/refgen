<?php
namespace Kivi\Layout;

class LayoutNotSetException extends \Kivi\Exception
{
	public function __construct()
	{
		$msg = "Layout not set properly.";
		$code = 941;
		parent::__construct($msg, $code);
	}
}