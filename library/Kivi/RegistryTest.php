<?php
namespace Kivi;

require_once "Registry.php";

class RegistryTest extends \PHPUnit_Framework_TestCase {
    protected $_registry;

    public function setUp()
    {
        $this->_registry = Registry::getInstance();
    }

    public function testRegistryEntry()
    {
        $this->_registry->test = "test";
        $this->assertEquals("test", $this->_registry->test);

        $this->assertTrue(isset($this->_registry->test));

        $this->assertFalse(isset($this->_registry->abc));

        unset($this->_registry->test);
        $this->assertFalse(isset($this->_registry->test));
    }

    public function testRegistryEntryNotFound()
    {
        try {
            $a = $this->_registry->abc;
        } catch (Exception $e) {
            $this->assertTrue($e instanceof \Exception);
            $this->assertTrue($e instanceof Exception);
            $this->assertTrue($e instanceof Registry\EntryNotFoundException);
        }
    }

    public function tearDown()
    {
        $this->_registry = null;
    }
}
 