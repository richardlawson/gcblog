<?php
abstract class EntityCase extends PHPUnit_Extensions_Database_TestCase{
	
	protected $_em;
	
	protected function setUp(){
		$application = new Zend_Application(
            APPLICATION_ENV,
            APPLICATION_PATH . '/configs/application.ini'
        );
        $application->bootstrap();
		$this->_em = Zend_Registry::get('em');
		 // Retrieve the Doctrine 2 entity manager
   
   		// Instantiate the schema tool
   		$tool = new Doctrine\ORM\Tools\SchemaTool($this->_em);
    	// Retrieve all of the mapping metadata
    	$classes = $this->_em->getMetadataFactory()->getAllMetadata();
    	// Delete the existing test database schema
    	$tool->dropSchema($classes);

	    // Create the test database schema
	    $tool->createSchema($classes);
			
	    parent::setUp();
	}
	
	protected function tearDown(){
		parent::tearDown();
	}
	
	public function getConnection(){
    	$pdo = new PDO($GLOBALS['DB_DSN']);
    	return $this->createDefaultDBConnection($pdo, $GLOBALS['DB_DBNAME']);
	}
  	
  	
	
}