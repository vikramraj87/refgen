<?php
namespace Kivi;

/**
 * Holds the logic regarding pagination
 *
 * @category Kivi
 * @version 1.0.1
 * @author Vikram
 */
class Pagination implements \IteratorAggregate
{
    /**
     * @var int current page of the results
     */
    protected $_currPage       = 0;

    /**
     * @var int total number of results returned from the server
     */
    protected $_totalResults   = 0;

    /**
     * @var int number of results per page
     */
    protected $_resultsPerPage = 0;

    /**
     * @var int starting page in the pagination
     */
    protected $_start = 0;

    /**
     * @var int end page in the pagination
     */
    protected $_end   = 0;

    /**
     * @var int total pages that will be required to display all results
     */
    protected $_totalPages;

    /**
     * @var int number of pages to be shown in the pagination
     */
    protected $_displayPages;

    /**
     * @var int[] to hold all the pages to be displayed in the bottom
     */
    protected $_pages = array();

    /**
     * Constructor
     *
     * @param int $currPage       the current page of the results
     * @param int $totalResults   total number of results returned from the server
     * @param int $resultsPerPage number of results per page
     * @param int $displayPages   number of pages to be shown in the pagination
     */
    public function __construct($currPage, $totalResults, $resultsPerPage, $displayPages = 9)
	{
		$this->_currPage       = $currPage;
		$this->_totalResults   = $totalResults;
		$this->_resultsPerPage = $resultsPerPage;

        if($displayPages % 2 == 0) {
            $displayPages--;
        }
        $this->_displayPages = $displayPages;
        $middle = ($displayPages - 1) / 2;
		$this->_totalPages = ceil($this->_totalResults/$this->_resultsPerPage);
		
		if($this->_totalPages <= $this->_displayPages) {
			$this->_start = 1;
			$this->_end   = $this->_totalPages; 
		} else {
			if($this->_currPage + $middle <= $this->_totalPages && $this->_currPage - $middle > 0) {
				$this->_start = $this->_currPage - $middle;
				$this->_end   = $this->_currPage + $middle;
			} else if($this->_currPage + $middle > $this->_totalPages && $this->_currPage - $middle > 0) {
				$this->_end   = $this->_totalPages;
				$this->_start = $this->_end - ($middle * 2);
			} else {
				$this->_start = 1;
				$this->_end   = $this->_start + ($middle * 2);
			}
		}
		for($i = $this->_start; $i <= $this->_end; $i++) {
			$this->_pages[] = $i;
		}
	}
	
	public function isFirst()
	{
		return $this->_currPage > 2 && $this->_start != 1;
	}


    /**
     * @return bool|int previous page number. false if there is no previous page
     */
    public function getPrev()
	{
		if($this->_currPage > 1) {
			return $this->_currPage - 1;
		}
		return false;
	}

    /**
     * @return bool|int next page number. false if there is no next page
     */
    public function getNext()
	{
		if($this->_currPage < $this->_totalPages) {
			return $this->_currPage + 1;
		}
		return false;
	}

    /**
     * @return int the current page of the results
     */
    public function getCurrPage()
	{
		return $this->_currPage;
	}

    /**
     * @return \ArrayIterator|\Traversable the array iterator for the pages array
     */
    public function getIterator()
	{
		return new \ArrayIterator($this->_pages);
	}

    /**
     * @return bool tells whether necessary to display pagination
     */
    public function isRequired()
	{
		return $this->_start < $this->_end;
	}
}