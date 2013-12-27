<?php
namespace Kivi\Config;

/**
 * @see Kivi\Exception.php
 */
require_once dirname(__FILE__) . "/../Exception.php";

class SectionNotFoundException extends \Kivi\Exception {
    protected $_section;

    public function __construct($section)
    {
        $this->_section = $section;
        $msg  = "Section '" . $section . "' cannot be found";
        $code = 302;
        parent::__construct($msg, $code);
    }

    public function getSection()
    {
        return $this->_section;
    }
}