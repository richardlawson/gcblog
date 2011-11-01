<?php
class Application_View_Helper_FetchCategories extends Zend_View_Helper_Abstract{
	
	protected $_em;
	
	public function fetchCategories(){
		$registry = Zend_Registry::getInstance();
       	$this->_em = $registry->em;
    	$this->buildCategories(); 
	}
	
	private function buildCategories(){
		$this->view->categories = $this->_em->getRepository('GC\Entity\Category')->findAllOrderedByPosition();
	}
}