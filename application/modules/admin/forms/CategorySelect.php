<?php
class Admin_Form_CategorySelect extends Zend_Form{
    
	protected $_categories = array();
	
	public function setCategories(array $categories){
		$this->_categories = $categories;
	}
	
	public function getCategories(){
		return $this->_categories;
	}
	
	public function init(){
        $this->setMethod('post');
 		$this->addPrefixPath('Application_Form_Decorator', APPLICATION_PATH . '/forms/decorators/', 'decorator');
		$this->addElement('select', 'categoryId', array(
            'label'      => 'Category:',
            'required'   => true,
         	'filters'    => array('Digits'),
            'validators' => array( 
        		array('validator' => 'Digits')
            	),
            'decorators' => array(
	        	'ViewHelper',
	            'Errors',
                array('HtmlTag', array('tag' => 'dd', 'id' => 'category-element')),
	            'RequiredLabel', 
        		)
        ));
        $this->categoryId->addMultiOptions($this->getOptions());  
    }
    
 	protected function getOptions(){
     	$categoryOptions = array();
 		foreach($this->_categories as $category){
     		$categoryOptions[$category->id] = $category->name;
    	}
     	return $categoryOptions;
    }
}