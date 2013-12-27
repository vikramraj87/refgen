<?php
namespace Kivi\Registry;

require_once dirname(__FILE__) . "/../Exception.php";

class EntryNotFoundException extends \Kivi\Exception
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