<?php
namespace GC\Util;
use Doctrine\Common\Collections\ArrayCollection;

class ArrayCollectionPaginatorAdapter implements \Zend_Paginator_Adapter_Interface{
	
	protected $_collection;
	
	public function __construct($collection){
		$this->_collection = $collection;
	}
	
	public function count(){
		return count($this->_collection);
	}
	
	public function getItems($offset, $itemCountPerPage){
		$offset = (int) $offset;
		$itemCountPerPage = (int) $itemCountPerPage;
		$items = $this->_collection->slice($offset, $itemCountPerPage);
		// calling slice on doctrine's ArrayCollection returns an array with the existing keys intact
		// however, we want keys to be reset - same as PHP's array_slice method  
		// Solution: reset keys using array_merge.
		$items = array_merge($items);
		return $items;
	}
	
}