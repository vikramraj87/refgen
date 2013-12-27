<?php
namespace Kivi;


class Log {
    const FATAL   = 0;
    const WARNING = 1;
    const NOTICE  = 2;
    const INFO    = 3;
    const DEBUG   = 4;

    /**
     * @var string[] flipped constants of the same class
     */
    protected $_priorities = array();

    /**
     * @var \Kivi\Log\Writer[]|array holds all the writers
     */
    protected $_writers = array();

    /**
     * @var bool|array map of php errors to their priority
     */
    protected $_errorHandlerMap = false;

    /**
     * @var null|function saves the original error handler
     */
    protected $_origErrorHandler = null;

    /**
     * @var bool whether error handler is registered
     */
    protected $_registeredErrorHandler = false;

    /**
     * Constructor
     *
     * @param Log\Writer $writer|null
     */
    public function __construct(Log\Writer $writer = null)
    {
        $r = new \ReflectionClass($this);
        $this->_priorities = array_flip($r->getConstants());

        if($writer !== null) {
            $this->addWriter($writer);
        }
    }

    /**
     * Logs the message using the writers provided
     *
     * @param string $msg        Message to be logged
     * @param int $priority      Priority of the message
     * @param null|array $extras Extra information
     * @throws Log\InvalidPriorityException
     * @throws Log\NoWriterException
     */
    public function log($msg, $priority, $extras = null)
    {
        if(empty($this->_writers)) {
            require_once "Log/NoWriterException.php";
            throw new Log\NoWriterException();
        }

        if(! isset($this->_priorities[$priority])) {
            require_once "Log/InvalidPriorityException.php";
            throw new Log\InvalidPriorityException($priority);
        }

        /** @var array $event details about the event to be logged */
        $event = array(
            "message"  => $msg,
            "priority" => $priority,
            "extra"    => ""
        );

        if(!empty($extras)) {
            /** @var array $info holds the extra info */
            $info = array();
            if(is_array($extras)) {
                foreach($extras as $k => $v) {
                    if(is_string($k)) {
                        $info[] = $k . ": " . $v;
                    } else {
                        $info[] = $v;
                    }
                }
            } else {
                $info[] = $extras;
            }
            $event["extra"] = implode("; ", $info);
        }

        foreach($this->_writers as $writer) {
            $writer->write($event);
        }
    }

    public function registerErrorHandler()
    {
        if($this->_registeredErrorHandler) {
            return $this;
        }

        $this->_origErrorHandler = set_error_handler(array($this, "errorHandler"));

        $this->_errorHandlerMap = array(
            E_NOTICE            => log::NOTICE,
            E_USER_NOTICE       => log::NOTICE,
            E_WARNING           => log::WARNING,
            E_CORE_WARNING      => log::WARNING,
            E_USER_WARNING      => log::WARNING,
            E_ERROR             => log::FATAL,
            E_USER_ERROR        => log::FATAL,
            E_CORE_ERROR        => log::FATAL,
            E_RECOVERABLE_ERROR => log::FATAL,
            E_STRICT            => log::DEBUG,
            E_DEPRECATED        => log::DEBUG,
            E_USER_DEPRECATED   => log::DEBUG
        );

        $this->_registeredErrorHandler = true;
        return $this;
    }

    public function errorHandler($errno, $errstr, $errfile, $errline, $errcontext)
    {
        $errorLevel = error_reporting();

        if($errorLevel && $errno) {
            if(array_key_exists($errno, $this->_errorHandlerMap)) {
                $priority = $this->_errorHandlerMap[$errno];
            } else {
                $priority = log::INFO;
            }
            $extras = array(
                "errno"   => $errno,
                "file"    => $errfile,
                "line"    => $errline
            );
            $this->log($errstr, $priority, $extras);
        }

        if(!is_null($this->_origErrorHandler)) {
            return call_user_func(
                $this->_origErrorHandler,
                $errno,
                $errstr,
                $errfile,
                $errline,
                $errcontext
            );
        }

        return false;
    }

    /**
     * Adds a writer to the que of writers
     *
     * @param Log\Writer $writer
     * @return $this
     */
    public function addWriter(Log\Writer $writer)
    {
        $this->_writers[] = $writer;
        return $this;
    }

    /**
     * Destructor
     */
    public function __destruct()
    {
        foreach($this->_writers as $writer) {
            $writer->shutdown();
        }
    }

    /**
     * Undefined method handler allows for shortcut calls
     *
     * @param $method
     * @param $params
     * @throws Log\NoMessageException
     * @throws Log\InvalidPriorityException
     */
    public function __call($method, $params)
    {
        /** @var string|int $priority */
        $priority = strtoupper($method);

        if(($priority = array_search($priority, $this->_priorities)) !== false) {
            switch(count($params)) {
                case 0:
                    require_once "Log/NoMessageException.php";
                    throw new Log\NoMessageException();
                    break;
                case 1:
                    $message = array_shift($params);
                    $extras  = null;
                    break;
                default:
                    $message = array_shift($params);
                    $extras  = array_shift($params);
                    break;
            }
            $this->log($message, $priority, $extras);
        } else {
            throw new Log\InvalidPriorityException;
        }
    }
} 