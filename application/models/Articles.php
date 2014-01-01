<?php
namespace Model;
/**
 * Collection class of articles
 */
class Articles implements \IteratorAggregate
{
	protected $_articles     = array();

	public function getIterator()
	{
		return new \ArrayIterator($this->_articles);
	}
	
	public function __construct(array $articles = null)
	{
		if(!is_null($articles) && count($articles) > 0) {
			foreach($articles as $article) {
				$this->_articles[$article["pmid"]] = new \Model\Article($article);
			}
		}
	}
}