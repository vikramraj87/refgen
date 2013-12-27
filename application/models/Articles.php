<?php
namespace Model;
/**
 * Collection class of articles
 */
class Articles implements \IteratorAggregate, \Countable
{
	protected $_maxAuthors   = 6;
	protected $_includeMonth = true;
	protected $_includeIssue = true;
	
	protected $_articles     = array();
	protected $_count        = 0;
	protected $_currPage     = 1;
	protected $_itemsPerPage = 10;
	
	public function getIterator()
	{
		return new \ArrayIterator($this->_articles);
	}
	
	public function count()
	{
		return $this->_count;
	}
	
	public function getCount()
	{
		return $this->_count;
	}
	
	public function getCurrPage()
	{
		return $this->_currPage;
	}
	
	public function getItemsPerPage()
	{
		return $this->_itemsPerPage;
	}
	
	public function __construct(
		array $articles = null, 
		$count = 0, 
		$currPage = 1,
		$itemsPerPage = 10,
		$maxAuthors = 6, 
		$includeMonth = true,
		$includeIssue = true
	)
	{
		$this->_count        = (int)     $count;
		$this->_currPage     = (int)     $currPage;
		$this->_itemsPerPage = (int)     $itemsPerPage;
		
		$this->_maxAuthors   = (int)     $maxAuthors;
		$this->_includeMonth = (boolean) $includeMonth;
		$this->_includeIssue = (boolean) $includeIssue;
		
		if(!is_null($articles) && count($articles) > 0) {
			foreach($articles as $article) {
				$this->_articles[(int)$article["pmid"]] = new \Model\Article($article, $this->_maxAuthors, $this->_includeMonth, $this->_includeIssue);
			}
		}
	}
}