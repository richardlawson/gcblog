<?php
namespace GC\Entity;
use Doctrine\ORM\Query;
class CommentTest extends \EntityCase{
	
	protected $_comment;
	protected $_blogEntry;
	
	protected function setUp(){
		parent::setUp();
		$this->_comment = new Comment();
		$this->_blogEntry = new BlogEntry();
	}

	protected function tearDown(){
		parent::tearDown();
	}
	
	protected function getDataSet(){
		return $this->createFlatXMLDataSet($GLOBALS['DATASET_PATH'] .'/comment-seed.xml');
	}
	
	public function testConstructor(){
		$comment = new Comment(array('id' => 5 , 'postDate' => new \DateTime('2011-10-30'), 'name' => 'richard', 'email' => 'lawson_richard@hotmail.com', 'content' => 'hello world'));
		$this->assertEquals(5, $comment->id);
		$this->assertEquals(new \DateTime('2011-10-30'), $comment->postDate);
		$this->assertEquals('richard', $comment->name);
		$this->assertEquals('lawson_richard@hotmail.com', $comment->email);
		$this->assertEquals('hello world', $comment->content);
	}
	
	public function testPopulate(){
		$comment = new Comment();
		$comment->populate(array('id' => 5 , 'postDate' => new \DateTime('2011-10-30'), 'name' => 'richard', 'email' => 'lawson_richard@hotmail.com', 'content' => 'hello world'));
		$this->assertEquals(5, $comment->id);
		$this->assertEquals(new \DateTime('2011-10-30'), $comment->postDate);
		$this->assertEquals('richard', $comment->name);
		$this->assertEquals('lawson_richard@hotmail.com', $comment->email);
		$this->assertEquals('hello world', $comment->content);
	}
	
	public function testToArray(){
		$blogEntry = new BlogEntry(array('id' => 1));
		$comment = new Comment(array('id' => 5 , 'postDate' => new \DateTime('2011-10-30'), 'name' => 'richard', 'email' => 'lawson_richard@hotmail.com', 'content' => 'hello world', 'blogEntry' => $blogEntry));
		$commentAsArray = $comment->toArray();
		$this->assertEquals(5, $commentAsArray['id']);
		$this->assertEquals('30/10/2011', $commentAsArray['postDate']);
		$this->assertEquals('30/10/2011', $commentAsArray['postDateAsString']);
		$this->assertEquals('richard', $commentAsArray['name']);
		$this->assertEquals('lawson_richard@hotmail.com', $commentAsArray['email']);
		$this->assertEquals('hello world', $commentAsArray['content']);
	}
	
	public function testIdProperty(){
		$this->_comment->id = 5;
		$this->assertEquals(5, $this->_comment->id);
	}
	
	public function testIdSetterAndGetter(){
		$this->_comment->setId(5);
		$this->assertEquals(5, $this->_comment->getId());
	}
	
	public function testNameProperty(){
		$this->_comment->name = 'richard';
		$this->assertEquals('richard', $this->_comment->name);
	}
	
	public function testNameSetterAndGetter(){
		$this->_comment->setName('richard');
		$this->assertEquals('richard', $this->_comment->getName());
	}
	
	public function testEmailProperty(){
		$this->_comment->email = 'lawson_richard@hotmail.com';
		$this->assertEquals('lawson_richard@hotmail.com', $this->_comment->email);
	}
	
	public function testEmailSetterAndGetter(){
		$this->_comment->setEmail('lawson_richard@hotmail.com');
		$this->assertEquals('lawson_richard@hotmail.com', $this->_comment->getEmail());
	}
	
	public function testContentProperty(){
		$this->_comment->content = 'hello world!';
		$this->assertEquals('hello world!', $this->_comment->content);
	}
	
	public function testContentSetterAndGetter(){
		$this->_comment->setContent('hello world!');
		$this->assertEquals('hello world!', $this->_comment->getContent());
	}
	
	public function testPostDateProperty(){
		$this->_comment->postDate = new \DateTime('2011-12-30');
		$this->assertEquals(new \DateTime('2011-12-30'), $this->_comment->postDate);
	}
	
	public function testPostDateSetterAndGetter(){
		$this->_comment->setPostDate(new \DateTime('2011-12-30'));
		$this->assertEquals(new \DateTime('2011-12-30'), $this->_comment->getPostDate());
	}
	
