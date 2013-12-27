<?php
namespace Model;

require_once "Adapter.php";
require_once "PubMedNotAvailableException.php";

/**
 * Pubmed adapter to get results from pubmed
 *
 * @category RefGen
 * @package  Model
 * @author   Vikram
 * @version  1.0.1
 */
class PubMedAdapter extends Adapter
{
    /**
     * @var string url for searching term and getting pmids of the articles
     */
    private $_esearch = "http://eutils.ncbi.nlm.nih.gov/entrez/eutils/esearch.fcgi?";

    /**
     * @var string url for fetching the articles by pmids
     */
    private $_efetch = "http://eutils.ncbi.nlm.nih.gov/entrez/eutils/efetch.fcgi?";

    /**
     * @var string database to use
     */
    private $_db = "pubmed";

    /**
     * @var string return mode to use
     */
    private $_retMode = "xml";

    /**
     * Search by PMID
     *
     * @param id $id
     * @return Article|Articles|null
     */
    public function searchById($id)
	{
		$id = (string) $id;
        $result = null;
        if($this->_cacheable) {
            $result = $this->_searchCache($id);
        }

		if(empty($result)) {
			$result = $this->_queryByPmid($id);
            return $this->_parseData($result);
        }
        return $result;
    }

    /**
     * Search by term
     *
     * @param string $term
     * @param int $page
     * @return Article|Articles|null
     * @throws PubMedNotAvailableException
     */
    public function searchByTerm($term, $page = 1)
	{
		$term    = urlencode(stripslashes($term));
        $this->setPage($page);

        /** @var string[] $params required params to make connection */
		$params  = array(
			"db"       => $this->_db,
			"retmode"  => $this->_retMode,
			"retmax"   => $this->getMaxResults(),
			"retstart" => $this->getStart(),
			"term"     => $term
		);
        /** @var string $str_xml results as xml */
        $str_xml   = @file_get_contents($this->_esearch . $this->_generateQueryString($params));

		if($str_xml === false) {
			throw new PubMedNotAvailableException();
		}

        /** @var \SimpleXMLElement $xml */
		$xml = new \SimpleXMLElement($str_xml);

        //set the total number of results
        $this->setCount($xml->Count);

        /** @var array $results article data as array */
        $results = null;

		if(isset($xml->IdList->Id) && !empty($xml->IdList->Id)) {
			$ids = array();
			foreach($xml->IdList->children() as $id) {
				$ids[] = (string) $id;
			}
			$results = $this->_queryByPmid(implode(",",$ids));
		}
        return $this->_parseData($results);
	}

    /**
     * Fetches the articles in xml format for the id(s) provided
     *
     * @param string $id single or multiple ids in csv format
     * @return array
     * @throws PubMedNotAvailableException
     */
    protected function _queryByPmid($id)
	{
        /** @var string[] $params required params to make connection */
        $params  = array(
			"db"       => $this->_db,
			"retmode"  => $this->_retMode,
			"id"       => (string) $id
		);

        /** @var string $str_xml results as xml */
		$str_xml  = @file_get_contents($this->_efetch . $this->_generateQueryString($params));

        if($str_xml === false) {
			throw new PubMedNotAvailableException();
		}

        /** @var \SimpleXMLElement $xml */
		$xml  = new \SimpleXMLElement($str_xml);
		
		return $this->_parse($xml);
	}

