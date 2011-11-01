<?php
namespace GC\Entity\Repository;
use GC\Entity\Category, GC\Entity\BlogEntry;
class BlogEntryRepositoryTest extends \EntityCase{
	
	protected function setUp(){
		parent::setUp();
	}

	protected function tearDown(){
		parent::tearDown();
	}
	
	protected function getDataSet(){
		return $this->createFlatXMLDataSet($GLOBALS['DATASET_PATH'] .'/blogentryrepository-seed.xml');
	}
	
	public function testGetRecentBlogs(){
		$recentBlogEntries = $this->_em->getRepository('GC\Entity\BlogEntry')->getRecentBlogEntries();	
		$this->assertEquals(5, count($recentBlogEntries));
		$this->assertEquals('30/10/2011', $recentBlogEntries[0]->postDateAsString);
		$this->assertEquals(4, $recentBlogEntries[0]->id);
		$this->assertEquals('30/10/2011', $recentBlogEntries[1]->postDateAsString);
		$this->assertEquals(2, $recentBlogEntries[1]->id);
		$this->assertEquals('20/10/2011', $recentBlogEntries[2]->postDateAsString);
		$this->assertEquals(1, $recentBlogEntries[2]->id);
		$this->assertEquals('10/10/2011', $recentBlogEntries[3]->postDateAsString);
		$this->assertEquals(3, $recentBlogEntries[3]->id);
		$this->assertEquals('10/09/2011', $recentBlogEntries[4]->postDateAsString);
		$this->assertEquals(7, $recentBlogEntries[4]->id);
	}
	
	public function testGetRecentBlogsUsingOffset(){
		$recentBlogEntries = $this->_em->getRepository('GC\Entity\BlogEntry')->getRecentBlogEntries(2);	
		$this->assertEquals(5, count($recentBlogEntries));
		$this->assertEquals('20/10/2011', $recentBlogEntries[0]->postDateAsString);
		$this->assertEquals(1, $recentBlogEntries[0]->id);
		$this->assertEquals('10/10/2011', $recentBlogEntries[1]->postDateAsString);
		$this->assertEquals(3, $recentBlogEntries[1]->id);
		$this->assertEquals('10/09/2011', $recentBlogEntries[2]->postDateAsString);
		$this->assertEquals(7, $recentBlogEntries[2]->id);
		$this->assertEquals('10/09/2011', $recentBlogEntries[3]->postDateAsString);
		$this->assertEquals(6, $recentBlogEntries[3]->id);
		$this->assertEquals('02/09/2011', $recentBlogEntries[4]->postDateAsString);
		$this->assertEquals(5, $recentBlogEntries[4]->id);
	}
	
	public function testTotal(){
		$total = $this->_em->getRepository('GC\Entity\BlogEntry')->total();
		$this->assertEquals(7, $total);	
	}
	
	public function testTotalforCategory(){
		$total = $this->_em->getRepository('GC\Entity\BlogEntry')->totalForCategory(1);
		$this->assertEquals(5, $total);	
	}
	
	public function testGetPagedBlogEntriesForPage1And5Results($page = 1, $resultsPerPage = 5, $orderBy = 'postDate', $orderType = 'DESC'){
		$blogEntries = $this->_em->getRepository('GC\Entity\BlogEntry')->getPagedBlogEntries(1,5);
		$this->assertEquals(5, count($blogEntries));
		$this->assertEquals('30/10/2011', $blogEntries[0]->postDateAsString);
		$this->assertEquals(4, $blogEntries[0]->id);
		$this->assertEquals('30/10/2011', $blogEntries[1]->postDateAsString);
		$this->assertEquals(2, $blogEntries[1]->id);
		$this->assertEquals('20/10/2011', $blogEntries[2]->postDateAsString);
		$this->assertEquals(1, $blogEntries[2]->id);
		$this->assertEquals('10/10/2011', $blogEntries[3]->postDateAsString);
		$this->assertEquals(3, $blogEntries[3]->id);
		$this->assertEquals('10/09/2011', $blogEntries[4]->postDateAsString);
		$this->assertEquals(7, $blogEntries[4]->id);
	}
	
