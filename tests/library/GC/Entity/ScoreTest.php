<?php
namespace GC\Entity;
use Doctrine\ORM\Query;
class ScoreTest extends \EntityCase{
	
	protected $_score;
	protected $_gamer;
	
	protected function setUp(){
		parent::setUp();
		$this->_score = new Score();
		$this->_gamer = new Gamer();
	}

	protected function tearDown(){
		parent::tearDown();
	}
	
	protected function getDataSet(){
		return $this->createFlatXMLDataSet($GLOBALS['DATASET_PATH'] .'/score-seed.xml');
	}
	
	protected function getMockScore(){
		$score = new Score(array('id' => 5 , 'handle' => 'ACE', 'points' => 120));
		return $score;
	}
	
	public function testConstructor(){
		$score = new Score(array('id' => 6 , 'handle' => 'RIC', 'points' => 135, 'gamer' => $this->_gamer));
		$this->assertEquals(6, $score->id);
		$this->assertEquals('RIC', $score->handle);
		$this->assertEquals(135, $score->points);
		$this->assertEquals($this->_gamer, $score->gamer);
	}
	
	public function testIdProperty(){
		$this->_score->id = 5;
		$this->assertEquals(5, $this->_score->id);
	}
	
	public function testIdSetterAndGetter(){
		$this->_score->setId(5);
		$this->assertEquals(5, $this->_score->getId());
	}
	
	public function testHandleProperty(){
		$this->_score->handle = 'NOB';
		$this->assertEquals('NOB', $this->_score->handle);
	}
	
	public function testHandleSetterAndGetter(){
		$this->_score->setHandle('NOB');
		$this->assertEquals('NOB', $this->_score->getHandle());
	}
	
	public function testPointsProperty(){
		$this->_score->points = 150;
		$this->assertEquals(150, $this->_score->points);
	}
	
	public function testPointsSetterAndGetter(){
		$this->_score->setPoints(160);
		$this->assertEquals(160, $this->_score->getPoints());
	}
	
	public function testGamerProperty(){
		$this->_gamer->name = 'richard lawson';
		$this->_score->gamer = $this->_gamer;
		$this->assertEquals('richard lawson', $this->_score->gamer->name);
	}
	
	public function testGamerSetterAndGetter(){
		$this->_gamer->name = 'richard lawson';
		$this->_score->setGamer($this->_gamer);
		$this->assertEquals('richard lawson', $this->_score->getGamer()->name);
	}
	
	public function testScoreAddedToGamerScoresWhenGamerSet(){
		$this->assertEquals(0, count($this->_gamer->scores));
		$this->_score->setGamer($this->_gamer);
		$this->assertEquals(1, count($this->_gamer->scores));
	}
	
	public function testToArray(){
		$score = new Score(array('id' => 5, 'handle'=> 'ACE', 'points' => 145));
		$scoreArr = $score->toArray();
		$this->assertEquals(5, $scoreArr['id']);
		$this->assertEquals('ACE', $scoreArr['handle']);
		$this->assertEquals(145, $scoreArr['points']);
	}
	
	public function testFindScore(){
		$score = $this->_em->find('GC\Entity\Score', 1);
		$this->assertEquals('RIC', $score->handle);
		$this->assertEquals(100, $score->points);
		$this->assertEquals(1, $score->id);
		$this->assertEquals(1, $score->gamer->id);
	}
	
	public function testSaveScore(){
		$gamer = $this->_em->find('GC\Entity\Gamer', 1);
		$score = new Score(array('id' => 2, 'handle'=> 'ACE', 'points' => 140, 'gamer' => $gamer));
		$this->_em->persist($score);
		$this->_em->flush();
		
		$queryTable = $this->getConnection()->createQueryTable(
            'scores', 'SELECT id, handle, points, gamer_id FROM scores'
        );
        $expectedTable = $this->createFlatXmlDataSet($GLOBALS['DATASET_PATH'] .'/expectedScore.xml')
        	->getTable("scores");
        $this->assertTablesEqual($expectedTable, $queryTable);
	}
	
}