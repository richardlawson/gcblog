<?php
namespace GC\Entity;
use Doctrine\ORM\Query;
class UserTest extends \EntityCase{
	
	protected $_user;
	
	protected function setUp(){
		parent::setUp();
		$this->_user = new User();
	}

	protected function tearDown(){
		parent::tearDown();
	}
	
	protected function getDataSet(){
		return $this->createFlatXMLDataSet($GLOBALS['DATASET_PATH'] .'/user-seed.xml');
	}
	
	public function testConstructor(){
		$user = new User(array('id' => 1 , 'username' => 'admin', 'password' => 'aberdeen'));
		$this->assertEquals(1, $user->id);
		$this->assertEquals('admin', $user->username);
		$this->assertEquals('aberdeen', $user->password);
	}
	
	public function testPopulate(){
		$user = new User();
		$user->populate(array('id' => 1 , 'username' => 'admin', 'password' => 'aberdeen'));
		$this->assertEquals(1, $user->id);
		$this->assertEquals('admin', $user->username);
		$this->assertEquals('aberdeen', $user->password);
	}
	
	public function testIdProperty(){
		$this->_user->id = 5;
		$this->assertEquals(5, $this->_user->id);
	}
	
	public function testIdSetterAndGetter(){
		$this->_user->setId(5);
		$this->assertEquals(5, $this->_user->getId());
	}
	
	public function testUsernameProperty(){
		$this->_user->username = 'admin';
		$this->assertEquals('admin', $this->_user->username);
	}
	
	public function testUsernameSetterAndGetter(){
		$this->_user->setUsername('admin');
		$this->assertEquals('admin', $this->_user->getUsername());
	}

	public function testPasswordProperty(){
		$this->_user->password = 'aberdeen';
		$this->assertEquals('aberdeen', $this->_user->password);
	}
	
	public function testPasswordSetterAndGetter(){
		$this->_user->setPassword('aberdeen');
		$this->assertEquals('aberdeen', $this->_user->getPassword());
	}
	
}