	public function testGetPagedBlogEntriesForCategory1Page1And5Results($page = 1, $resultsPerPage = 5, $orderBy = 'postDate', $orderType = 'DESC'){
		$blogEntries = $this->_em->getRepository('GC\Entity\BlogEntry')->getPagedBlogEntriesForCategory(1, 1,5);
		$this->assertEquals(5, count($blogEntries));
		$this->assertEquals('30/10/2011', $blogEntries[0]->postDateAsString);
		$this->assertEquals(2, $blogEntries[0]->id);
		$this->assertEquals('20/10/2011', $blogEntries[1]->postDateAsString);
		$this->assertEquals(1, $blogEntries[1]->id);
		$this->assertEquals('10/09/2011', $blogEntries[2]->postDateAsString);
		$this->assertEquals(7, $blogEntries[2]->id);
		$this->assertEquals('10/09/2011', $blogEntries[3]->postDateAsString);
		$this->assertEquals(6, $blogEntries[3]->id);
		$this->assertEquals('02/09/2011', $blogEntries[4]->postDateAsString);
		$this->assertEquals(5, $blogEntries[4]->id);
	}
	
	public function testSaveForNewBlogEntry(){
		$category = $this->_em->find('GC\Entity\Category', 1);
		$blogEntry = new BlogEntry(array('id' => 0 , 'postDate' => new \DateTime('2011-10-30'), 'title' => 'Welcome Blog', 'image' => 'welcome.jpg', 'summary' => 'Welcome to my new blog', 'content' => 'Main blog info', 'category' => $category));
		$this->_em->getRepository('GC\Entity\BlogEntry')->save($blogEntry);
		$queryTable = $this->getConnection()->createQueryTable(
            'blog_entries', 'SELECT id, category_id, postDate, title, image, summary, content FROM blog_entries'
        );
        $expectedTable = $this->createFlatXmlDataSet($GLOBALS['DATASET_PATH'] .'/expectedInsertBlogEntry.xml')->getTable("blog_entries");
        $this->assertTablesEqual($expectedTable, $queryTable);	
	}
	
	public function testSaveForExistingBlogEntry(){
		$blogEntry = $this->_em->find('GC\Entity\BlogEntry', 3);
		$blogEntry->summary = 'some summary info';
		$this->_em->getRepository('GC\Entity\BlogEntry')->save($blogEntry);
		$queryTable = $this->getConnection()->createQueryTable(
            'blog_entries', 'SELECT id, category_id, postDate, title, image, summary, content FROM blog_entries'
        );
        $expectedTable = $this->createFlatXmlDataSet($GLOBALS['DATASET_PATH'] .'/expectedUpdateBlogEntry.xml')->getTable("blog_entries");
        $this->assertTablesEqual($expectedTable, $queryTable);	
	}
	
	public function testDoKeywordSearch(){
		$searchTerm = 'my blog content';
		$blogEntries = $this->_em->getRepository('GC\Entity\BlogEntry')->doKeywordSearch($searchTerm);
		$this->assertEquals(7, count($blogEntries));
	}
	
	public function testDoKeywordSearchWhereOnlyOneBlogContainsKeywords(){
		$searchTerm = 'and';
		$blogEntries = $this->_em->getRepository('GC\Entity\BlogEntry')->doKeywordSearch($searchTerm);
		$this->assertEquals(1, count($blogEntries));
	}
	
	public function testDoKeywordSearchWithBlankSearchTerm(){
		$searchTerm = ' ';
		$blogEntries = $this->_em->getRepository('GC\Entity\BlogEntry')->doKeywordSearch($searchTerm);
		$this->assertEquals(0, count($blogEntries));
	}
}