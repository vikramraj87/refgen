<?php
namespace Kivi\Log;

class NoWriterException extends \Kivi\Exception {
    public function __construct()
    {
        $msg  = "No writers registered with the logger";
        $code = 401;
        parent::__construct($msg, $code);
    }
} 