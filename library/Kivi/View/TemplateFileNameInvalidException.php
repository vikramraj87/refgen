<?php
namespace Kivi\View;


class TemplateFileNameInvalidException extends \Kivi\Exception {
    public function __construct()
    {
        $msg  = "Template file name is invalid";
        $code = 942;
        parent::__construct($msg, $code);
    }
} 