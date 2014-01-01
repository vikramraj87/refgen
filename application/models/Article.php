<?php
namespace Model;
/**
 * Wrapper class around the data returned from pubmed
 */
class Article
{
    const PUBLISHED      = 1;
    const AHEAD_OF_PRINT = 2;

	protected $_publicationStatus;
	
	protected $_data = array(
		"pmid"          => "",
		"volume"        => "",
		"issue"         => "",
		"year"          => "",
		"month"         => "",
        "day"           => "",
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
	
	public function __construct(array $data   = array())
    {
        if(isset($data["pubstatus"])) {
            switch($data["pubstatus"]) {
                case "ppublish":
                case "epublish":
                    $this->_publicationStatus = self::PUBLISHED;
                    break;
                case "aheadofprint":
                    $this->_publicationStatus = self::AHEAD_OF_PRINT;
                    break;
            }
            unset($data["pubstatus"]);
        }
		if(!empty($data)) {
			foreach($data as $field => $value) {
				if(!array_key_exists($field, $this->_data)) {
					continue;
				}
				$this->_data[$field] = $value;
			}
		}
    }
	
	public function __get($field)
	{
		$lazyLoader = "get" . ucfirst($field);
		if(method_exists($this, $lazyLoader)) {
			return $this->$lazyLoader();
		}
		if(!array_key_exists($field, $this->_data)) {
			throw new \InvalidArgumentException("Property $field is not a valid property of class Article");
		}
		return $this->_data[$field];
	}
	
	public function __isset($field)
	{
		return isset($this->_data[$field]);
	}
	
    public function getJournalAbbr()
    {
        return $this->_data["journalabbrev"];
    }

    public function getTruncatedAbstract($limit = 300, $break = " ", $trailing = "...")
    {
        $truncated = implode(" ", $this->_data["abstract"]);
        if(strlen($truncated) > $limit) {
            $truncated = substr($truncated, 0, $limit - 1);
            $bp  = strrpos($truncated, $break);
            $truncated = substr($truncated, 0, $bp) . $trailing;
        }
        return $truncated;
    }

    public function getPublicationStatus()
    {
        return $this->_publicationStatus;
    }
}