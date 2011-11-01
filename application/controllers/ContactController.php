<?php

class ContactController extends Zend_Controller_Action
{
	protected $_properties;
	
    public function init()
    {
       $registry = Zend_Registry::getInstance();
       $this->view->menuItem = $registry->properties->menuitem->contact->id;
       $this->_properties = $registry->properties;
    }

    public function indexAction()
    {
        
    }
    
	public function sendmessageAction(){
		$this->_helper->viewRenderer->setNoRender();
      	$this->_helper->layout->disableLayout();
    	$response = array();
        $enquiry = new GC\Entity\Enquiry();
        $this->parseRequest($enquiry);
  		// if no validation errors send email   
        if(!count($enquiry->validate())){
        	try{
        		$this->sendEmail($enquiry);
        		$response['responseStatus'] = 'SENT';
        	}catch(Exception $e){
        		$response['responseStatus'] = 'FAILED';
        	}
        }else{
        	$response['responseStatus'] = 'INVALID';
        	$response['errors'] = $enquiry->validate();
        }
        echo Zend_Json::encode($response);
    }
    
    protected function parseRequest(GC\Entity\Enquiry $enquiry){
    	$enquiry->name = trim($this->_getParam('name', ''));
    	$enquiry->email = trim($this->_getParam('email', ''));
    	$enquiry->message = trim($this->_getParam('message', ''));
    }
    
 	protected function sendEmail(GC\Entity\Enquiry $enquiry){
 		$emailBuilder = new GC\Entity\EnquiryEmailBuilder($enquiry);
    	mail($this->_properties->enquiryFormRecipient, $emailBuilder->getEmailSubject(), $emailBuilder->getEmailBody(), "From: {$enquiry->email}", "-f{$enquiry->email}");
    }


}

