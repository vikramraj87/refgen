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
            /*
            if(isset($this->getRegistry()->config->result)) {
                $options = $this->getRegistry()->config->result->toArray();
                $this->_adapter = \Model\PubMedAdapter::factory($options);
            } else {
                $this->_adapter = new \Model\PubMedAdapter;
            }*/
            $this->_adapter = new \Model\PubMedMock;
        }
        return $this->_adapter;
    }
}