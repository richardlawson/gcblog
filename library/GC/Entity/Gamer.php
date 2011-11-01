<?php
namespace GC\Entity;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity @Table(name="gamers")
 */
class Gamer extends EntityBase{
	/**
     * @Id @Column(type="integer") @GeneratedValue
     */
	private $id;
	
	/**
     * @Column(type="string")
     */
	private $facebookId = '';
	
	/**
	 * @Column(type="string")
	 */
	private $name = '';
	
	
	/**
     * @OneToMany(targetEntity="Score", mappedBy="gamer")
     * @var Score[]
     */
	private $scores = null;
	
	public function __construct(array $options = null){
		$this->scores = new ArrayCollection();
		parent::__construct($options);
    }
	
	public function setId($id){
		$this->id = (int) $id;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function setFacebookId($facebookId){
		$this->facebookId = (string) $facebookId;
	}
	
	public function getFacebookId(){
		return $this->facebookId;
	}
	
	public function setName($name){
		$this->name = (string) $name;
	}
	
	public function getName(){
		return $this->name;
	}
		
	public function addScore(Score $score){
		$this->scores[] = $score;
	}
	
	public function getScores(){
		return $this->scores;
	}
	
	public function getHighScore(){
		$highScore = 0;
		foreach($this->scores as $score){
			if($score->points > $highScore){
				$highScore = $score->points;
			}
		}
		return $highScore;
	}

}