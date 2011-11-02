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
	 * @Column(type="date", nullable=false)
	 */
	private $postDate;
	
	/**
	 * @Column(type="string", length=255, nullable=false)
	 */
	private $email;
	
	/**
	 * @Column(type="string", length=255, nullable=false)
	 */
	private $name;
	
	/**
	 * @Column(type="text", nullable=false)
	 */
	private $content = '';
	
	/**
     * @ManyToOne(targetEntity="BlogEntry", inversedBy="comments")
     * 
     */
	private $blogEntry;
	
	/**
     * Set id
     *
     * @param integer $id
     */
    public function setId($id){
        $this->id = (int) $id;
    }
    
	public function __construct(array $options = null){
		$this->postDate = new \DateTime();
		parent::__construct($options);
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
     * @param datetime $postDate
     */
    public function setPostDate(\DateTime $postDate){
        $this->postDate = $postDate;
    }

    /**
     * Get postDate
     *
     * @return datetime 
     */
    public function getPostDate(){
        return $this->postDate;
    }
    
	public function setPostDateAsString($stringDate){
		$stringDate = (string) $stringDate;
		$this->postDate = new \DateTime(\GC\Util\DateHelper::convertddmmyyyyStringToMysqlDateString($stringDate));
	}
	
	public function getPostDateAsString(){
		return $this->postDate->format('d/m/Y');
	}

 	/**
     * Set name
     *
     * @param string $name
     */
    public function setName($name){
        $this->name = (string) $name;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName(){
        return $this->name;
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
    
	public function setBlogEntry(BlogEntry $blogEntry){
		$blogEntry->addComment($this);
		$this->blogEntry = $blogEntry;
	}
	
	public function getBlogEntry(){
		return $this->blogEntry;
	}
	
	public function toArray(){
		$commentArray = array();
		$commentArray['id'] = $this->id;
		$commentArray['postDate'] = $this->postDateAsString;
		$commentArray['postDateAsString'] = $this->postDateAsString;
		$commentArray['email'] = $this->email;
		$commentArray['name'] = $this->name;
		$commentArray['content'] = $this->content;
		$commentArray['blogEntryId'] = $this->blogEntry->id;
		return $commentArray;	
	}
}