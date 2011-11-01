<?php
namespace GC\Entity;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity
 * @Table(name="users")
 */
class User extends EntityBase{
	
	/**
     * @Id @Column(type="integer") @GeneratedValue
     */
	private $id;
	
	/**
	 * @Column(type="string", length=255, nullable=false, unique=true)
	 */
	private $username;
	
	/**
	 * @Column(type="string", length=255, nullable=false)
	 */
	private $password;
	
	public function setId($id){
		$this->id = (int) $id;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function setUsername($username){
		$this->username = (string) $username;
	}
	
	public function getUsername(){
		return $this->username;
	}
	
	public function setPassword($password){
		$this->password = (string) $password;
	}
	
	public function getPassword(){
		return $this->password;
	}

}