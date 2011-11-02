<?php
namespace GC\Entity;
use Doctrine\ORM\Query;
class BlogEntryTest extends \EntityCase{
	
	protected $_category;
	
	protected function setUp(){
		parent::setUp();
		$this->_blogEntry = new BlogEntry();
		$this->_category = new Category();
	}

	protected function tearDown(){
		parent::tearDown();
	}
	
	protected function getDataSet(){
		return $this->createFlatXMLDataSet($GLOBALS['DATASET_PATH'] .'/blogEntry-seed.xml');
	}
	
	public function testConstructor(){
		$blogEntry = new BlogEntry(array('id' => 1 , 'postDate' => new \DateTime('2011-10-30'), 'title' => 'Welcome Blog', 'image' => 'welcome.jpg', 'summary' => 'Welcome to my new blog', 'content' => 'Main blog info'));
		$this->assertEquals(1, $blogEntry->id);
		$this->assertEquals(new \DateTime('2011-10-30'), $blogEntry->postDate);
		$this->assertEquals('Welcome Blog', $blogEntry->title);
		$this->assertEquals('welcome.jpg', $blogEntry->image);
		$this->assertEquals('Welcome to my new blog', $blogEntry->summary);
		$this->assertEquals('Main blog info', $blogEntry->content);
	}
	
	public function testPopulate(){
		$blogEntry = new BlogEntry(); 
		$blogEntry->populate(array('id' => 1 , 'postDate' => new \DateTime('2011-10-30'), 'title' => 'Welcome Blog', 'image' => 'welcome.jpg', 'summary' => 'Welcome to my new blog', 'content' => 'Main blog info'));
		$this->assertEquals(1, $blogEntry->id);
		$this->assertEquals(new \DateTime('2011-10-30'), $blogEntry->postDate);
		$this->assertEquals('Welcome Blog', $blogEntry->title);
		$this->assertEquals('welcome.jpg', $blogEntry->image);
		$this->assertEquals('Welcome to my new blog', $blogEntry->summary);
		$this->assertEquals('Main blog info', $blogEntry->content);
	}
	
	public function testToArray(){
		$category = $this->_em->find('GC\Entity\Category', 1);
		$blogEntry = new BlogEntry(array('id' => 1 , 'postDate' => new \DateTime('2011-10-30'), 'title' => 'Welcome Blog', 'image' => 'welcome.jpg', 'summary' => 'Welcome to my new blog', 'content' => 'Main blog info', 'category' => $category));
		$blogEntryAsArray = $blogEntry->toArray();
		$this->assertEquals(1, $blogEntryAsArray['id']);
		$this->assertEquals('30/10/2011', $blogEntryAsArray['postDate']);
		$this->assertEquals('30/10/2011', $blogEntryAsArray['postDateAsString']);
		$this->assertEquals('Welcome Blog', $blogEntryAsArray['title']);
		$this->assertEquals('welcome.jpg', $blogEntryAsArray['image']);
		$this->assertEquals('Welcome to my new blog', $blogEntryAsArray['summary']);
		$this->assertEquals('Main blog info', $blogEntryAsArray['content']);
		$this->assertEquals(1, $blogEntryAsArray['categoryId']);
	}
	
	public function testIdProperty(){
		$this->_blogEntry->id = 5;
		$this->assertEquals(5, $this->_blogEntry->id);
	}
	
	public function testIdSetterAndGetter(){
		$this->_blogEntry->setId(5);
		$this->assertEquals(5, $this->_blogEntry->getId());
	}
	
	public function testPostDateProperty(){
		$this->_blogEntry->postDate = new \DateTime('2011-12-30');
		$this->assertEquals(new \DateTime('2011-12-30'), $this->_blogEntry->postDate);
	}
	
	public function testPostDateSetterAndGetter(){
		$this->_blogEntry->setPostDate(new \DateTime('2011-12-30'));
		$this->assertEquals(new \DateTime('2011-12-30'), $this->_blogEntry->getPostDate());
	}
	
	public function testPostDateAsStringProperty(){
		$this->_blogEntry->postDateAsString = '12/10/2011';
		$this->assertEquals('12/10/2011', $this->_blogEntry->postDateAsString);
	}
	
	public function testPostDateAsStringSetterAndGetter(){
		$this->_blogEntry->setPostDateAsString('30/03/2011');
		$this->assertEquals(new \DateTime('2011-03-30'), $this->_blogEntry->getPostDate());
		$this->assertEquals('30/03/2011', $this->_blogEntry->getPostDateAsString());
	}
	
