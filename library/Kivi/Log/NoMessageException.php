<?php
namespace Kivi\Log;

class NoMessageException extends \Kivi\Exception {
    /**
     * Constructor
     */
    public function __construct()
    {
        $msg  = "No message provided for the event to be logged";
        $code = 403;
        parent::__construct($msg, $code);
    }
}