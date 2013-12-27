<?php
namespace Kivi\Config;

require_once dirname(__FILE__) . "/../Exception.php";

class CircularReferenceException extends \Kivi\Exception {
    public function __construct()
    {
        $msg  = "Circular reference detected between extending and extended sections";
        $code = 301;
        parent::__construct($msg, $code);
    }
} 