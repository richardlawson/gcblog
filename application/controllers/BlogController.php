<?php

class BlogController extends Zend_Controller_Action
{
	protected $_em;
	
    public function init()
    {
       $registry = Zend_Registry::getInstance();
       $this->_em = $registry->em;
       $this->view->menuItem = $registry->properties->menuitem->none->id;
    }

    public function indexAction()
    {
    	$id = (int) $this->_getParam('id', 0);
        $blogEntry = $this->_em->find('GC\Entity\BlogEntry', $id);
        if(!is_null($blogEntry)){
        	$this->view->blogEntry = $blogEntry;
        }else{
        	 $this->_helper->viewRenderer('notfound');  
        }
    }
    
	public function searchAction(){
		$searchTerm = '';
		$this->view->blogEntries = array();
		if($this->getRequest()->isPost()){
    		$searchTerm = (string) $this->_getParam('search-term', '');
    		$this->view->blogEntries = $this->_em->getRepository('GC\Entity\BlogEntry')->doKeywordSearch($searchTerm);
    		$this->view->searchTerm = $searchTerm;
		}
    }
    
    public function notfoundAction(){
    }


}

