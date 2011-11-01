<?php
namespace GC\Entity;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity(repositoryClass="GC\Entity\Repository\BlogEntryRepository") 
 * @Table(name="blog_entries")
 */
class BlogEntry extends EntityBase{
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
	private $title = '';
	
	/**
	 * @Column(type="string", length=255)
	 */
	private $image = '';
	
	/**
	 * @Column(type="text")
	 */
	private $summary = '';
	
	/**
	 * @Column(type="text")
	 */
	private $content = '';
	
	
	/**
     * @ManyToOne(targetEntity="Category", inversedBy="blogEntries")
     * 
     */
	private $category;
	
	public function __construct(array $options = null){
		$this->postDate = new \DateTime();
		parent::__construct($options);
    }
	
	public function setId($id){
		$this->id = (int) $id;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function setPostDate(\DateTime $postDate){
		$this->postDate = $postDate;
	}
	
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
	
	public function setTitle($title){
		$this->title = (string) $title;
	}
	
	public function getTitle(){
		return $this->title;
	}
	
	public function setImage($image){
		$this->image = (string) $image;
	}
	
	public function getImage(){
		return $this->image;
	}
	
	public function setSummary($summary){
		$this->summary = (string) $summary;
	}
	
	public function getSummary(){
		return $this->summary;
	}
	
	public function setContent($content){
		$this->content = (string) $content;
	}
	
	public function getContent(){
		return $this->content;
	}
		
	public function setCategory(Category $category){
		$category->addBlogEntry($this);
		$this->category = $category;
	}
	
	public function getCategory(){
		return $this->category;
	}
	
	public function toArray(){
		$blogArray = array();
		$blogArray['id'] = $this->id;
		$blogArray['postDate'] = $this->postDateAsString;
		$blogArray['postDateAsString'] = $this->postDateAsString;
		$blogArray['title'] = $this->title;
		$blogArray['summary'] = $this->summary;
		$blogArray['content'] = $this->content;
		$blogArray['image'] = $this->image;
		$blogArray['categoryId'] = $this->category->id;
		return $blogArray;	
	}

}