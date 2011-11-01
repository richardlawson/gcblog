<?php

class AboutController extends Zend_Controller_Action
{
	
    public function init()
    {
       $registry = Zend_Registry::getInstance();
       $this->view->menuItem = $registry->properties->menuitem->about->id;
    }

    public function indexAction()
    {
       
    }


}

