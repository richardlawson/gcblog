<?php
namespace GC\Entity\Repository;
use GC\Entity\Category, GC\Entity\BlogEntry;
class CategoryRepositoryTest extends \EntityCase{
	
	protected function setUp(){
		parent::setUp();
	}

	protected function tearDown(){
		parent::tearDown();
	}
	
	protected function getDataSet(){
		return $this->createFlatXMLDataSet($GLOBALS['DATASET_PATH'] .'/categoryrepository-seed.xml');
	}
	
	public function testFindAllOrderedByPosition(){
		$categories = $this->_em->getRepository('GC\Entity\Category')->findAllOrderedByPosition();	
		$this->assertEquals(3, count($categories));
		$this->assertEquals(1, $categories[0]->position);
		$this->assertEquals(2, $categories[1]->position);
		$this->assertEquals(3, $categories[2]->position);
	}
	
	public function testGetHighestPosition(){
		$this->assertEquals(3, $this->_em->getRepository('GC\Entity\Category')->getHighestPosition());	
	}
	
	public function testReorderUp(){
		$this->_em->getRepository('GC\Entity\Category')->reorderUp(1);
		$queryTable = $this->getConnection()->createQueryTable(
            'categories', 'SELECT id, name, description, position FROM categories'
        );
        $expectedTable = $this->createFlatXmlDataSet($GLOBALS['DATASET_PATH'] .'/expectedReorderUpCategory.xml')->getTable("categories");
        $this->assertTablesEqual($expectedTable, $queryTable);	
	}
	
	public function testNoChangeWhenCategoryWithPosition1IsReorderedUp(){
		$this->_em->getRepository('GC\Entity\Category')->reorderUp(3);
		$queryTable = $this->getConnection()->createQueryTable(
            'categories', 'SELECT id, name, description, position FROM categories'
        );
        $expectedTable = $this->createFlatXmlDataSet($GLOBALS['DATASET_PATH'] .'/categoryrepository-seed.xml')->getTable("categories");
        $this->assertTablesEqual($expectedTable, $queryTable);	
	}
	
	public function testReorderDown(){
		$this->_em->getRepository('GC\Entity\Category')->reorderDown(1);
		$queryTable = $this->getConnection()->createQueryTable(
            'categories', 'SELECT id, name, description, position FROM categories'
        );
        $expectedTable = $this->createFlatXmlDataSet($GLOBALS['DATASET_PATH'] .'/expectedReorderDownCategory.xml')->getTable("categories");
        $this->assertTablesEqual($expectedTable, $queryTable);	
	}
	
	public function testNoChangeWhenCategoryWithHighestPositionIsReorderedDown(){
		$this->_em->getRepository('GC\Entity\Category')->reorderDown(2);
		$queryTable = $this->getConnection()->createQueryTable(
            'categories', 'SELECT id, name, description, position FROM categories'
        );
        $expectedTable = $this->createFlatXmlDataSet($GLOBALS['DATASET_PATH'] .'/categoryrepository-seed.xml')->getTable("categories");
        $this->assertTablesEqual($expectedTable, $queryTable);	
	}
	
	public function testReorderWithReorderTypeUp(){
		$this->_em->getRepository('GC\Entity\Category')->reorder(1, Category::REORDER_UP);
		$queryTable = $this->getConnection()->createQueryTable(
            'categories', 'SELECT id, name, description, position FROM categories'
        );
        $expectedTable = $this->createFlatXmlDataSet($GLOBALS['DATASET_PATH'] .'/expectedReorderUpCategory.xml')->getTable("categories");
        $this->assertTablesEqual($expectedTable, $queryTable);	
	}
	
	public function testReorderWithReorderTypeDown(){
		$this->_em->getRepository('GC\Entity\Category')->reorder(1, Category::REORDER_DOWN);
		$queryTable = $this->getConnection()->createQueryTable(
            'categories', 'SELECT id, name, description, position FROM categories'
        );
        $expectedTable = $this->createFlatXmlDataSet($GLOBALS['DATASET_PATH'] .'/expectedReorderDownCategory.xml')->getTable("categories");
        $this->assertTablesEqual($expectedTable, $queryTable);	
	}
	
	public function testMoveupAllBelowPosition(){
		$this->_em->getRepository('GC\Entity\Category')->moveupAllBelowPosition(1);
		$queryTable = $this->getConnection()->createQueryTable(
            'categories', 'SELECT id, name, description, position FROM categories'
        );
        $expectedTable = $this->createFlatXmlDataSet($GLOBALS['DATASET_PATH'] .'/expectedMoveupAllBelowCategory.xml')->getTable("categories");
        $this->assertTablesEqual($expectedTable, $queryTable);	
	}
	
	public function testDeleteAlsoReordersExistingCategories(){
		$this->_em->getRepository('GC\Entity\Category')->delete(3);
		$queryTable = $this->getConnection()->createQueryTable(
            'categories', 'SELECT id, name, description, position FROM categories'
        );
        $expectedTable = $this->createFlatXmlDataSet($GLOBALS['DATASET_PATH'] .'/expectedDeleteCategory.xml')->getTable("categories");
        $this->assertTablesEqual($expectedTable, $queryTable);	
	}
	
	public function testSaveForNewCategory(){
		$category = new Category(array('id' => 0, 'name' => 'CSS', 'description' => 'CSS Blogs'));
		$this->_em->getRepository('GC\Entity\Category')->save($category);
		$queryTable = $this->getConnection()->createQueryTable(
            'categories', 'SELECT id, name, description, position FROM categories'
        );
        $expectedTable = $this->createFlatXmlDataSet($GLOBALS['DATASET_PATH'] .'/expectedInsertCategory.xml')->getTable("categories");
        $this->assertTablesEqual($expectedTable, $queryTable);	
	}
	
	public function testSaveForExistingCategory(){
		$category = $this->_em->find('GC\Entity\Category', 3);
		$category->description = 'General blogs';
		$this->_em->getRepository('GC\Entity\Category')->save($category);
		$queryTable = $this->getConnection()->createQueryTable(
            'categories', 'SELECT id, name, description, position FROM categories'
        );
        $expectedTable = $this->createFlatXmlDataSet($GLOBALS['DATASET_PATH'] .'/expectedUpdateCategory.xml')->getTable("categories");
        $this->assertTablesEqual($expectedTable, $queryTable);	
	}
	
	

}