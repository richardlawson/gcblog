<?php

class Admin_CommentController extends Zend_Controller_Action
{
	protected $_em;
    
	public function preDispatch(){
		if(!$this->_helper->auth->isAuthorized()){
			$this->_helper->redirector->gotoRoute(array(), 'login');
		}
	}
	
	public function init()
    {
       $registry = Zend_Registry::getInstance();
       $this->_em = $registry->em;
    }
	
    public function indexAction(){
    	$this->view->selectedMenuItem = 0;
 		$this->view->blogEntry = $this->_em->find('GC\Entity\BlogEntry', (int) $this->_getParam('id'));
    }
	
	public function deleteAction(){
    	$this->_helper->viewRenderer->setNoRender();
      	$this->_helper->layout->disableLayout();
		if($this->getRequest()->isPost()){
			$responseStatus = 'DELETED';
			try{
				$ids = $this->_getParam('ids');
				foreach($ids as $id){
					$comment = $this->_em->find('GC\Entity\Comment', (int) $id);
					$this->_em->remove($comment);
				}
				$this->_em->flush();
			}catch(Exception $e){
				$responseStatus = 'FAILED';
			}
			echo Zend_Json::encode(array('responseStatus' => $responseStatus));
		}
	}
}

