<?php
namespace Kivi\View;
require_once "Kivi/View.php";
require_once "Kivi/Layout.php";
require_once "Smarty/Smarty.class.php";

/**
 * The View of MVC pattern with smarty as template generator
 *
 * @category  Kivi
 * @package   Kivi\View
 * @version   1.0.1
 * @author    Vikram
 */
class Smarty extends \Kivi\View
{
	/** @type \Smarty Holds the smarty instance */
	protected $_smarty;
	
	/** @type string Base directory for all template files */
	protected $_baseDir;
	
	/**
	 * Constructor
	 *
	 * Gets all the required folder names from the config variable of
	 * registry and assign it to the smarty properties.
	 */
	public function __construct()
	{
		$this->_smarty = new \Smarty();
    }

    /**
     * Factory method for generating view object
     *
     * @param array|\Kivi\Config $options
     * @return Smarty
     * @throws \InvalidArgumentException
     */
    public static function factory($options)
    {
        if($options instanceof \Kivi\Config) {
            $options = $options->toArray();
        }
        if(!is_array($options)) {
            throw new \InvalidArgumentException("Options must be either array or \Kivi\Config");
        }
        $view = new self;

        if(isset($options["directory"])) {
            $view->_baseDir = APPLICATION_DIR . "/" . $options["directory"];
        }
        if(isset($options["config_directory"])) {
            $view->_smarty->setConfigDir(APPLICATION_DIR . "/" . $options["config_directory"]);
        }
        if(isset($options["compile_directory"])) {
            $view->_smarty->setCompileDir(APPLICATION_DIR . "/" . $options["compile_directory"]);
        }
        if(isset($options["cache_directory"])) {
            $view->_smarty->setCacheDir(APPLICATION_DIR . "/" . $options["cache_directory"]);
        }
        if(isset($options["layout"])) {
            $layoutOptions = $options["layout"];
            if(isset($layoutOptions["directory"])) {
                $view->_smarty->setTemplateDir(APPLICATION_DIR . "/" . $layoutOptions["directory"]);
            }
            if(isset($layoutOptions["default"])) {
                $view->_defaultLayout = $layoutOptions["default"];
            }
        }
        return $view;
    }

    /*
     * Renders the smarty template
     *
     * Checks if layout is set. If so renders the layout else just renders the
     * corresponding template file. If action and controller names are
     * provided, then corresponding template is rendered
     *
     * @param  string $action     Name of the controller action
     * @param  string $controller Name of the action controller
     * @return void
     */
    public function render($action = "", $controller = "")
	{
        $action = empty($action) ?
            strtolower($this->getRegistry()->action->getActionName()) :
            strtolower($action);
        $controller = empty($controller) ?
            strtolower($this->getRegistry()->controller->getControllerName()) :
            strtolower($controller);

        /** @var string File name of the template */
		$fn = "";

        $fn = $this->_file = $action;

        // Add the controller as subdirectory for smarty to search views
        $this->_smarty->addTemplateDir($this->_baseDir . "/" . $controller);

        if(!empty($this->_vars)) {
			foreach($this->_vars as $var => $value) {
				$this->_smarty->assign($var, $value);
			}
		}
        if($this->layout instanceof \Kivi\Layout && $this->_layoutEnabled) {

            $partials = $this->_layout->getPartials();

            /*
             * Partial views are added to the smarty as __key -> view
             */
			if(!empty($partials)) {
				foreach($partials as $mapper => $fileName) {
					$m = "__" . $mapper;
					$f = $this->_smarty->fetch($fileName . ".tpl");
					$this->_smarty->assign($m, $f);
				}
			}

            /*
             * Get the current view file and add it to the __content property
             */
			$this->_smarty->assign(
                "__content", $this->_smarty->fetch($this->_file . ".tpl"));

            /*
             * Layout values are added to the smarty as _key -> view
             */
			$layoutVars = $this->_layout->getVars();
			if(!empty($layoutVars)) {
				foreach($layoutVars as $var => $value) {
					$this->_smarty->assign("_" . $var, $value);
				}
			}

            /*
             * Get the layout file to render the layout instead of current view
             */
			$fn = $this->_layout->getFile();
		}
		
		$this->_smarty->display($fn . ".tpl");
	}
}
