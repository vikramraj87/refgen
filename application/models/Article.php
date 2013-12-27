<?php
namespace Model;
/**
 * Wrapper class around the data returned from pubmed
 */
class Article
{
	protected $_maxAuthors   = 6;
	protected $_includeMonth = true;
	protected $_includeIssue = true;
	
	protected $_data = array(
		"pmid"          => "",
		"volume"        => "",
		"issue"         => "",
		"year"          => "",
		"month"         => "",
		"pages"         => "",
		"issn"          => "",
		"journal"       => "",
		"journalabbrev" => "",
		"title"         => "",
		"abstract"      => array(),
		"affliation"    => "",
		"authors"       => array(),
		"articleid"     => "",
		"keywords"      => array()
	);
	
	public function __construct(
		array $data   = null, 
		$maxAuthors   = 6, 
		$includeMonth = true, 
		$includeIssue = true
	)
	{
		if($data != null) {
			foreach($data as $field => $value) {
				if(!array_key_exists($field, $this->_data)) {
					continue;
				}
				$this->_data[$field] = $value;
			}
		}
		$this->_maxAuthors   = (int)     $maxAuthors;
		$this->_includeMonth = (boolean) $includeMonth;
		$this->_includeIssue = (boolean) $includeIssue;
	}
	
	public function __get($field)
	{
		$lazyLoader = "get" . ucfirst($field);
		if(method_exists($this, $lazyLoader)) {
			return $this->$lazyLoader();
		}
		if(!array_key_exists($field, $this->_data)) {
			throw new Exception("Property $field is not a valid property of class Article");
		}
		return $this->_data[$field];
	}
	
	public function __isset($field)
	{
		return isset($this->_data[$field]);
	}
	
	/**
	 * Turns Array into CSV. Also adds et al at the end if needed
	 */
	public function getAuthorsAsCSV($truncate = true)
	{
		if(empty($this->authors)) {
			return "";
		}
		
		$authors = $this->authors;
		
		if($this->_maxAuthors != 0 && count($authors) > $this->_maxAuthors && $truncate) {
			$authors = array_slice($this->authors, 0, $this->_maxAuthors);
			$authors[] = "et al";
		}
		
		return implode(", ", $authors);
	}
	
	
	
	/**
	 * Removes full stop between journal abbr
	 * J. Virol. => J Virol
	 */
	public function getJournalAbbr()
	{
		return preg_replace("/\./", "", $this->journalabbrev);
	}
	
	/**
	 * Constructs the citation and returns it
	 */
	public function getVancouverCitation()
	{
		$retVal = "";
		if(!empty($this->authors)) {
			$retVal .= $this->authorsAsCSV . ". ";
		}
		$retVal .= sprintf(
			"%s %s. %s",
			$this->title,
			$this->journalAbbr,
			$this->year
		);
		if(!empty($this->month) && $this->_includeMonth) {
			$retVal .= " " . $this->month;
		}
		if(!empty($this->volume)) {
			$retVal .= ";" . $this->volume;
			if(!empty($this->issue) && $this->_includeIssue) {
				$retVal .= sprintf("(%s)", trim($this->issue));
			}
		}
		if(!empty($this->pages)) {
			$retVal .= ":" . $this->pages;
		}
		return $retVal;
	}
	
	/**
	 * Get truncated abstract of specified length
	 */
	public function getTruncatedAbstract($limit = 300, $break = " ", $trailing = "...")
	{
		$truncated = implode(" ", $this->abstract);
		
		if(strlen($truncated) > $limit) {
			$truncated  = substr($truncated, 0, $limit - 1);
			$breakPoint = strrpos($truncated, $break);
			$truncated  = substr($truncated, 0, $breakPoint) . $trailing;
		}
		return $truncated;
	}
	
	public function getFooter()
	{
		$footer  = "";
		$footer  = "Published in " . $this->journal;
		$footer .= isset($this->volume) ? " Vol: " . $this->volume : "";
		$footer .= isset($this->pages)  ? " Pages: " . $this->pages : "";
		$footer .= isset($this->year) ? " on " . $this->year : "";
		return $footer;
	}
}