    /**
     * parses simple xml element to array of required data
     *
     * @param \SimpleXMLElement $xml
     * @return array
     */
    protected function _parse(\SimpleXMLElement $xml)
	{
        /** @var mixed[] $data to hold the required data in two dimensional array */
		$data = array();

        foreach($xml->PubmedArticle as $article) {

            /** @var mixed[] $abstract to hold the abstract subheadings and paragraphs */
            $abstract = array();

            if (isset($article->MedlineCitation->Article->Abstract) &&
               !empty($article->MedlineCitation->Article->Abstract)
            )
            {
                /** @var \SimpleXMLElement[] $at */
                $at = $article->MedlineCitation->Article->Abstract->children();
                foreach($at as $para) {
                    /** @var mixed[] $attr */
                    $attr = $para->attributes();
                    if(isset($attr["Label"])) {
                        /** @var string $h subheading*/
                        $h = (string) $attr["Label"];
                        $abstract[$h] = (string) $para;
                    } else {
                        $abstract[] = (string) $para;
                    }
                }
            }

            /** @var string[] $authors to hold the authors of the article as array */
            $authors = array();

            if(isset($article->MedlineCitation->Article->AuthorList->Author)) {
                /** @var \SimpleXMLElement $auths */
                $auths = $article->MedlineCitation->Article->AuthorList->Author;

                try {
                    //Check if its iterable implying multiple values
                    foreach($auths as $author) {
                        $authors[] = (string) $author->LastName . " " . (string) $author->Initials;
                    }
                } catch (\Exception $e) {
                    //Its not iterable so only single author value is present
                    $authors[] = (string) $auths->LastName . " " . (string) $auths->Initials;
                }
            }

            /** @var array $keywords */
            $keywords = array();

            if(isset($article->MedlineCitation->MeshHeadingList->MeshHeading)) {
                foreach($article->MedlineCitation->MeshHeadingList->MeshHeading as $m) {
                    $keywords[] = (string) $m->DescriptorName;
                    if (isset($m->QualifierName)) {
                        if (is_array($m->QualifierName)) {
                            $keywords = array_merge($keywords,$m->QualifierName);
                        } else {
                            $keywords[] = (string)$m->QualifierName;
                        }
                    }
                }
            }

            /** @var string $articleId */
            $articleId = "";

            if(isset($article->PubmedData->ArticleIdList)) {
                /** @var array $ids hold ids*/
                $ids = array();
                foreach($article->PubmedData->ArticleIdList->ArticleId as $id) {
                    $ids[] = $id;
                }
                $articleId = implode(",", $ids);
            }

            $year  = (string) $article->MedlineCitation->Article->Journal->JournalIssue->PubDate->Year;
            $month = (string) $article->MedlineCitation->Article->Journal->JournalIssue->PubDate->Month;

            if(empty($year)) {
                if(isset($article->MedlineCitation->Article->Journal->JournalIssue->PubDate->MedlineDate)) {
                    /** @var string $mlDate */
                    $mlDate = (string) $article->MedlineCitation->Article->Journal->JournalIssue->PubDate->MedlineDate;

                    $p = explode(" ", $mlDate);
                    $year = $p[0];
                    if(isset($p[1])) {
                        $month = $p[1];
                    }
                }
            }

            $data[] = array(
                "pmid"          => (string) $article->MedlineCitation->PMID,
                "volume"        => (string) $article->MedlineCitation->Article->Journal->JournalIssue->Volume,
                "issue"         => (string) $article->MedlineCitation->Article->Journal->JournalIssue->Issue,
                "year"          =>          $year,
                "month"         =>          $month,
                "pages"         => (string) $article->MedlineCitation->Article->Pagination->MedlinePgn,
                "issn"          => (string) $article->MedlineCitation->Article->Journal->ISSN,
                "journal"       => (string) $article->MedlineCitation->Article->Journal->Title,
                "journalabbrev" => (string) $article->MedlineCitation->Article->Journal->ISOAbbreviation,
                "title"         => (string) $article->MedlineCitation->Article->ArticleTitle,
                "abstract"      =>          $abstract,
                "affiliation"   => (string) $article->MedlineCitation->Article->Affiliation,
                "authors"       =>          $authors,
                "articleid"     =>          $articleId,
                "keywords"      =>          $keywords
            );
        }
        return $data;
	}

    /**
     * Parameter array to query string
     *
     * @param array $params
     * @return string
     */
    private function _generateQueryString(array $params = array())
    {
        /** @var array $q tmp to hold the key=value pair */
        $q = array();

        if(count($params) > 0) {
            foreach($params as $k => $v) {
                $q[] = $k . "=" . $v;
            }
        }
        return implode("&", $q);
    }
}

