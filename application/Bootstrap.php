<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	protected function _initViewSettings(){
        $this->bootstrap('view');
        $view = $this->getResource('view');
        $view->doctype('HTML5');
        $view->headMeta()->setCharset('iso-8859-1');
    }
    
 	// Do not rename this method _initDoctrine() this will result in a circular dependency error.
	protected function _initDoctrineExtra(){
    	$doctrine = $this->bootstrap('doctrine')->getResource('doctrine');    
    	$em = $doctrine->getEntityManager();
    	Zend_Registry::set('em', $em);
	}
	
	protected function _initAutoloadModuleAdmin(){
	 	$autoloader = new Zend_Application_Module_Autoloader(array(
	 		'namespace' => 'Admin',
	 		'basePath' => APPLICATION_PATH . '/modules/admin',
	 	));
		return $autoloader;
		
	}
	
	protected function _initActionHelpers(){
		Zend_Controller_Action_HelperBroker::addPath(APPLICATION_PATH . '/modules/admin/controllers/helpers',
                                             'Admin_Controller_Helper_');
	}
	
	protected function _initRoutes(){
		$this->bootstrap('frontController');
	 	$router = $this->frontController->getRouter();
	 	$routesConfig = new Zend_Config_Ini(APPLICATION_PATH . '/configs/routes.ini', 'production');
	 	$router->addConfig($routesConfig, 'routes');
	}
	
	protected function _initProperties(){
		$properties = new Zend_Config_Ini(APPLICATION_PATH . '/configs/properties.ini', 'production');
   		Zend_Registry::set('properties', $properties);
    	return $properties;
	}
	
	protected function _initFacebookProperties(){
		Zend_Registry::set('facebookProperties', $this->getOption('facebook'));	
	}

}

