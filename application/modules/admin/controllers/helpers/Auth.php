<?php
class Admin_Controller_Helper_Auth extends Zend_Controller_Action_Helper_Abstract
{
	protected $_auth;
	
	public function init(){
		$this->_auth = Zend_Auth::getInstance();
	}
	
	public function isAuthorized(){
		return $this->_auth->hasIdentity();
	}
}