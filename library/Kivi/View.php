<?php
namespace Kivi;

require_once "Kivi/Registry.php";

/**
 * The View of MVC pattern
 *
 * @abstract
 * @category  Kivi
 * @property  \Kivi\Layout $layout
 * @package   Kivi
 * @version   1.0.1
 * @author    Vikram
 */
abstract class View
{
	/** @type mixed[] Template variables */
	protected $_vars = array();
	
	/** @type string Template file */
	protected $_file = "";
	
	/** @type string Layout file name */
	protected $_layout = "";
	
	/** @type string Default layout */
	protected $_defaultLayout = "";
	
	/** @type bool Enable/Disable layout */
	protected $_layoutEnabled = true;
	
	/** @type \Kivi\Registry|null Site wide registry */
	protected $_registry = null;

    /**
	 * Getter magic method
	 *
	 * Runs the corresponding getter method or returns the value from
	 * the View::$_vars associative array with the corresponding key. If
	 * neither of them found, returns null.
	 *
	 * @param  string $var Name of the property
	 * @return mixed|null
	 */
	public function __get($var)
	{
		$lazyLoader = "get" . ucfirst($var);
		if(method_exists($this, $lazyLoader)) {
			return $this->$lazyLoader();
		}
		return isset($this->_vars[$var]) ? $this->_vars[$var] : null;
	}
	
	/**
	 * Setter magic method
	 *
	 * Saves the value in the View::$_vars associative array
	 * with $var as key and $value as corresponding value.
	 *
	 * @param  string $var   Name of the property
	 * @param  mixed  $value Value of the property
	 * @return void
	 */
	public function __set($var, $value)
	{
		$this->_vars[$var] = $value;
	}
	
	/** 
	 * Isset magic method
	 *
	 * Checks for the existence of the key in View::$_vars
	 *
	 * @param  string $var Name of the property
	 * @return bool
	 */
	public function __isset($var)
	{
		return isset($this->_vars[$var]);
	}
	
	/**
	 * Sets the layout
	 * 
	 * Sets the layout of the view. if string is provided as
	 * parameter, it is assumed to be the file name of
	 * layout and new \Kivi\Layout object is created and
	 * assigned.
	 *
	 * @param string|\Kivi\Layout $layout
	 * @return void
	 */
	public function setLayout($layout)
	{
		if(!$layout instanceof \Kivi\Layout) {
			$layout = (string) $layout;
			$layout = new \Kivi\Layout($layout);
		}
		$this->_layout = $layout;
	}
	
	/**
	 * returns the layout of the view
	 *
	 * @throws \Kivi\View\LayoutNotSetException if layout object 
	 * 		cannot be created.
	 * @return \Kivi\Layout The layout object
	 */
	public function getLayout()
	{
		if(empty($this->_layout) && !empty($this->_defaultLayout)) {
			$this->_layout = $this->_defaultLayout;
		}
		if(is_string($this->_layout)) {
			$this->setLayout($this->_layout);
		}
		if(!$this->_layout instanceof \Kivi\Layout) {
			throw new \Kivi\View\LayoutNotSetException();
		}
		return $this->_layout;
	}
	
	/**
	 * Disables from rendering the layout.
	 *
	 * @return void
	 */
	public function disableLayout()
	{
       $this->_layoutEnabled = false;
	}

    /**
     * Returns the registry instance
     *
     * @return \Kivi\Registry
     */
    protected function getRegistry()
    {
        if(!$this->_registry instanceof \Kivi\Registry) {
            $this->_registry = \Kivi\Registry::getInstance();
        }
        return $this->_registry;
    }

	/**
	 * Renders the template
	 *
	 * @abstract
	 * @param  string $action     Name of the controller action
	 * @param  string $controller Name of the action controller
	 * @return void
	 */
	abstract public function render($action = "", $controller = "");
}
