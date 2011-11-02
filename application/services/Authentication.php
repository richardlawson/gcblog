<?php
class Application_Service_Authentication 
{
	
	protected $_authAdapter;
	protected $_user;
	protected $_auth;
	
	public function __construct(GC\Entity\User $user = null){
		if(is_null($user)){
			$user = new GC\Entity\User();
		}
		$this->_user = $user;
	}
	
	public function authenticate(){
		$adapter = $this->getAuthAdapter(array('username' => $this->_user->username, 'password' => $this->_user->password));
		$auth = $this->getAuth();
		$result = $auth->authenticate($adapter);
		if(!$result->isValid()){
			return false;
		}
		//$auth->getStorage()->write($user);
		return true;	
	}
	
	public function getIdentity(){
		$auth = $this->getAuth();
		if($this->hasIdentity()){
			return $auth->getIdentity();
		}
		return false;
	}
	
	public function hasIdentity(){
		$auth = $this->getAuth();
		if($auth->hasIdentity){
			return true;
		}
		return false;
	}
	
	public function clear(){
		$this->getAuth()->clearIdentity();
	}
	
	public function setAuthAdapter(Zend_Auth_Adapter_Interface $adapter){
		$this->_authAdapter = $adapter;
	}
		
	public function getAuthAdapter($values){
		if(is_null($this->_authAdapter)){
			$authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table_Abstract::getDefaultAdapter());
		 	Zend_Db_Table_Abstract::getDefaultAdapter();
			$authAdapter
		  		->setTableName('users')
		    	->setIdentityColumn('username')
		    	->setCredentialColumn('password');
			$this->setAuthAdapter($authAdapter);
			$this->_authAdapter
			    ->setIdentity($values['username'])
			    ->setCredential(md5($values['password']));
		}
		return $this->_authAdapter;
	}
	
	public function getAuth(){
		if(is_null($this->_auth)){
			$this->_auth = Zend_Auth::getInstance();
		}
		return $this->_auth; 
	}
}