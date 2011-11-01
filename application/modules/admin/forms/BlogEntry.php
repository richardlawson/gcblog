<?php

class Admin_Form_BlogEntry extends Zend_Form{
    
	protected $_categories = array();
		
	public function setCategories(array $categories){
		$this->_categories = $categories;
	}
	
	public function getCategories(){
		return $this->_categories;
	}


	public function init(){
       // Set the method for the display form to POST
        $this->setMethod('post');
        $this->setName('blogEntryForm');
 		$this->addPrefixPath('Application_Form_Decorator', APPLICATION_PATH . '/forms/decorators/', 'decorator');
        
 	    $categoryForm = new Admin_Form_CategorySelect(array('categories' => $this->getCategories()));
        $element = $categoryForm->getElement('categoryId');
        $this->addElement($element);
       
 		$this->addElement('text', 'postDateAsString', array(
            'label'      => 'Post Date:',
	        'attribs' => array(
	                'maxlength' => 10,
	                'size' => 30
	            ),
            'required'   => true,
            'validators' => array( 
	            array('Date', false, array('format' => 'dd/MM/YYYY'))
            	),
            'decorators' => array(
	        	'ViewHelper',
	            'Errors',
                array('HtmlTag', array('tag' => 'dd', 'id' => 'postdate-element')),
	            'RequiredLabel', 
        		)
        ));
        
        $this->addElement('hidden', 'useExisting', array(
            'required'   => true,
        	'value' => 0,
       		'decorators' => array(
	        	'ViewHelper',
 			)
        ));
         
		$element = new Zend_Form_Element_File('image');
		$element->setValueDisabled(true);
		$element->setLabel('Upload an image:');
		$element->addValidator('Count', false, 1);
		$element->addValidator('Size', false, 9000000);
		$element->addValidator('Extension', false, 'jpg,png,gif');
		$this->addElement($element, 'image');
        
        
        $this->addElement('text', 'title', array(
            'label'      => 'Title:',
	        'attribs' => array(
	                'maxlength' => 128,
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
                array('HtmlTag', array('tag' => 'dd', 'id' => 'title-element')),
	            'RequiredLabel', 
        		)
        ));
        
        $this->addElement('textarea', 'summary', array(
            'label'      => 'Summary:',
	        'attribs' => array(
	                'cols' => 60,
        			'rows' => 6,
	            ),
            'required'   => true,
         	'filters'    => array('StringTrim'),
            'validators' => array( 
        		array('validator' => 'StringLength')
            	),
            'decorators' => array(
	        	'ViewHelper',
	            'Errors',
                array('HtmlTag', array('tag' => 'dd', 'id' => 'summary-element')),
	            'RequiredLabel', 
        		)
        ));
        
        $this->addElement('textarea', 'content', array(
            'label'		=> 'Content:',
            'attribs' => array(
	                'cols' => 50,
        			'rows' => 6,
	            ),
	        'required'   => false,
            'decorators' => array(	
            	'ViewHelper',
	            'Wysiwyg',
	            'Errors',
                array('HtmlTag', array('tag' => 'dd', 'id' => 'content-element')),
	            'WarningLinkLabel', 
        		)
         ));
    
        $this->addElement('textarea', 'content', array(
            'label'		=> 'Content:',
            'attribs' => array(
	                'cols' => 50,
        			'rows' => 6,
	            ),
	        'required'   => false,
            'decorators' => array(	
            	'ViewHelper',
	            'Wysiwyg',
	            'Errors',
                array('HtmlTag', array('tag' => 'dd', 'id' => 'content-element')),
	            'WarningLinkLabel', 
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