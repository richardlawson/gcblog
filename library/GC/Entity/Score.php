<?php
namespace GC\Entity;
/**
 * @Entity(repositoryClass="GC\Entity\Repository\ScoreRepository") 
 * @Table(name="scores")
 */
class Score extends EntityBase{
 	/**
     * @Id @Column(type="integer") @GeneratedValue
     */
	protected $id;
	
	/**
     * @Column(type="integer")
     */
	protected $points;
	
	/**
     * @Column(type="string", length=3, nullable="true")
     */
	protected $handle;
	
	 /**
     * @ManyToOne(targetEntity="Gamer", inversedBy="scores")
     */
    protected $gamer;
    
	public function setId($id){
		$this->id = (int) $id;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function setPoints($points){
		$this->points = (int) $points;
	}
	
	public function getPoints(){
		return $this->points;
	}
	
	public function setHandle($handle){
		$this->handle = (string) $handle;
	}
	
	public function getHandle(){
		return $this->handle;
	}
	
	public function setGamer(Gamer $gamer){
		$gamer->addScore($this);
		$this->gamer = $gamer;
	}
	
	public function getGamer(){
		return $this->gamer;
	}
	
	public function toArray(){
		$objArray = array('id' => $this->id,
				'points' => $this->points, 
				'handle' => $this->handle);
		return $objArray;
	}
}