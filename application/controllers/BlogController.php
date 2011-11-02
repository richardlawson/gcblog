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
        	$form = new Application_Form_Comment();
			if($this->getRequest()->isPost()){
				try{
					$this->validateAndSaveComment($form, $blogEntry);	
				}catch(Exception $e){
	        	}
			}
			$this->view->blogEntry = $blogEntry;
	    	$this->view->form = $form;
        }else{
        	 $this->_helper->viewRenderer('notfound');  
        }
    }
    
	private function validateAndSaveComment(Zend_Form $form, GC\Entity\BlogEntry $blogEntry){
    	$this->validateCommentForm($form);
       	$this->saveComment($form, $blogEntry);
    }
    
	private function validateCommentForm(Zend_Form $form){
		if(!$form->isValid($this->_request->getPost())){
			throw new Exception('Form Data Invalid'); 
		}
    }
    
	private function saveComment(Zend_Form $form, GC\Entity\BlogEntry $blogEntry){
		$comment = new GC\Entity\Comment($form->getValues());
		$comment->blogEntry = $blogEntry;
		$this->_em->persist($comment);
		$this->_em->flush();
		// clear form values
		$form->populate(array('name' => '', 'email' => '', 'content' => ''));
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

