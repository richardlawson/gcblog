<?php
class Application_Plugin_ModuleLayout extends Zend_Controller_Plugin_Abstract{
	
	public function preDispatch(Zend_Controller_Request_Abstract $request){
		
		$module = strtolower($request->getParam('module'));
		//$front = Zend_Contoller_Front::getInstance();
		$layout = Zend_Layout::getMvcInstance();
		
		if($layout->getMvcEnabled()){
			switch($module){
				case '':
				case 'default':
					break;
				default:
					$layout->setLayoutPath(APPLICATION_PATH . '/modules/' . $module . '/layouts/scripts');
					break;
			}
		}
	}
}