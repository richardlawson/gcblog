<?php
namespace GC\Entity;
/**
 * @Entity @Table(name="comments")
 */
class Comment extends EntityBase{
	/**
     * @Id @Column(type="integer") @GeneratedValue
     */
	private $id;
	
	/**
	 * @Column(type="datetime", nullable=false)
	 */
	private $postedDate;
	
	/**
	 * @Column(type="string", length=255, nullable=false)
	 */
	private $email;
	
	/**
	 * @Column(type="text", nullable=false)
	 */
	private $content = '';
	
	/**
     * Set id
     *
     * @param integer $id
     */
    public function setId($id){
        $this->id = (int) $id;
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId(){
        return $this->id;
    }

    /**
     * Set postedDate
     *
     * @param datetime $postedDate
     */
    public function setPostedDate(DateTime $postedDate){
        $this->postedDate = $postedDate;
    }

    /**
     * Get postedDate
     *
     * @return datetime 
     */
    public function getPostedDate(){
        return $this->postedDate;
    }

    /**
     * Set email
     *
     * @param string $email
     */
    public function setEmail($email){
        $this->email = (string) $email;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail(){
        return $this->email;
    }

    /**
     * Set content
     *
     * @param text $content
     */
    public function setContent($content){
        $this->content = (string)$content;
    }

    /**
     * Get content
     *
     * @return text 
     */
    public function getContent(){
        return $this->content;
    }
}