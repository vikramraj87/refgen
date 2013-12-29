<?php
require_once "ResultController.php";
class AjaxController extends ResultController
{
    protected function _init()
    {
        session_start();
        /*
         * Check for ajax request else redirect the request to index page
         */
    }

    public function addAction()
    {
        $this->view->disableLayout();

        /** @var int $pmid */
        $pmid = $this->getParam("pmid") ? (int) $this->getParam("pmid") : 0;

        $output = array();

        if(!isset($_SESSION["list"][$pmid]) && $pmid) {
            /** @var \Model\Article|null $result */
            $result = $this->getAdapter()->searchById($pmid)->getResult();
            if($result) {
                $_SESSION["list"][$result->pmid] = $result;
                $output["pmid"] = $result->pmid;
            }
        }

        echo json_encode($output);

    }

    public function  delAction()
    {
        $this->view->disableLayout();

        /** @var int $pmid */
        $pmid = $this->getParam("pmid") ? (int) $this->getParam("pmid") : 0;

        $output = array("pmid" => $pmid);

        if(isset($_SESSION["list"][$pmid])) {
            unset($_SESSION["list"][$pmid]);
            $output["status"] = "ok";
        }
        echo json_encode($output);
    }

    public function sortAction()
    {

    }
}