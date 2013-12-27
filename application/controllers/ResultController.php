<?php

class ResultController extends \Kivi\Controller\Base {
    /**
     * @var \Model\PubMedAdapter|null
     */
    protected $_adapter = null;

    /**
     * @return \Model\Adapter
     */
    protected function getAdapter()
    {
        if(!$this->_adapter instanceof \Model\Adapter) {
            $this->_adapter = new \Model\PubMedMock;
            if(isset($this->getRegistry()->config->result)) {
                /** @var \SimpleXMLElement $rc */
                $rc = $this->getRegistry()->config->result;

                /** @var int $maxResults number of results per page */
                $maxResults = isset($rc->per_page) ? (int) $rc->per_page : 10;

                /** @var int $maxAuthors */
                $maxAuthors = isset($rc->article->max_authors) ? (int) $rc->article->max_authors : 6;

                /** @var bool $incMonth */
                $incMonth = isset($rc->article->include_month) ? (bool) (string) $rc->article->include_month : true;

                /** @var bool $incIssue */
                $incIssue = isset($rc->article->include_issue) ? (bool) (string) $rc->article->include_issue : true;

                $this->_adapter->setMaxResults($maxResults)
                    ->setMaxAuthors($maxAuthors)
                    ->includeIssue($incIssue)
                    ->includeMonth($incMonth);
            }
        }
        return $this->_adapter;
    }
} 