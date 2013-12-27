<?php
namespace Kivi;

require_once "Config.php";

class ConfigTest extends \PHPUnit_Framework_TestCase {
    protected $_config;

    public function setUp()
    {
        $config = array(
            "controller" => array(
                "directory"          => "controllers",
                "default_controller" => "index",
                "default_action"     => "index"
            ),
            "view" => array(
                "type" => "Smarty",
                "config_directory"  => "configs/views",
                "compile_directory" => "views/compiled_tmp",
                "cache_directory"   =>"views/cache_dir",
                "layout" => array(
                    "directory" => "layouts",
                    "default"   => "twocol"
                )
            ),
            "result" => array(
                "per_page"      => 10,
                "display_pages" => 10,
                "article" => array(
                    "max_authors"   => 6,
                    "include_month" => "yes",
                    "include_issue" => "yes"
                )
            ),
            "log" => array(
                "writers" => array(
                    "writer" => array(
                        "type"     => "db",
                        "username" => "root",
                        "password" => "K1rth1k@s1n1",
                        "schema"   => "log",
                        "table"    => "event_log"
                    )
                )
            )
        );
        $this->_config = new Config($config);
    }

    public function testCount()
    {
        $this->assertEquals(4, count($this->_config));
    }

    public function testMagicIsset()
    {
        $this->assertTrue(isset($this->_config->log));
        $this->assertTrue(isset($this->_config->log->writers));
        $this->assertTrue(isset($this->_config->log->writers->writer));
        $this->assertTrue(isset($this->_config->log->writers->writer->type));
    }

    public function testMagicGetter()
    {
        $writer_config = $this->_config->log->writers->writer;
        $this->assertTrue($writer_config instanceof Config);
        $this->assertEquals("db", $writer_config->type);
    }

    public function testToArray()
    {
        $config_array = $this->_config->toArray();
        $this->assertTrue(isset($config_array["log"]["writers"]));
        $this->assertEquals("event_log", $config_array["log"]["writers"]["writer"]["table"]);
    }


    public function tearDown()
    {
        $this->_config = null;
    }

}
 