<?php

class Admin_IndexController extends Zend_Controller_Action
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
    	$this->view->selectedMenuItem = 1;
 		$this->view->categories = $this->_em->getRepository('GC\Entity\Category')->findAllOrderedByPosition();
    }
    
    
	public function reorderAction(){
    	$this->_helper->viewRenderer->setNoRender();
      	$this->_helper->layout->disableLayout();
		if($this->getRequest()->isPost()){
			$responseStatus = 'SAVED';
			try{
				$this->_em->getRepository('GC\Entity\Category')->reorder($this->_getParam('id'), $this->_getParam('reorderType'));
			}catch(Exception $e){
				$responseStatus = 'FAILED';
			}
			echo Zend_Json::encode(array('responseStatus' => $responseStatus));
		}
	}
	
	public function deleteAction(){
    	$this->_helper->viewRenderer->setNoRender();
      	$this->_helper->layout->disableLayout();
		if($this->getRequest()->isPost()){
			$responseStatus = 'DELETED';
			try{
				$ids = $this->_getParam('ids');
				foreach($ids as $id){
					$this->_em->getRepository('GC\Entity\Category')->delete((int) $id);
				}
			}catch(Exception $e){
				$responseStatus = 'FAILED';
			}
			echo Zend_Json::encode(array('responseStatus' => $responseStatus));
		}
	}
	
 	public function addAction(){
    	$this->view->selectedMenuItem = 2;
		$form = new Admin_Form_Category();
		if($this->getRequest()->isPost()){
			try{
				$this->validateAndSave($form);	
				return $this->_helper->redirector->gotoRoute(array(), 'category-list');
			}catch(Exception $e){
        	}
		}else{
			$this->loadForm($form);
		}
    	$this->view->form = $form;
    }
    
    private function validateAndSave(Zend_Form $form){
    	$this->validateForm($form);
       	$this->save($form);
    }
    
	private function validateForm(Zend_Form $form){
		if(!$form->isValid($this->getRequest()->getPost())){
			throw new Exception('Form Data Invalid'); 
		}
    }
    
	private function save(Zend_Form $form){
		$id = (int) $form->getValue('id');
		$category = new GC\Entity\Category(array('id' => $id));
		if($id != 0){
			$category = $this->_em->find('GC\Entity\Category', $id);
		}
		$category->populate($form->getValues());
		$this->_em->getRepository('GC\Entity\Category')->save($category);
	}
	
    
	private function loadForm(Zend_Form $form){
		$id = (int) $this->_getParam('id', 0);
		$category = $this->loadCategory($id);
		$form->populate($category->toArray());
		return $form;	
	}
	
	private function loadCategory($id = 0){
		$id = (int) $id;
		$category = new GC\Entity\Category(array('id' => $id));
		if($id != 0){
			$category = $this->_em->find('GC\Entity\Category', $id);
		}
		return $category;
	}
}

