<?php
namespace GC\Entity;

class EnquiryEmailBuilder{
	
	protected $enquiry;
	protected $subject;
	protected $body;
	
	public function __construct(Enquiry $enquiry){
		$this->enquiry = $enquiry;
		$this->buildEmail();
	}
	
	public function buildEmail(){
		$this->buildEmailSubject();
		$this->buildEmailBody();
	}

	public function buildEmailSubject(){
		$this->subject = "Enquiry From Website - {$this->enquiry->name}";
	}
	
	public function buildEmailBody(){
		$this->body .= "Name: {$this->enquiry->name}\r\n\r\n";
		$this->body .= "Email: {$this->enquiry->email}\r\n\r\n";
		$this->body .= "Message:\r\n\r\n{$this->enquiry->message}\r\n\r\n";
	}
	
	public function getEmailSubject(){
		return $this->subject;
	}
	
	public function getEmailBody(){
		return $this->body;	
	}
	
}