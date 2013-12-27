<?php
namespace Kivi\Log;


class InvalidPriorityException extends \Kivi\Exception {
    protected $_priority = 0;

    /**
     * Constructor
     *
     * @param int $priority invalid priority supplied
     */
    public function __construct($priority = 0)
    {
        $this->_priority = $priority;
        $msg  = "The priority";
        if($priority) {
            $msg .= " ($priority)";
        }
        $msg .= " specified for the event is invalid";
        $code = 402;
        parent::__construct($msg, $code);
    }

    public function getPriority()
    {
        return $this->_priority;
    }
} 