<?php
namespace Kivi;

class Pagination implements \IteratorAggregate
{
	protected $_currPage       = 0;
	protected $_totalResults   = 0;
	protected $_resultsPerPage = 0;
	
	protected $_start = 0;
	protected $_end   = 0;
	protected $_curr  = 1;
	
	protected $_totalPages;
    protected $_displayPages;
	protected $_pages = array();
	
	
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
	
	public function getPrev()
	{
		if($this->_currPage > 1) {
			return $this->_currPage - 1;
		}
		return false;
	}
	
	public function getNext()
	{
		if($this->_currPage < $this->_totalPages) {
			return $this->_currPage + 1;
		}
		return false;
	}
	
	public function getCurrPage()
	{
		return $this->_currPage;
	}
	
	public function getIterator()
	{
		return new \ArrayIterator($this->_pages);
	}
	
	public function isRequired()
	{
		return $this->_start < $this->_end;
	}
}