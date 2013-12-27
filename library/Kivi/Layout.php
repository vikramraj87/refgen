<?php
namespace Kivi;

/**
 * The Layout for \Kivi\View
 *
 * @category  Kivi
 * @package   MVC
 * @version   1.0.1
 * @author    Vikram
 */
class Layout
{
    /** @var string Filename of layout */
	protected $_file;

    /** @var array Layout template variables*/
	protected $_vars = array();

    /** @var array Holds the partial view scripts */
	protected $_partials = array();

    /**
     * Constructor
     *
     * @param  string $file Filename of the layout
     * @throws \InvalidArgumentException if the given argument is not string or
     *      not string castable
     */
    public function __construct($file)
	{
		$file = (string) $file;
		if(!is_string($file)) {
			throw new \InvalidArgumentException("\$file is expected to be string");
		}
		$this->_file = $file;
	}

    /**
     * Magic getter method for template variables
     *
     * @param string $var
     * @return mixed|null
     */
    public function __get($var)
	{
		return isset($this->_vars[$var]) ? $this->_vars[$var] : null;
	}

    /**
     * Magic setter method for template variables
     *
     * @param string $var
     * @param mixed  $value
     */
    public function __set($var, $value)
	{
		$this->_vars[$var] = $value;
	}

    /**
     * Adds a partial view script to the layout
     *
     * @param string $mapper   String representing the placeholder
     * @param string $fileName Filename of the partial
     * @return $this
     */
    public function addPartial($mapper, $fileName)
	{
		$this->_partials[$mapper] = $fileName;
        return $this;
	}

    /**
     * Returns all the partial view scripts
     *
     * @return string[]
     */
    public function getPartials()
	{
		return $this->_partials;
	}

    /**
     * Returns all the layout template variables
     *
     * @return mixed[]
     */
    public function getVars()
	{
		return $this->_vars;
	}

    /**
     * Returns the layout file
     *
     * @return string
     */
    public function getFile()
	{
		return $this->_file;
	}
}