	public function testPostDateAsStringProperty(){
		$this->_comment->postDateAsString = '12/10/2011';
		$this->assertEquals('12/10/2011', $this->_comment->postDateAsString);
	}
	
	public function testPostDateAsStringSetterAndGetter(){
		$this->_comment->setPostDateAsString('30/03/2011');
		$this->assertEquals(new \DateTime('2011-03-30'), $this->_comment->getPostDate());
		$this->assertEquals('30/03/2011', $this->_comment->getPostDateAsString());
	}
	
	/**
     * @expectedException GC\Util\InvalidDateFormatException
     */
	public function testSetPostDateAsStringUsingInvalidDateFormat(){
		$this->_comment->setPostDateAsString('30 oct 2011');
	}
	
	/**
     * @expectedException GC\Util\InvalidDateException
     */
	public function testSetPostDateAsStringUsingInvalidDate(){
		$this->_comment->setPostDateAsString('30/02/2011');
	}
	
	public function testBlogEntryProperty(){
		$this->_blogEntry->title = 'php blog';
		$this->_comment->blogEntry = $this->_blogEntry;
		$this->assertEquals('php blog', $this->_comment->blogEntry->title);
	}
	
	public function testBlogEntrySetterAndGetter(){
		$this->_blogEntry->title = 'php blog';
		$this->_comment->setBlogEntry($this->_blogEntry);
		$this->assertEquals('php blog', $this->_comment->getBlogEntry()->title);
	}
	
	public function testCommentAddedToBlogEntryCommentsWhenBlogEntrySet(){
		$this->assertEquals(0, count($this->_blogEntry->comments));
		$this->_comment->setBlogEntry($this->_blogEntry);
		$this->assertEquals(1, count($this->_blogEntry->comments));
	}
	
	public function testFindComment(){
		$comment = $this->_em->find('GC\Entity\Comment', 1);
		$this->assertEquals(1, $comment->id);
		$this->assertEquals(new \DateTime('2011-10-30'), $comment->postDate);
		$this->assertEquals('30/10/2011', $comment->postDateAsString);
		$this->assertEquals('richard', $comment->name);
		$this->assertEquals('lawson_richard@hotmail.com', $comment->email);
		$this->assertEquals('hello', $comment->content);
	}
	
	public function testSaveComment(){
		$comment = new Comment(array('id' => 5 , 'postDate' => new \DateTime('2011-10-30'), 'name' => 'richard', 'email' => 'lawson_richard@hotmail.com', 'content' => 'hello world'));
		$this->_em->persist($comment);
		$this->_em->flush();
		$queryTable = $this->getConnection()->createQueryTable(
            'comments', 'SELECT id, postDate, name, email, content FROM comments'
        );
        $expectedTable = $this->createFlatXmlDataSet($GLOBALS['DATASET_PATH'] .'/expectedComment.xml')->getTable("comments");
        $this->assertTablesEqual($expectedTable, $queryTable);
	}
	
	public function testUpdateComment(){
		// note: you must getting existing entity from db to update it.
		$comment = $this->_em->find('GC\Entity\Comment', 1);
		$comment->name = "Updated name";
		$comment->content = "Updated content";
		$this->_em->flush();
		$queryTable = $this->getConnection()->createQueryTable(
        	'comments', 'SELECT id, postDate, name, email, content FROM comments'
        );
        $expectedTable = $this->createFlatXmlDataSet($GLOBALS['DATASET_PATH'] .'/expectedUpdatedComment.xml')->getTable("comments");
        $this->assertTablesEqual($expectedTable, $queryTable);
	}
	
	public function testDeleteComment(){
		$comment = $this->_em->find('GC\Entity\Comment', 1);
		$this->_em->remove($comment);
		$this->_em->flush();
		$queryTable = $this->getConnection()->createQueryTable(
            'comments', 'SELECT id, postDate, name, email, content FROM comments'
        );
        $expectedTable = $this->createFlatXmlDataSet($GLOBALS['DATASET_PATH'] .'/expectedDeletedComment.xml')->getTable("comments");
        $this->assertTablesEqual($expectedTable, $queryTable);
	}
	
}