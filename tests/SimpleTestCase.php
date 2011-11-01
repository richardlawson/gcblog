<?php
abstract class SimpleTestCase extends PHPUnit_Framework_TestCase{

	protected function setUp(){
		$application = new Zend_Application(
            APPLICATION_ENV,
            APPLICATION_PATH . '/configs/application.ini'
        );
        $application->bootstrap();	
	    parent::setUp();
	}
	
	protected function tearDown(){
		parent::tearDown();
	}	

}