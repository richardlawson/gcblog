<?php
require APPLICATION_PATH . '/../library/facebook/src/facebook.php';

class TomcatfighterController extends Zend_Controller_Action
{
	
    public function init(){
		$layout = $this->_helper->layout()->setLayout('facebook-layout');
    }

    public function indexAction(){
    	
    }

}

