<?php
namespace GC\Entity;
use Doctrine\ORM\Query;
class GamerTest extends \EntityCase{
	
	protected $_gamer;
	
	protected function setUp(){
		parent::setUp();
		$this->_gamer = new Gamer();
	}

	protected function tearDown(){
		parent::tearDown();
	}
	
	protected function getDataSet(){
		return $this->createFlatXMLDataSet($GLOBALS['DATASET_PATH'] .'/gamer-seed.xml');
	}
	
	protected function getMockGamer(){
		$gamer = new Gamer(array('id' => 7 , 'name' => 'richard lawson', 'facebookId' => '12345678910'));
		return $gamer;
	}
	
	protected function getMockGamerWithScores(){
		$gamer = $this->getMockGamer();
		$gamer->addScore(new Score(array('points' => 12)));
		$gamer->addScore(new Score(array('points' => 0)));
		$gamer->addScore(new Score(array('points' => 20)));
		$gamer->addScore(new Score(array('points' => 2)));
		return $gamer;
	}
	
	public function testConstructor(){
		$gamer = new Gamer(array('id' => 7 , 'name' => 'richard lawson', 'facebookId' => '12345678910'));
		$this->assertEquals(7, $gamer->id);
		$this->assertEquals('richard lawson', $gamer->name);
		$this->assertEquals('12345678910', $gamer->facebookId);
	}
	
	public function testIdProperty(){
		$this->_gamer->id = 5;
		$this->assertEquals(5, $this->_gamer->id);
	}
	
	public function testIdSetterAndGetter(){
		$this->_gamer->setId(5);
		$this->assertEquals(5, $this->_gamer->getId());
	}
	
	public function testFacebookIdProperty(){
		$this->_gamer->facebookId = '12345678910';
		$this->assertEquals('12345678910', $this->_gamer->facebookId);
	}
	
	public function testFacebookIdSetterAndGetter(){
		$this->_gamer->setFacebookId('12345678910');
		$this->assertEquals('12345678910', $this->_gamer->getFacebookId());
	}
	
	public function testNameProperty(){
		$this->_gamer->name = 'joe bloggs';
		$this->assertEquals('joe bloggs', $this->_gamer->name);
	}
	
	public function testNameSetterAndGetter(){
		$this->_gamer->setName('joe bloggs');
		$this->assertEquals('joe bloggs', $this->_gamer->getName());
	}
	
	public function testGamerScoresIsZeroCountOnDefaultInitizialization(){
		$this->assertEquals(0, count($this->_gamer->getScores()));
	}
	
	public function testAddScore(){
		$score = new Score();
		$this->_gamer->addScore($score);
		$this->assertEquals(1, count($this->_gamer->getScores()));
	}
	
	public function testGetHighScore(){
		$gamer = $this->getMockGamerWithScores();
		$this->assertEquals(20, $gamer->getHighScore());
	}
	
	public function testFindGamer(){
		$gamer = $this->_em->find('GC\Entity\Gamer', 1);
		$this->assertEquals('richard law', $gamer->name);
		$this->assertEquals('123456789', $gamer->facebookId);
		$this->assertEquals(1, $gamer->id);
	}
	
	public function testFindGamerByFacebookId(){
		$gamer  = $this->_em->getRepository('GC\Entity\Gamer')->findOneBy(array('facebookId' => '123456789'));
		$this->assertEquals('richard law', $gamer->name);
		$this->assertEquals('123456789', $gamer->facebookId);
		$this->assertEquals(1, $gamer->id);
	}
	
	public function testSaveGamer(){
		$gamer = new Gamer(array('name' => 'Richard Lawson', 'facebookId' => '1234'));
		$this->_em->persist($gamer);
		$this->_em->flush();
		$queryTable = $this->getConnection()->createQueryTable(
            'gamers', 'SELECT id, name, facebookId FROM gamers'
        );
        $expectedTable = $this->createFlatXmlDataSet($GLOBALS['DATASET_PATH'] .'/expectedGamer.xml')->getTable("gamers");
        $this->assertTablesEqual($expectedTable, $queryTable);
	}
	
	
}