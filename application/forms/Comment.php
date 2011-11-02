<?php

class Application_Form_Comment extends Zend_Form{

	public function init(){
       // Set the method for the display form to POST
        $this->setMethod('post');
        $this->setName('commentForm');
 		$this->addPrefixPath('Application_Form_Decorator', APPLICATION_PATH . '/forms/decorators/', 'decorator');
        
        
        $this->addElement('text', 'name', array(
            'label'      => 'NAME:',
	        'attribs' => array(
	                'maxlength' => 255,
	                'size' => 30
	            ),
            'required'   => true,
         	'filters'    => array('StringTrim'),
            'validators' => array( 
        		array('validator' => 'StringLength', 'options' => array(1, 255))
            	),
            'decorators' => array(
	        	'ViewHelper',
	            'Errors',
                array('HtmlTag', array('tag' => 'dd', 'id' => 'name-element')),
	            'RequiredLabel', 
        		)
        ));
        
        $this->addElement('text', 'email', array(
            'label'      => 'EMAIL:',
	        'attribs' => array(
	                'maxlength' => 255,
	                'size' => 30
	            ),
            'required'   => true,
         	'filters'    => array('StringTrim'),
            'validators' => array(
                'EmailAddress',
            ),
            'decorators' => array(
	        	'ViewHelper',
	            'Errors',
                array('HtmlTag', array('tag' => 'dd', 'id' => 'email-element')),
	            'RequiredLabel', 
        		)
        ));
        
        $this->addElement('textarea', 'content', array(
            'label'		=> 'COMMENT:',
            'attribs' => array(
	                'cols' => 60,
        			'rows' => 5,
	            ),
	        'required'   => true,
            'decorators' => array(	
            	'ViewHelper',
	            'Errors',
                array('HtmlTag', array('tag' => 'dd', 'id' => 'comment-element')),
	            'RequiredLabel', 
        		)
         ));
       
        
        $this->addElement('image', 'submit', array(
        	'label' => 'Submit',
        	'src' => '/images/send-comment.png',
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