<?php
namespace Kivi\Config;

require_once "Kivi/Exception.php";

class ConfigFileNotFoundException extends \Kivi\Exception
{
	protected $_fileName;
	
	public function __construct($file)
	{
		$this->_fileName = $file;
		$msg = $file . " is missing or not found";
		$code = 101;
		parent::__construct($msg, $code);
	}
	
	public function getFileName()
	{
		return $this->_file;
	}
}