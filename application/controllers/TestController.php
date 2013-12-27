<?php
class TestController extends \Kivi\Controller\Base
{
	protected function _init()
	{
		echo "inside test controller";
	}
	
	public function indexAction()
	{
		echo "inside test::index";
	}
	
	public function searchAction()
	{
		echo "inside test::search";
	}
}