	/**
     * @expectedException GC\Util\InvalidDateFormatException
     */
	public function testSetPostDateAsStringUsingInvalidDateFormat(){
		$this->_blogEntry->setPostDateAsString('30 oct 2011');
	}
	
	/**
     * @expectedException GC\Util\InvalidDateException
     */
	public function testSetPostDateAsStringUsingInvalidDate(){
		$this->_blogEntry->setPostDateAsString('30/02/2011');
	}
	
	public function testTitleProperty(){
		$this->_blogEntry->title = 'Welcome blog';
		$this->assertEquals('Welcome blog', $this->_blogEntry->title);
	}
	
	public function testTitleSetterAndGetter(){
		$this->_blogEntry->setTitle('PHP Blog');
		$this->assertEquals('PHP Blog', $this->_blogEntry->getTitle());
	}
	
	public function testImageProperty(){
		$this->_blogEntry->image = 'hello.gif';
		$this->assertEquals('hello.gif', $this->_blogEntry->image);
	}
	
	public function testImageSetterAndGetter(){
		$this->_blogEntry->setImage('hi.gif');
		$this->assertEquals('hi.gif', $this->_blogEntry->getImage());
	}
	
	public function testSummaryProperty(){
		$this->_blogEntry->summary = 'blog summary';
		$this->assertEquals('blog summary', $this->_blogEntry->summary);
	}
	
	public function testSummarySetterAndGetter(){
		$this->_blogEntry->setSummary('blog summary');
		$this->assertEquals('blog summary', $this->_blogEntry->getSummary());
	}
	
	public function testContentProperty(){
		$this->_blogEntry->content = 'some blog text';
		$this->assertEquals('some blog text', $this->_blogEntry->content);
	}
	
	public function testContentSetterAndGetter(){
		$this->_blogEntry->setContent('some blog text');
		$this->assertEquals('some blog text', $this->_blogEntry->getContent());
	}
	
	public function testCategoryProperty(){
		$this->_category->name = 'Games';
		$this->_blogEntry->category = $this->_category;
		$this->assertEquals('Games', $this->_blogEntry->category->name);
	}
	
	public function testCategorySetterAndGetter(){
		$this->_category->name = 'Games';
		$this->_blogEntry->setCategory($this->_category);
		$this->assertEquals('Games', $this->_blogEntry->getCategory()->name);
	}
	
	public function testBlogEntryAddedToCategoryBlogEntriesWhenCategorySet(){
		$this->assertEquals(0, count($this->_category->blogEntries));
		$this->_blogEntry->setCategory($this->_category);
		$this->assertEquals(1, count($this->_category->blogEntries));
	}
	
	public function testAddComment(){
		$comment = new Comment();
		$this->_blogEntry->addComment($comment);
		$this->assertEquals(1, count($this->_blogEntry->getComments()));
	}
	
	public function testFindBlogEntry(){
		$blogEntry = $this->_em->find('GC\Entity\BlogEntry', 1);
		$this->assertEquals('1', $blogEntry->id);
		$this->assertEquals(new \DateTime('2011-10-30'), $blogEntry->postDate);
		$this->assertEquals('30/10/2011', $blogEntry->postDateAsString);
		$this->assertEquals('My blog', $blogEntry->title);
		$this->assertEquals('blog.jpg', $blogEntry->image);
		$this->assertEquals('My blog summary', $blogEntry->summary);
		$this->assertEquals('My blog content', $blogEntry->content);
	}
	
	public function testSaveBlogEntry(){
		$category = $this->_em->find('GC\Entity\Category', 1);
		$blogEntry = new BlogEntry(array('postDate' => new \DateTime('1975-09-15'), 'title' => 'My birthday blog', 'image' => 'birthday.jpg', 'summary' => 'Birthday blog summary', 'content' => 'Birthday blog content', 'category' => $category));
		$this->_em->persist($blogEntry);
		$this->_em->flush();
		$queryTable = $this->getConnection()->createQueryTable(
            'blog_entries', 'SELECT id, category_id, postDate, title, image, summary, content FROM blog_entries'
        );
        $expectedTable = $this->createFlatXmlDataSet($GLOBALS['DATASET_PATH'] .'/expectedBlogEntry.xml')->getTable("blog_entries");
        $this->assertTablesEqual($expectedTable, $queryTable);
	}
	
}