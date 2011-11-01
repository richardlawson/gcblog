<?php

class Admin_LoginController extends Zend_Controller_Action
{
	
    public function init(){ 
		$layout = $this->_helper->layout()->setLayout('login-layout');
    }

    public function indexAction(){
        $form = new Admin_Form_Login();
        if($this->getRequest()->isPost()) {
        	try{
        		$this->validateAndAuthenticate($form);
        		$this->_helper->redirector->gotoRoute(array(), 'admin-home');
        	}catch(Exception $e){
				$form->setDescription('Login failed, please try again');
        	}
        }
        $this->view->form = $form;
    }
    
    private function validateAndAuthenticate(Zend_Form $form){
    	$this->validateForm($form);
    	$this->authenticate($form);
    }
    
	private function validateForm(Zend_Form $form){
		if(!$form->isValid($this->getRequest()->getPost())){
			throw new Exception('Form Data Invalid'); 
		}
    }
    
    private function authenticate(Zend_form $form){
    	$user = new GC\Entity\User($form->getValues());
    	$authService = new Application_Service_Authentication($user);
    	if(!$authService->authenticate()){
    		throw new Exception('Login Invalid'); 
    	}
    		
    }


}

