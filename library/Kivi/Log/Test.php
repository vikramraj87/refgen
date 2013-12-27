<?php
/**
 * Created by PhpStorm.
 * User: vikramraj
 * Date: 24/12/13
 * Time: 2:23 PM
 */

namespace Kivi\Log;

require_once dirname(__FILE__) . '/../Log.php';
require_once dirname(__FILE__) . '/NoWriterException.php';

class Test extends \PHPUnit_Framework_TestCase {
    protected $log;

    protected function setUp()
    {
        $this->log = new \Kivi\Log();
    }

    public function testNoWriterException()
    {
        try {
            $this->log->write();
        } catch (Exception $e) {
            $this->assertTrue($e instanceof \Kivi\Log\NoWriterException);
        }

    }

    protected function tearDown()
    {

    }
}
 