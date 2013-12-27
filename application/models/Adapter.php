<?php
namespace Model;

require_once "Article.php";
require_once "Articles.php";

/**
 * Class Adapter
 *
 * @category RefGen
 * @package  Model
 * @author   Vikram
 * @version  1.0.1
 * @abstract
 */
abstract class Adapter {
    /**
     * @var int maximum authors to include in citation
     */
    private $_maxAuthors   = 6;

    /**
     * @var bool indicates whether to include month in citation
     */
    private $_includeMonth = true;

    /**
     * @var bool indicates whether to include issue number in citation
     */
    private $_includeIssue = true;

    /**
     * @var int number of results per page
     */
    private $_maxResults = 10;

    /**
     * @var int used in pagination to select the current starting number
     */
    private $_start      = 0;

    /**
     * @var int total number of results available in the database
     */
    private $_count      = 0;

    /**
     * @var int holds the current page number
     */
    private $_page       = 1;

    /**
     * @var bool enables whether to use cache or not
     */
    protected $_cacheable = true;

    /**
     * constant for namespace to use in session
     */
    const CACHE_NAMESPACE = "article_cache";

    /**
     * Constructor
     */
    public function __construct()
    {
    }

    /**
     * Parses the multi dimensional data array into corresponding objects - Articles or Article.
     *
     * @param array $data
     * @return Article|Articles|null based on the number of articles
     */
    protected function _parseData($data = null)
    {
        /** @var null|Article|Articles $result */
        $result = null;
		if(is_array($data)) {
			if(count($data) === 1) {
				$result = new Article($data[0], $this->_maxAuthors, $this->_includeMonth, $this->_includeIssue);
			} else if(count($data) > 1) {
				$result = new Articles(
					$data,
					$this->_count,
					$this->_page,
					$this->_maxResults,
					$this->_maxAuthors,
					$this->_includeMonth,
					$this->_includeIssue
				);
			}
		}
        // if cache enabled, cache the result
        if(!is_null($result) && $this->_cacheable) {
            $this->_cacheResult($result);
        }

        return $result;
    }

    /**
     * Searches an article by id.
     *
     * @param $id id of the article
     * @return Article|null
     */
    abstract public function searchById($id);

    /**
     * Searches articles based on the query term.
     *
     * @param string $term search term
     * @param int $page current page number
     * @return Articles|Article|null
     */
    abstract public function searchByTerm($term, $page=1);

    /**
     * Sets maximum number of results
     *
     * @param int $max
     * @return $this for chaining
     */
    public function setMaxResults($max = 10)
    {
        $max = (int) $max;
        if($max > 4) {
            $this->_maxResults = $max;
        }
        return $this;
    }

    /**
     * Sets the maximum authors in citation
     *
     * @param int $max
     * @return $this for chaining
     */
    public function setMaxAuthors($max = 6)
    {
        $max = (int) $max;
        if($max > 1) {
            $this->_maxAuthors = $max;
        }
        return $this;
    }

    /**
     * Sets whether to include issue number in citation
     *
     * @param bool $yn
     * @return $this for chaining
     */
    public function includeIssue($yn = true)
    {
        $this->_includeIssue = (bool) $yn;
        return $this;
    }

    /**
     * Sets whether to include month in citation
     *
     * @param bool $yn
     * @return $this for chaining
     */
    public function includeMonth($yn = true)
    {
        $this->_includeMonth = (bool) $yn;
        return $this;
    }

    /**
     * setter for page
     *
     * @param int $page
     * @return $this for chaining
     * @throws \OutOfBoundsException when current page number is greater than total pages
     */
    public function setPage($page = 1)
    {
        $page = (int) $page;
        if($page > 0) {
            $this->_page = $page;
            $this->_start = ($page - 1) * $this->_maxResults;

        }
        return $this;
    }

    /**
     * Sets the total number of results
     *
     * @param int $count
     * @return $this for chaining
     */
    public function setCount($count = 0)
    {
        $count = (int) $count;
        if($count > 0) {
            $this->_count = $count;
        }
        return $this;
    }

    /**
     * Getter for start
     *
     * @return int
     */
    public function getStart()
    {
        return $this->_start;
    }

    /**
     * Getter for _maxResults
     *
     * @return int
     */
    public function getMaxResults()
    {
        return $this->_maxResults;
    }

    /**
     * Enables storing the results
     *
     * return $this
     */
    public function disableCache()
    {
        $this->_cacheable = true;
        return $this;
    }

    /**
     * Disables cache
     *
     * return $this;
     */
    public function enableCache()
    {
        $this->_cacheable = false;
        return $this;
    }

    /**
     * cache the result
     *
     * @param Artilce|Articles $result
     */
    protected function _cacheResult($result)
    {
        if(session_id() == "") {
            session_start();
        }
        $_SESSION[self::CACHE_NAMESPACE] = array();

        if($result instanceof Article) {
            $_SESSION[self::CACHE_NAMESPACE][$result->pmid] = $result;
        } else if($result instanceof Articles) {
            foreach($result as $article) {
                $_SESSION[self::CACHE_NAMESPACE][$article->pmid] = $article;
            }
        }
    }

    protected function _searchCache($id)
    {
        if(session_id() == "") {
            session_start();
        }
        if(isset($_SESSION[self::CACHE_NAMESPACE][$id])) {
            return $_SESSION[self::CACHE_NAMESPACE][$id];
        }
        return false;
    }
} 