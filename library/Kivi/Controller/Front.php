<?php
namespace Kivi\Controller;

require_once "FrontControllerInterface.php";
require_once "ControllerNotFoundException.php";
require_once "ActionNotFoundException.php";
require_once "InvalidControllerException.php";
require_once "Action.php";

/**
 * The Front controller of MVC
 *
 * @category  Kivi
 * @package   Kivi\Controller
 * @version   1.0.1
 * @author    Vikram
 */
class Front implements FrontControllerInterface
{
    /** @var string Name of the default controller */
	protected $_defaultController = "index";

    /** @var string Name of the default action */
	protected $_defaultAction = "index";

    /** @var string Holds the default controller directory */
	protected $_controllerDirectory;

    /** @var \Kivi\Registry|null Site wide registry */
    protected $_registry = null;

    /** @var Front|null Holds the singleton instance */
    protected static $_instance = null;

    /**
     * Contructor
     */
    private function __construct()
	{
        /** @var \SimpleXMLElement $config */
		$config = $this->getRegistry()->config;
		
		if(isset($config->controller->dir)) {
			$this->_controllerDirectory = APPLICATION_DIR . "/" . (string) $config->controller->dir;
		}
		if(isset($config->controller->default)) {
			$this->_defaultController = (string) $config->controller->default;
		}
		if(isset($config->controller->default_action)) {
			$this->_defaultAction = (string) $config->controller->default_action;
		}
		
		if(!isset($this->getRegistry()->controller)) {
			$this->_parseUri();
		}
	}

    /**
     * Factory method to create only one instance of front controller
     *
     * @return Front
     */
    public static function getInstance()
    {
        if(!self::$_instance instanceof self)    {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * Parse the URI into various components and sets action, controller
     * and parameters
     */
    protected function _parseUri()
	{
        /** @var string $path Holds the URL path */
        $path = trim(parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH), "/");

		@list($controller, $action, $params) = explode("/", $path, 3);

        if(isset($params)) {
			$this->setParams($params);
		}
		if(isset($controller)) {
			$this->setController($controller);
		}
		if(isset($action)) {
			$this->setAction($action);
		}
		
	}

    /**
     * Sets the controller for the current request
     *
     * @param string|Base $controller
     * @return $this for chaining
     * @throws ControllerNotFoundException if controller file is missing
     * @throws InvalidControllerException if controller is not instance Base
     */
    public function setController($controller)
	{
		if(empty($controller)) {
			$controller = $this->_defaultController;
		}
		if(is_string($controller)) {
			$controller = ucfirst(strtolower($controller));
			$controller .= "Controller";

            /** @var string $f Name of the controller file */
			$f = $this->_controllerDirectory . "/" . $controller . ".php";
			
			if(!file_exists($f)) {
				throw new \Kivi\Controller\ControllerNotFoundException($controller);
			}
			
			require_once $f;
			$controller = new $controller();
		}
		if(!$controller instanceof \Kivi\Controller\Base) {
			throw new InvalidControllerException(); 
		}
		$this->getRegistry()->controller = $controller;
		return $this;
	}

    /**
     * Sets the action for the current request
     *
     * @param string|Action $action
     * @return $this for chaining
     */
    public function setAction($action)
	{
		if(is_string($action)) {
			if(!isset($this->getRegistry()->controller)) {
				$this->getRegistry()->controller = $this->_defaultController;
			}
			if(is_string($this->getRegistry()->controller)) {
				$this->setController($this->getRegistry()->controller);
			}
			$this->getRegistry()->action = new \Kivi\Controller\Action($action, $this->getRegistry()->controller);
		}
		return $this;
	}

    /**
     * Sets the params for the current request
     *
     * @param string|array $params
     * @return $this for chaining
     * @throws \InvalidArgumentException
     */
    public function setParams($params)
	{
		if(is_string($params)) {
			$p = explode("/", $params);
			
			$params = array();
			for($i = 0; $i < count($p); $i += 2) {
				if(isset($p[$i+1])) {
					$params[$p[$i]] = $p[$i+1];
				}
			}
		}
		if(is_array($params)) {
			$this->getRegistry()->params = $params;
			return $this;
		}
		throw new \InvalidArgumentException("Parameters can be only array.");
	}

    /**
     * Dispatches the request after setting controller, action and view
     */
    public function run()
	{
		if(!isset($this->getRegistry()->controller)) {
			$this->getRegistry()->controller = $this->_defaultController;
		}
		if(is_string($this->getRegistry()->controller)) {
			$this->setController($this->getRegistry()->controller);
		}
		
		if(!isset($this->getRegistry()->action)) {
			$this->getRegistry()->action = $this->_defaultAction;
		}
		if(is_string($this->getRegistry()->action)) {
			$this->setAction($this->getRegistry()->action);
		}
		
		$this->getRegistry()->view = new \Kivi\View\Smarty($this->getRegistry());
		$this->getRegistry()->action->execute();
	}

    /**
     * Returns the site wide registry
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
     * @return string
     */
    public function getDefaultController()
    {
        return $this->_defaultController;
    }

    /**
     * @return string
     */
    public function getDefaultAction()
    {
        return $this->_defaultAction;
    }
}