<?php
namespace Kivi;

require_once "Pagination.php";

class PaginationTest extends \PHPUnit_Framework_TestCase {
    public function testTotalPagesLessThanDisplayPagesBeginningPageOne()
    {
        //1 2 3 4 5 6 7 8 9 10
        $pagination = new Pagination(1,100,10,12);
        $pages = $pagination->getIterator();
        $this->assertEquals(10, $pages->count());
        $pages->seek($pages->count() - 1);
        $this->assertEquals(10, $pages->current());
        $pages->rewind();
        $this->assertEquals(1, $pages->current());

        //1 2 3 4 5 6 7
        $pagination = new Pagination(2,70,10,10);
        $pages = $pagination->getIterator();
        $this->assertEquals(7, $pages->count());
        $pages->seek($pages->count() - 1);
        $this->assertEquals(7, $pages->current());
        $pages->rewind();
        $this->assertEquals(1, $pages->current());
    }

    public function testTotalPagesGreaterThanDisplayPages()
    {
        //1 2 3 4 5 6 7 8 9
        $pagination = new Pagination(2,170,10,10);
        $pages = $pagination->getIterator();
        $this->assertEquals(9, $pages->count());
        $pages->seek($pages->count() - 1);
        $this->assertEquals(9, $pages->current());
        $pages->rewind();
        $this->assertEquals(1, $pages->current());

        //1 2 3 4 5 6 7 8 9 10 11
        $pagination = new Pagination(6,170,10,12);
        $pages = $pagination->getIterator();
        $this->assertEquals(11, $pages->count());
        $pages->seek($pages->count() - 1);
        $this->assertEquals(11, $pages->current());
        $pages->rewind();
        $this->assertEquals(1, $pages->current());

        //3 4 5 6 7 8 9 10 11 12 13
        $pagination = new Pagination(8,170,10,12);
        $pages = $pagination->getIterator();
        $this->assertEquals(11, $pages->count());
        $pages->seek($pages->count() - 1);
        $this->assertEquals(13, $pages->current());
        $pages->rewind();
        $this->assertEquals(3, $pages->current());

        //7 8 9 10 11 12 13 14 15 16 17
        $pagination = new Pagination(14,170,10,12);
        $pages = $pagination->getIterator();
        $this->assertEquals(11, $pages->count());
        $pages->seek($pages->count() - 1);
        $this->assertEquals(17, $pages->current());
        $pages->rewind();
        $this->assertEquals(7, $pages->current());
    }
}
 