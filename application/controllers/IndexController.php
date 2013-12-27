<?php
class IndexController extends \Kivi\Controller\Base
{
	protected function _init()
	{
		
	}
	
	public function indexAction()
	{
		$this->view->disableLayout();
        $this->view->render();
	}
}