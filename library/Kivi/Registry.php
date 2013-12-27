<?php
namespace Kivi;

/**
 * Singleton Registry Class
 *
 * @Category Kivi
 * @author Vikram
 * @version 1.0.1
 */
class Registry
{
    /**
     * @var array container
     */
    protected $_data = array();

    /**
     * @var null|Registry one and only instance of registry
     */
    protected static $_instance = null;

    /**
     * Constructor protected so that creating multiple instances is prevented
     */
    protected function __construct()
	{
    }

    /**
     * To get the only instance of the class
     *
     * @return Registry|null
     */
    public static function getInstance()
	{
		if(is_null(self::$_instance)) {
			self::$_instance = new self();
		}
		return self::$_instance;
	}

    /**
     * Magic getter method
     *
     * @param string $var name of the variable
     * @return mixed
     * @throws Registry\EntryNotFoundException
     */
    public function __get($var)
	{
		if(!isset($this->_data[$var])) {
            require_once "Registry/EntryNotFoundException.php";
            throw new Registry\EntryNotFoundException($var);
		}
		return $this->_data[$var];
	}

    /**
     * Magic setter method
     *
     * @param string $var
     * @param mixed $value
     */
    public function __set($var, $value)
	{
		$this->_data[$var] = $value;
	}

    /**
     * Magic isset method
     *
     * @param string $var
     * @return bool variable is set or not
     */
    public function __isset($var)
	{
		return isset($this->_data[$var]);
	}

    /**
     * Magic unset method
     *
     * @param string $var
     */
    public function __unset($var)
	{
		if(isset($this->_data[$var])) {
			unset($this->_data[$var]);
		}
	}
}