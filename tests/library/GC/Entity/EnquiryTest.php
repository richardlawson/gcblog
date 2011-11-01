<?php
namespace GC\Entity;
class EnquiryTest extends \SimpleTestCase{
	
protected $_enquiry;
	
	protected function setUp(){
		parent::setUp();
		$this->_enquiry = new Enquiry();
	}

	protected function tearDown(){
		parent::tearDown();
	}
	
	public function testConstructor(){
		$enquiry = new Enquiry(array('name' => 'richard lawson', 'email' => 'lawson_richard@hotmail.com', 'message' => 'Hello world!'));
		$this->assertEquals('richard lawson', $enquiry->name);
		$this->assertEquals('lawson_richard@hotmail.com', $enquiry->email);
		$this->assertEquals('Hello world!', $enquiry->message);
	}
	
	public function testPopulate(){
		$enquiry = new Enquiry();
		$enquiry->populate(array('name' => 'richard lawson', 'email' => 'lawson_richard@hotmail.com', 'message' => 'Hello world!'));
		$this->assertEquals('richard lawson', $enquiry->name);
		$this->assertEquals('lawson_richard@hotmail.com', $enquiry->email);
		$this->assertEquals('Hello world!', $enquiry->message);
	}
	
	public function testToArray(){
		$enquiry = new Enquiry(array('name' => 'richard lawson', 'email' => 'lawson_richard@hotmail.com', 'message' => 'Hello world!'));
		$enquiryAsArray = $enquiry->toArray();
		$this->assertEquals('richard lawson', $enquiryAsArray['name']);
		$this->assertEquals('lawson_richard@hotmail.com', $enquiryAsArray['email']);
		$this->assertEquals('Hello world!', $enquiryAsArray['message']);
	}
	
	public function testNameProperty(){
		$this->_enquiry->name = 'richard lawson';
		$this->assertEquals('richard lawson', $this->_enquiry->name);
	}
	
	public function testNameSetterAndGetter(){
		$this->_enquiry->setName('richard');
		$this->assertEquals('richard', $this->_enquiry->getName());
	}
	
	public function testEmailProperty(){
		$this->_enquiry->email = 'lawson_richard@hotmail.com';
		$this->assertEquals('lawson_richard@hotmail.com', $this->_enquiry->email);
	}
	
	public function testEmailSetterAndGetter(){
		$this->_enquiry->setEmail('lawson_richard@hotmail.com');
		$this->assertEquals('lawson_richard@hotmail.com', $this->_enquiry->getEmail());
	}
	
	public function testMessageProperty(){
		$this->_enquiry->message = 'hello world!';
		$this->assertEquals('hello world!', $this->_enquiry->message);
	}
	
	public function testMessageSetterAndGetter(){
		$this->_enquiry->setMessage('hello world!');
		$this->assertEquals('hello world!', $this->_enquiry->getMessage());
	}

	public function testValidateEnquiryWithValidProperties(){
		$enquiry = new Enquiry(array('name' => 'richard lawson', 'email' => 'lawson_richard@hotmail.com', 'message' => 'Hello world!'));
		$errs = $enquiry->validate();
		$this->assertEquals(0, count($errs));
	}
	
	public function testValidateWithEmptyProperties(){
		$enquiry = new Enquiry();
		$errs = $enquiry->validate();
		$this->assertEquals(3, count($errs));
		$this->assertEquals('name is required', $errs[0]);
		$this->assertEquals('email is required', $errs[1]);
		$this->assertEquals('message is required', $errs[2]);
		
	}
	
	public function testValidateEnquiryWithInvalidEmail(){
		$enquiry = new Enquiry(array('name' => 'richard lawson', 'email' => 'lawson_richard.hotmail.com', 'message' => 'Hello world!'));
		$errs = $enquiry->validate();
		$this->assertEquals(1, count($errs));
		$this->assertEquals('email is invalid', $errs[0]);
	}
	
}