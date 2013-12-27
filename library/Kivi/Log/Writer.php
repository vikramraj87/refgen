<?php
namespace Kivi\Log;


abstract class Writer {
    public function write ($event)
    {
        $this->_write($event);
    }

    public function shutdown()
    {

    }

    abstract protected function _write($event);
} 