<?php
namespace Model;


class PubMedMock extends PubMedAdapter
{
    /**
     * @param id $id
     * @return $this
     * @throws PubMedNotAvailableException
     */
    public function searchById($id)
    {
        /** @var string $local_file holds the file name of the local test xml*/
        $local_file = "http://thost/sample/multiple.xml";

        /** @var string $str_xml results as xml */
        $str_xml   = @file_get_contents($local_file);

        if($str_xml === false) {
            throw new PubMedNotAvailableException();
        }

        /** @var \SimpleXMLElement $xml */
        $xml = new \SimpleXMLElement($str_xml);

        /** @var array $ds data in two dimensional array */
        $ds = $this->_parse($xml);

        /** @var array $data indexed array containing pmid as key */
        $data = array();

        foreach($ds as $d) {
            $data[$d["pmid"]] = $d;
        }

        /** @var array|null $result */
        $result = array();

        $result[0] = isset($data[$id]) ? $data[$id] : null;

        $this->_parseData($result);
        return $this;
    }

    /**
     * @param string $term
     * @param int $page
     * @return $this
     * @throws PubMedNotAvailableException
     */
    public function searchByTerm($term, $page = 1)
    {
        /** @var string $local_file holds the file name of the local test xml*/
        $local_file = "http://thost/sample/multiple.xml";

        /** @var string $str_xml results as xml */
        $str_xml   = @file_get_contents($local_file);

        if($str_xml === false) {
            throw new PubMedNotAvailableException();
        }

        /** @var \SimpleXMLElement $xml */
        $xml = new \SimpleXMLElement($str_xml);

        /** @var array $results article data as array */
        $results = $this->_parse($xml);

        //set the total number of results
        $this->setCount($xml->Count);

        $this->_parseData($results);
        return $this;
    }
} 