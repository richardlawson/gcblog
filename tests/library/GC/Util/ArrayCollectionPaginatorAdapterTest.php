<?php
namespace GC\Util;
use Doctrine\Common\Collections\ArrayCollection;

class ArrayCollectionPaginatorAdapterTest extends \SimpleTestCase{
	
	
	protected function getPopulatedArrayCollection(){
		$collection = new ArrayCollection();
		$collection->add('string 1');
		$collection->add('string 2');
		$collection->add('string 3');
		$collection->add('string 4');
		$collection->add('string 5');
		return $collection;
	}
	
	public function testCount(){
		$collection = $this->getPopulatedArrayCollection();
		$this->assertEquals(5, count($collection));
		$acAdapter = new ArrayCollectionPaginatorAdapter($collection);
		$this->assertEquals(5, $acAdapter->count());
	}
	
	public function testGetItems(){
		$collection = $this->getPopulatedArrayCollection();
		$acAdapter = new ArrayCollectionPaginatorAdapter($collection);
		$items = $acAdapter->getItems(0, 5);
		$this->assertEquals(5, count($items));
	}
	
	public function testGetItemsWithOffsetOf2AndItemCountPerPageOf3(){
		$collection = $this->getPopulatedArrayCollection();
		$acAdapter = new ArrayCollectionPaginatorAdapter($collection);
		$items = $acAdapter->getItems(2, 3);
		$this->assertEquals(3, count($items));
		$this->assertEquals('string 3', $items[0]);
		$this->assertEquals('string 4', $items[1]);
		$this->assertEquals('string 5', $items[2]);
	}
	
	public function testGetItemsWithItemCountPerPageThatIsGreaterThanCollectionSize(){
		$collection = $this->getPopulatedArrayCollection();
		$acAdapter = new ArrayCollectionPaginatorAdapter($collection);
		$items = $acAdapter->getItems(0, 10);
		$this->assertEquals(5, count($items));
	}
	
	public function testGetItemsWithNonExistentOffsetReturnsEmptyArray(){
		$collection = $this->getPopulatedArrayCollection();
		$acAdapter = new ArrayCollectionPaginatorAdapter($collection);
		$items = $acAdapter->getItems(10, 3);
		$this->assertTrue(is_array($items));
		$this->assertEquals(0, count($items));
	}
	
	
}