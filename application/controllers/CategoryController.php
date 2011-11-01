<?php
use Doctrine\Common\Collections\ArrayCollection;
class CategoryController extends Zend_Controller_Action
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
    	$page = (int) $this->_getParam('page', 1);
        $category = $this->_em->find('GC\Entity\Category', $id);
        if(!is_null($category)){
        	$this->view->category = $category;
        }else{
        	 $this->_helper->viewRenderer('notfound');  
        	 return;
        }
        $this->view->blogPaginator = $this->getBlogPaginator($category->blogEntries, $page); 
    }
    
    public function getBlogPaginator($blogEntries, $page, $itemCountPerPage = 2){
    	$page = (int) $page;
		$itemCountPerPage = (int) $itemCountPerPage;
		$paginator = new Zend_Paginator(new GC\Util\ArrayCollectionPaginatorAdapter($blogEntries));
		$paginator->setCurrentPageNumber($page);
		$paginator->setItemCountPerPage($itemCountPerPage);
		return $paginator;
    }
    
    public function notfoundAction(){
    }


}

