<?php
namespace Model;
/**
 * Collection class of articles
 */
class Articles implements \IteratorAggregate
{
	protected $_maxAuthors   = 6;
	protected $_includeMonth = true;
	protected $_includeIssue = true;
	
	protected $_articles     = array();

	public function getIterator()
	{
		return new \ArrayIterator($this->_articles);
	}
	
	public function __construct(
		array $articles = null, 
		$maxAuthors = 6,
		$includeMonth = true,
		$includeIssue = true
	)
	{
		$this->_maxAuthors   = (int)     $maxAuthors;
		$this->_includeMonth = (boolean) $includeMonth;
		$this->_includeIssue = (boolean) $includeIssue;
		
		if(!is_null($articles) && count($articles) > 0) {
			foreach($articles as $article) {
				$this->_articles[$article["pmid"]] = new \Model\Article(
                    $article,
                    $this->_maxAuthors,
                    $this->_includeMonth,
                    $this->_includeIssue
                );
			}
		}
	}
}