<?php
namespace Kivi\Config;

require_once dirname(__FILE__) . "/../Config.php";
require_once "SectionNotFoundException.php";
require_once "Exception.php";
require_once "Xml.php";

class XmlTest extends \PHPUnit_Framework_TestCase {
    protected $_xml;

    public function setUp()
    {
        $this->_xml  = <<<EOT
<?xml version="1.0"?>
        <config>
            <development>
                <controller>
                    <directory>Controllers</directory>
                    <default_controller value="index"></default_controller>
                    <default_action>index</default_action>
                </controller>
                <view type="Smarty" action="super">
                    <config_directory value="configs/views"></config_directory>
                    <compile_directory>views/compiled_tmp</compile_directory>
                    <cache_directory>views/cache_dir</cache_directory>
                    <layout default="twocol">
                        <directory>layouts</directory>
                    </layout>
                </view>
                <result>
                    <per_page>10</per_page>
                    <display_pages>10</display_pages>
                    <article>
                        <max_authors>6</max_authors>
                        <include_month>yes</include_month>
                        <include_issue>yes</include_issue>
                    </article>
                </result>
                <log>
                    <writers>
                        <writer type="db">
                            <username>root</username>
                            <password>K1rth1k@s1n1</password>
                            <schema>log</schema>
                            <table>event_log</table>
                        </writer>
                    </writers>
                </log>
            </development>
            <production extends="development">
                <controller>
                    <directory>MainControllers</directory>
                </controller>
                <result>
                    <article>
                        <max_authors>4</max_authors>
                    </article>
                </result>
            </production>
            <testing extends="production">
                <view>
                    <type>Beauty</type>
                </view>
                <result>
                    <article>
                        <max_authors>8</max_authors>
                        <include_month>no</include_month>
                    </article>
                </result>
            </testing>
            <invalid_ref extends="abc">
            </invalid_ref>

            <circularA extends="circularC">
                <test>Must Fail</test>
            </circularA>
            <circularB extends="circularA">
            </circularB>
            <circularC extends="circularB">
            </circularC>
        </config>
EOT;


    }

    public function testToArray()
    {
        $config = new Xml($this->_xml, "development");
        $this->assertTrue(isset($config->controller->directory));
        $this->assertEquals("event_log", $config->log->writers->writer->table);
        $this->assertEquals("twocol", $config->view->layout->default);

        $arr = $config->toArray();
        $this->assertTrue(isset($arr["controller"]["directory"]));
        $this->assertEquals("event_log", $arr["log"]["writers"]["writer"]["table"]);
        $this->assertEquals("Smarty", $arr["view"]["type"]);
    }

    public function testExtendsOneLevel()
    {
        $config = new Xml($this->_xml, "production");
        $this->assertEquals("index", $config->controller->default_controller);
        $this->assertEquals("MainControllers", $config->controller->directory);

        $arr = $config->toArray();
        $this->assertEquals("Smarty", $arr["view"]["type"]);
        $this->assertEquals("4", $arr["result"]["article"]["max_authors"]);
    }

    public function testExtendsMultipleLevel()
    {
        $config = new Xml($this->_xml, "testing");
        $this->assertEquals("index", $config->controller->default_action);
        $this->assertEquals("8", $config->result->article->max_authors);

        $arr = $config->toArray();
        $this->assertEquals("Beauty", $arr["view"]["type"]);
        $this->assertEquals("db", $arr["log"]["writers"]["writer"]["type"]);
    }

    public function testInvalidReference()
    {
        try {
            $config = new Xml($this->_xml, "invalid_ref");
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof SectionNotFoundException);
        }
    }

    public function multipleSections()
    {
        $config = new Xml($this->_xml, array("testing", "production"));
        $this->_assertEquals("index", $config->testing->controller->default_controller);
    }

    public function invalidSection()
    {
        try {
            $config = new Xml($this->_xml, "test");
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof SectionNotFoundException);
        }
    }

    public function multipleInvalidSections()
    {
        try {
            $config = new Xml($this->_xml, array("production", "test"));
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof SectionNotFoundException);
        }
    }

    public function testCircularReference()
    {
        try {
            $config = new Xml($this->_xml, array("circularC"));
        } catch (\Exception $e) {
            $this->assertTrue($e instanceof CircularReferenceException);
        }
    }
}
 