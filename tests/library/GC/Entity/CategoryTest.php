<?php
namespace GC\Entity;
use Doctrine\ORM\Query;
class CategoryTest extends \EntityCase{
	
	protected $_category;
	
	protected function setUp(){
		parent::setUp();
		$this->_category = new Category();
	}

	protected function tearDown(){
		parent::tearDown();
	}
	
	protected function getDataSet(){
		return $this->createFlatXMLDataSet($GLOBALS['DATASET_PATH'] .'/category-seed.xml');
	}
	
	public function testConstructor(){
		$category = new Category(array('id' => 5 , 'position' => 1, 'name' => 'Games', 'description' => 'Blogs relating to games'));
		$this->assertEquals(5, $category->id);
		$this->assertEquals(1, $category->position);
		$this->assertEquals('Games', $category->name);
		$this->assertEquals('Blogs relating to games', $category->description);
	}
	
	public function testPopulate(){
		$category = new Category();
		$category->populate(array('id' => 5 , 'position' => 1, 'name' => 'Games', 'description' => 'Blogs relating to games'));
		$this->assertEquals(5, $category->id);
		$this->assertEquals(1, $category->position);
		$this->assertEquals('Games', $category->name);
		$this->assertEquals('Blogs relating to games', $category->description);
	}
	
	public function testToArray(){
		$category = new Category(array('id' => 5 , 'position' => 1, 'name' => 'Games', 'description' => 'Blogs relating to games'));
		$categoryAsArray = $category->toArray();
		$this->assertEquals(5, $categoryAsArray['id']);
		$this->assertEquals(1, $categoryAsArray['position']);
		$this->assertEquals('Games', $categoryAsArray['name']);
		$this->assertEquals('Blogs relating to games', $categoryAsArray['description']);
	}
	
	public function testIdProperty(){
		$this->_category->id = 5;
		$this->assertEquals(5, $this->_category->id);
	}
	
	public function testIdSetterAndGetter(){
		$this->_category->setId(5);
		$this->assertEquals(5, $this->_category->getId());
	}
	
	public function testNameProperty(){
		$this->_category->name = 'games';
		$this->assertEquals('games', $this->_category->name);
	}
	
	public function testNameSetterAndGetter(){
		$this->_category->setName('PHP');
		$this->assertEquals('PHP', $this->_category->getName());
	}

	public function testDescriptionProperty(){
		$this->_category->description = 'This category has info relating to PHP';
		$this->assertEquals('This category has info relating to PHP', $this->_category->description);
	}
	
	public function testDescriptionSetterAndGetter(){
		$this->_category->setDescription('PHP category');
		$this->assertEquals('PHP category', $this->_category->getDescription());
	}
	
	public function testPositionProperty(){
		$this->_category->position = 2;
		$this->assertEquals(2, $this->_category->position);
	}
	
	public function testPositionSetterAndGetter(){
		$this->_category->setPosition(3);
		$this->assertEquals(3, $this->_category->getPosition());
	}
	
	public function testBlogEntriesIsZeroCountOnDefaultInitizialization(){
		$this->assertEquals(0, count($this->_category->getBlogEntries()));
	}
	
	public function testAddBlogEntry(){
		$blogEntry = new BlogEntry();
		$this->_category->addBlogEntry($blogEntry);
		$this->assertEquals(1, count($this->_category->getBlogEntries()));
	}
	
	public function testFindCategory(){
		$category = $this->_em->find('GC\Entity\Category', 1);
		$this->assertEquals('Games', $category->name);
		$this->assertEquals('Blogs relating to games', $category->description);
		$this->assertEquals(1, $category->id);
		$this->assertEquals(1, $category->position);
	}
	
	public function testBlogEntriesAreSortedByPostDate(){
		$category = $this->_em->find('GC\Entity\Category', 1);
		$blogEntries = $category->blogEntries;
		$this->assertEquals('30/10/2011', $blogEntries[0]->postDateAsString);
		$this->assertEquals('20/10/2011', $blogEntries[1]->postDateAsString);
		$this->assertEquals('10/10/2011', $blogEntries[2]->postDateAsString);
	}
	
	public function testSaveCategory(){
		$category = new Category(array('name' => 'PHP', 'description' => 'Blogs relating to PHP', 'position' => 2));
		$this->_em->persist($category);
		$this->_em->flush();
		$queryTable = $this->getConnection()->createQueryTable(
            'categories', 'SELECT id, name, description, position FROM categories'
        );
        $expectedTable = $this->createFlatXmlDataSet($GLOBALS['DATASET_PATH'] .'/expectedCategory.xml')->getTable("categories");
        $this->assertTablesEqual($expectedTable, $queryTable);
	}
	
	/**
     * @expectedException PDOException
     */
	public function testUniqueNameConstraint(){
		$category = new Category(array('name' => 'Games', 'description' => 'Games blogs', 'position' => 3));
		$this->_em->persist($category);
		$this->_em->flush();
	}
	
	public function testUpdateCategory(){
		// note: you must getting existing entity from db to update it.
		$category = $this->_em->find('GC\Entity\Category', 1);
		$category->name = "Updated cat";
		$category->description = "Updated description";
		$this->_em->flush();
		$queryTable = $this->getConnection()->createQueryTable(
            'categories', 'SELECT id, name, description, position FROM categories'
        );
        $expectedTable = $this->createFlatXmlDataSet($GLOBALS['DATASET_PATH'] .'/expectedUpdatedCategory.xml')->getTable("categories");
        $this->assertTablesEqual($expectedTable, $queryTable);
	}
	
	
}