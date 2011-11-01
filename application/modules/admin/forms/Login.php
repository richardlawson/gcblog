<?php
class Admin_Form_Login extends Zend_Form{
    
	public function init(){
        // Set the method for the display form to POST
        $this->setMethod('post');
 		$this->addPrefixPath('Application_Form_Decorator', APPLICATION_PATH . '/forms/decorators/', 'decorator');
        $this->setDecorators(array(
            array('Description', array('tag' => 'dd', 'class' => 'form-desc')),	
            'FormElements',
            'Form'
        ));
        
        $this->addElement('text', 'username', array(
            'label'      => 'Username:',
	        'attribs' => array(
	                'maxlength' => 128,
	                'size' => 30
	            ),
            'required'   => true,
         	'filters'    => array('StringTrim'),
            'validators' => array(
            	'Alpha',    
        		array('validator' => 'StringLength', 'options' => array(1, 128))
            	),
            'decorators' => array(
	        	'ViewHelper',
	            'Errors',
                array('HtmlTag', array('tag' => 'dd', 'id' => 'username-element')),
	            'RequiredLabel', 
        		)
        ));
        
         $this->addElement('password', 'password', array(
            'label'      => 'Password:',
	        'attribs' => array(
	                'maxlength' => 128,
	                'size' => 30
	            ),
            'required'   => true,
         	'filters'    => array('StringTrim'),
            'validators' => array(
            	'Alpha',    
        		array('validator' => 'StringLength', 'options' => array(1, 128))
            	),
            'decorators' => array(
	        	'ViewHelper',
	            'Errors',
                array('HtmlTag', array('tag' => 'dd', 'id' => 'password-element')),
	            'RequiredLabel', 
        		)
        ));
        
        $this->addElement('submit', 'submit', array(
        	'label' => 'Submit',
         	'Description' => 'Fields marked with an asterisk (*) are required', 
        	'ignore' => true,
        	'decorators' => array(
	        	'ViewHelper',
        		'Description',
	      		array('HtmlTag', array('tag' => 'dd', 'id' => 'submit-element')),
	      		array('Label', array('tag' => 'dt', 'style' => 'display:none')),	
        	)
        ));
  
        $this->addElement('hash', 'csrf', array(
        	'ignore' => true,
	        'decorators' => array(
		        	'ViewHelper',
	        )
        ));
    }
}