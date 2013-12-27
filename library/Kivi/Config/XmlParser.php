<?php
namespace Kivi\Config;

require_once "ConfigFileNotFoundException.php";

class XmlParser
{
	protected $_file;
	
	public function __construct($config_file)
	{
		$this->_file = $config_file;
	}

    /**
     * Returns the parsed xml document
     *
     * @return \SimpleXMLElement
     * @throws ConfigFileNotFoundException
     */
    public function parse()
	{
		if(!file_exists($this->_file)) {
			throw new ConfigFileNotFoundException($this->_file);
		}
		return simplexml_load_file($this->_file);
    }

    public function toArray()
    {

    }
}