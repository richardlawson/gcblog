<?php
namespace GC\Entity;

class Enquiry extends EntityBase{
	
	private $name = '';
	private $email = '';
	private $message = '';
	
	public function setName($name){
		$this->name = (string) $name;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function setEmail($email){
		$this->email = (string) $email;
	}
	
	public function getEmail(){
		return $this->email;
	}
	
	public function setMessage($message){
		$this->message = (string) $message;
	}
	
	public function getMessage(){
		return $this->message;
	}
	
	public function validate(){
		$errs = array();
		if($this->name == ''){
			$errs[] = 'name is required';
		}
		if($this->email == ''){
			$errs[] = 'email is required';
		}elseif(!$this->isEmailValid($this->email)){
			$errs[] = 'email is invalid';
		}
		if($this->message == ''){
			$errs[] = 'message is required';
		}	
		return $errs;
	}
	
	protected function isEmailValid($email){
		$validator = new \Zend_Validate_EmailAddress();
		return $validator->isValid($email);
	}
	
	public function toArray(){
		$enquiryArray = array();
		$enquiryArray['name'] = $this->name;
		$enquiryArray['email'] = $this->email;
		$enquiryArray['message'] = $this->message;
		return $enquiryArray;	
	}
	
}