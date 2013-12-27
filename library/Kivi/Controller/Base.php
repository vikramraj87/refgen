<?php
namespace Kivi\Controller;

require_once "Kivi/Registry.php";
require_once "Kivi/View.php";
require_once "ViewNotSetException.php";

/**
 * Base controller functionality
 *
 * @category      Kivi
 * @package       Kivi\Controller
 * @version       1.0.1
 * @author        Vikram
 * @property      \Kivi\View $view
 * @property-read string     $controllerName
 * @property-read string[]   $params
 */
class Base
{
    /**
     * @var \Kivi\Registry Site wide registry
     */
    protected $_registry;

    /**
     * @var string Name of the controller
     */
    protected $_controllerName;

    /**
     * @var array|null holds the params
     */
    protected $_params = array();

    /**
     * @var string[] holds the get parameters
     */
    protected $_query = array();

    /**
     * @var Front|null
     */
    protected $_frontController = null;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_controllerName = substr(get_class($this), 0, strpos(get_class($this), "Controller"));
        $this->_query = $_GET;
        $this->_init();
    }

	/**
     * Initializing method
     *
     * Code in this function implemented by the child will run immediately
     * after the constructor. So child initializing can be done in this method
     * instead of overriding the constructor. Avoid overriding the constructor
     */
    protected function _init()
    {
    }

    /**
     * Magic getter method
     *
     * @param string $var
     * @return bool
     */
    public function __get($var)
    {
        $lazyLoader = "get" . ucfirst(strtolower($var));
        if(method_exists($this, $lazyLoader)) {
            return $this->$lazyLoader();
        }
        return false;
    }

    /**
     * Magic setter method
     *
     * @param string $var
     * @param mixed  $value
     */
    public function __set($var, $value)
	{
		$lazyLoader = "set" . ucfirst(strtolower($var));
		if(method_exists($this, $lazyLoader)) {
			$this->$lazyLoader($value);
		}
	}

    /**
     * Getter for view object
     *
     * @return \Kivi\View
     * @throws ViewNotSetException if view object not set in registry
     */
    public function getView()
	{
		if(!isset($this->getRegistry()->view)) {
			throw new ViewNotSetException();
		}
		return $this->getRegistry()->view;
	}

    /**
     * Setter for view object
     *
     * @param \Kivi\View $view
     */
    public function setView(\Kivi\View $view)
	{
		$this->getRegistry()->$view = $view;
	}

    /**
     * Getter for name of controller
     *
     * @return string
     */
    public function getControllerName()
	{
		return $this->_controllerName;
	}

    /**
     * Returns all the parameters from the url path
     *
     * @return array
     */
    public function getParams()
	{
        if(empty($this->_params)) {
            $this->_setParams();
        }
	    return $this->_params;
	}

    /**
     * Gets either the query param or the param from the url path
     *
     * @param string $var
     * @return string|null
     */
    public function getParam($var)
	{
        /** @var string|null $value */
        $value = null;

        if(empty($this->_params)) {
            $this->_setParams();
        }
        if(isset($this->_params[$var])) {
			$value = $this->_params[$var];
		}
        if(is_null($value)) {
            $value = $this->getQuery($var);
        }
		return $value;
	}

    /**
     * Gets only the query param
     *
     * @param $var
     * @return null|string
     */
    public function getQuery($var)
    {
        if(isset($this->_query[$var])) {
            return $this->_query[$var];
        }
        return null;
    }

    /**
     * Populates the params array from registry
     */
    protected function _setParams()
    {
        if(isset($this->getRegistry()->params)) {
            $this->_params = $this->getRegistry()->params;
        }
    }

    /**
     * Redirects the page to specified controller and action
     *
     * @param string $action     Name of the controller action
     * @param string $controller Name of the action controller
     * @param array $params      Parameters to add to url
     */
    protected function _redirect($action = "", $controller = "", array $params = array())
    {
        $action     = empty($action) ?
            strtolower($this->getRegistry()->action->getActionName()) : strtolower($action);
        $controller = empty($controller) ?
            strtolower($this->getRegistry()->controller->getControllerName()) : strtolower($controller);

        /** @var string $defaultController */
        $defaultController = strtolower($this->getFrontController()->getDefaultController());

        /** @var string $defaultAction */
        $defaultAction     = strtolower($this->getFrontController()->getDefaultAction());

        /** @var string $qPath holds the query params array as path */
        $qPath = "";

        if(!empty($params)) {
            foreach($params as $var => $value) {
                $qPath .= sprintf("/%s/%s", $var, $value);
            }
        } else {
            if($action == $defaultAction) {
                $action = "";
                if($controller == $defaultController) {
                    $controller = "";
                }
            }

        }

        /** @var string $url */
        $url = "http://" . $_SERVER["HTTP_HOST"];

        if(!empty($controller)) {
            $url .= "/" . $controller;
            if(!empty($action)) {
                $url .= "/" . $action;
                if(!empty($qPath)) {
                    $url .= $qPath;
                }
            }
        }
        header("Location: $url");
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
     * Returns the front controller instance
     *
     * @return Front
     */
    protected function getFrontController()
    {
        if(!$this->_frontController instanceof \Kivi\Controller\Front) {
            $this->_frontController = \Kivi\Controller\Front::getInstance();
        }
        return $this->_frontController;
    }
}