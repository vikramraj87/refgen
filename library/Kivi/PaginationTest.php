<?php
namespace Kivi;

require_once "Pagination.php";

class PaginationTest extends \PHPUnit_Framework_TestCase {
    protected $_pagination;
    public function setUp()
    {
        $this->_pagination = new Pagination(2,1010,20,12);
    }

    public function tearDown()
    {
        $this->_pagination = null;
    }

    public function testDisplayPages()
    {
        $this->assertEquals(11, count($this->_pagination->getIterator()));
    }
}
 