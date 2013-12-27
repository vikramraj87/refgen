<?php
namespace Kivi;

require_once "Kivi/Exception.php";

class RegistryEntryNotFoundException extends \Kivi\Exception
{
	protected $_entry;
	
	public function __construct($entry)
	{
		$this->_entry = $entry;
		$msg  = "$entry is not registered yet";
		$code = 111;
		parent::__construct($msg, $code);
	}
	
	public function getEntry()
	{
		return $this->_entry;
	}
}