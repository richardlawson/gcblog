<?php

class ScoreRepositoryTest extends \EntityCase{
	
	protected function setUp(){
		parent::setUp();
	}

	protected function tearDown(){
		parent::tearDown();
	}
	
	protected function getDataSet(){
		return $this->createFlatXMLDataSet($GLOBALS['DATASET_PATH'] .'/scorerepository-seed.xml');
	}
	
	public function testHighScores(){
		$highScores = $this->_em->getRepository('GC\Entity\Score')->getHighScores();
		$this->assertEquals('10', count($highScores));
		$this->assertEquals('100', $highScores[0]->points);
		$this->assertEquals('90', $highScores[1]->points);
		$this->assertEquals('90', $highScores[2]->points);
		$this->assertEquals('90', $highScores[3]->points);
		$this->assertEquals('80', $highScores[4]->points);
		$this->assertEquals('70', $highScores[5]->points);
		$this->assertEquals('60', $highScores[6]->points);
		$this->assertEquals('50', $highScores[7]->points);
		$this->assertEquals('40', $highScores[8]->points);
		$this->assertEquals('30', $highScores[9]->points);
	}
	
	public function testHighScoresMethodOrdersScoresWithLowerIdAboveScoresWithHigherIdWhenTheyHaveTheSamePointsValue(){
		$highScores = $this->_em->getRepository('GC\Entity\Score')->getHighScores();
		$this->assertEquals('1', $highScores[1]->id);
		$this->assertEquals('90', $highScores[1]->points);
		$this->assertEquals('5', $highScores[2]->id);
		$this->assertEquals('90', $highScores[2]->points);
		$this->assertEquals('15', $highScores[3]->id);
		$this->assertEquals('90', $highScores[3]->points);
	}
}