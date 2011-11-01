<?php
class Admin_Form_Category extends Zend_Form{
    
	public function init(){
        // Set the method for the display form to POST
        $this->setMethod('post');
        $this->setName('categoryForm');
 		$this->addPrefixPath('Application_Form_Decorator', APPLICATION_PATH . '/forms/decorators/', 'decorator');
        
        $this->addElement('text', 'name', array(
            'label'      => 'Name:',
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
        
        $this->addElement('textarea', 'description', array(
            'label'      => 'Description:',
	        'attribs' => array(
	                'cols' => 60,
        			'rows' => 4,
	            ),
            'required'   => true,
            'validators' => array(
                array('validator' => 'StringLength', 'options' => array(0, 2000))
                ),
            'decorators' => array(
            	'ViewHelper',
	            'Errors',
                array('HtmlTag', array('tag' => 'dd', 'id' => 'description-element')),
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
        
        $this->addElement('hidden', 'id', array(
        	'ignore' => false,
        	'decorators' => array(
	        	'ViewHelper',
 			)
        ));
         
    }
}
