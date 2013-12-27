<?php
namespace Model;
class PubMedNotAvailableException extends \Exception
{
	protected $_msg  = "PubMed currently not available";
	protected $_code = 101;
	
	public function __construct()
	{
		parent::__construct($this->_msg, $this->_code);
	}
}