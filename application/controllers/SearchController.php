<?php
require "ResultController.php";
class SearchController extends ResultController
{
    protected function _init()
	{
        session_start();
    }

    /**
     * Controller action search index. Redirects the page to index
     */
    public function indexAction()
	{
		$this->_redirect("index", "index");
	}

    /**
     * Controller action to add articles to list
     */
    public function addAction()
    {
        /** @var int $pmid */
        $pmid = $this->getParam("pmid") ? (int) $this->getParam("pmid") : 0;

        /** @var string $redirect redirect condition */
        $redirect = $this->getParam("redirect") ? $this->getParam("redirect") : "";

        if(!isset($_SESSION["list"][$pmid]) && $pmid) {
            /** @var \Model\Article|null $result */
            $result = null;

            $result = $this->getAdapter()->searchById($pmid)->getResult();

            if(!is_null($result)) {
                $_SESSION["list"][$result->pmid] = $result;
            }
        }
        header("Location: http://" . $_SERVER["HTTP_HOST"] . $redirect);
    }

    /**
     * Controller action to remove articles from list
     */
    public function removeAction()
    {
        /** @var int $pmid */
        $pmid = $this->getParam("pmid") ? (int) $this->getParam("pmid") : 0;

        /** @var string $redirect redirect condition */
        $redirect = $this->getParam("redirect") ? $this->getParam("redirect") : "";

        if(isset($_SESSION["list"][$pmid])) {
            unset($_SESSION["list"][$pmid]);
        }

        header("Location: http://" . $_SERVER["HTTP_HOST"] . $redirect);
    }

    /**
     * Controller action to display single article
     */
    public function displayAction()
    {
        /** @var int $pmid */
        $pmid = $this->getParam("pmid") ? (int) $this->getParam("pmid") : 0;

        if(!$pmid) {
            $this->_redirect("index", "index");
        }

        /** @var \Model\Article|null $result */
        $result = null;

        //View variables required for layout
        $this->view->layout->title  = "$pmid - kiv! reference generator";
        $this->view->layout->query  = "";
        $this->view->layout->addPartial("side", "side");

        //View variables require for side
        $this->view->list   = isset($_SESSION["list"]) ? $_SESSION["list"] : null;
        $this->view->query   = $pmid;

        /** @var \Model\PubMedAdapter $adapter */
        $adapter = $this->getAdapter();

        try {
            $result = $adapter->searchById($pmid)->getResult();
        } catch (\Model\PubMedNotAvailableException $e) {
            $this->view->heading = "Server error";
            $this->view->message = "There is error establishing communication with Pubmed server.";
            $this->view->message .= " Please try after some time.";
            return $this->view->render("error");
        }

        $template = "no-result";
        if($result instanceof \Model\Article) {
            $this->view->layout->title = $result->title . " - kiv! reference generator";
            $template  = "single-result";
        }

        $this->view->result  = $result;
        $this->view->adapter = $adapter;
        return $this->view->render($template);
    }

    /**
     * Controller action to display multiple articles
     */
    public function resultAction()
	{
        /** @var string $query Holds the search term */
       	$term = $this->getParam("term") ? urldecode($this->getParam("term")) : "";

		if(empty($term)) {
			$this->_redirect("index", "index");
		}

        /** @var int $page holds the page number */
		$page = $this->getParam("page") ? (int) $this->getParam("page") : 1;

        /** @var \Model\Article|\Model\Articles|\null $result */
        $result = null;

        /** @var \Model\PubMedAdapter $adapter */
		$adapter = $this->getAdapter();

        //View variables required for layout
        $this->view->layout->title  = "$term - kiv! reference generator";
        $this->view->layout->query  = $term;
        $this->view->layout->addPartial("side", "side");

        //View variables required for side
        $this->view->list   = isset($_SESSION["list"]) ? $_SESSION["list"] : null;
        $this->view->query  = urlencode($term);
        $this->view->page   = $page;

        try {
			if(preg_match("/^\d+$/", $term)) {
                $this->_redirect("display", "search", array("pmid" => $term));
			} else {
				$result = $adapter->searchByTerm($term, $page)->getResult();
			}
		} catch (\Model\PubMedNotAvailableException $e) {
			$this->view->heading = "Server error";
			$this->view->message = "There is error establishing communication with Pubmed server.";
			$this->view->message .= " Please try after some time.";
            return $this->view->render("error");
		}

        $template = "no-result";

        //TODO: Prevent second server redirect
        if($result instanceof \Model\Article) {
            $this->_redirect("display", "search", array("pmid" => $result->pmid));
		} else if($result instanceof \Model\Articles) {
			$template = "multiple-results";
			$this->view->pagination = new \Kivi\Pagination(
                $adapter->getPage(),
                $adapter->getCount(),
                $adapter->getMaxResults(),
                $adapter->getDisplayPages()
            );
		}

        $this->view->result  = $result;
        $this->view->adapter = $adapter;

		return $this->view->render($template);
    }
}