<?php
class Admin_Form_BlogEntryEdit extends Admin_Form_BlogEntry{

	public function init(){
       parent::init();
       $element = new Zend_Form_Element_Checkbox('useExisting');
       $element->setRequired(true);
       $element->setValue(1);
       $element->setLabel('Use existing image:');
       $this->useExisting = $element;
       $this->addElement('hidden', 'existingImage', array(
       		'required' => true,
       		'ignore' => false,
        	'decorators' => array(
	        	'ViewHelper',
 			),
        ));
      
    }
}