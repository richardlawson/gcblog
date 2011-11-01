<?php
namespace GC\Entity;
class EnquiryEmailBuilderTest extends \SimpleTestCase{
	
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
		$enquiryEmailBuilder = new EnquiryEmailBuilder($enquiry);
		$this->assertEquals('Enquiry From Website - richard lawson', $enquiryEmailBuilder->getEmailSubject()); 
		$this->assertEquals("Name: richard lawson\r\n\r\nEmail: lawson_richard@hotmail.com\r\n\r\nMessage:\r\n\r\nHello world!\r\n\r\n", $enquiryEmailBuilder->getEmailBody()); 
	}
	
}