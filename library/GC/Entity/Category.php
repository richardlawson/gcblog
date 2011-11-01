<?php
namespace GC\Entity;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * @Entity(repositoryClass="GC\Entity\Repository\CategoryRepository") 
 * @Table(name="categories")
 */
class Category extends EntityBase{
	
	const REORDER_UP = 0;
	const REORDER_DOWN = 1; 
	
	/**
     * @Id @Column(type="integer") @GeneratedValue
     */
	private $id;
	
	/**
	 * @Column(type="integer", nullable=false)
	 */
	private $position;
	
	/**
	 * @Column(type="string", length=255, nullable=false, unique=true)
	 */
	private $name = '';
	
	/**
	 * @Column(type="text")
	 */
	private $description = '';
	
	
	/**
     * @OneToMany(targetEntity="BlogEntry", mappedBy="category", fetch="EXTRA_LAZY")
     * @OrderBy({"postDate" = "DESC"})
     * @var BlogEntry[]
     */
	private $blogEntries = null;
	
	public function __construct(array $options = null){
		$this->blogEntries = new ArrayCollection();
		parent::__construct($options);
    }
	
	public function setId($id){
		$this->id = (int) $id;
	}
	
	public function getId(){
		return $this->id;
	}
	
	public function setPosition($position){
		$this->position = (int) $position;
	}
	
	public function getPosition(){
		return $this->position;
	}
	
	public function setName($name){
		$this->name = (string) $name;
	}
	
	public function getName(){
		return $this->name;
	}
	
	public function setDescription($description){
		$this->description = (string) $description;
	}
	
	public function getDescription(){
		return $this->description;
	}
		
	public function addBlogEntry(BlogEntry $blogEntry){
		$this->blogEntries[] = $blogEntry;
	}
	
	public function getBlogEntries(){
		return $this->blogEntries;
	}
	
	public function toArray(){
		$categoryArray = array();
		$categoryArray['id'] = $this->id;
		$categoryArray['position'] = $this->position;
		$categoryArray['name'] = $this->name;
		$categoryArray['description'] = $this->description;
		return $categoryArray;	
	}

}