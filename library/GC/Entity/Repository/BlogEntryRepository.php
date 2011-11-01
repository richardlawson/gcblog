<?php
namespace GC\Entity\Repository;

use Doctrine\ORM\Query,
    Doctrine\ORM\EntityRepository; 
    
class BlogEntryRepository extends EntityRepository{
		
	public function findAllOrderedByPostDate(){
		return $this->findBy(array(), array('postDate' => 'DESC'));
	}
	
	
	public function getRecentBlogEntries($offset = 0, $noResults = 5){
		$dql = "SELECT b, c FROM GC\Entity\BlogEntry b JOIN b.category c ORDER BY b.postDate DESC, b.id DESC";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setMaxResults($noResults);
        $query->setFirstResult($offset);
        return $query->getResult();
	}
	
	public function total(){
		$dql = "SELECT COUNT(b.id) FROM GC\Entity\BlogEntry b"; 
        $query = $this->getEntityManager()->createQuery($dql);
        return $query->getSingleScalarResult();
	}
	
	public function totalForCategory($categoryId){
		$categoryId = (int)$categoryId;
		$dql = "SELECT COUNT(b.id) FROM GC\Entity\BlogEntry b JOIN b.category c WHERE c.id = ?1"; 
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter(1, $categoryId); 
        return $query->getSingleScalarResult();
	}
	
	public function getPagedBlogEntries($page = 1, $resultsPerPage = 10, $orderField = 'postDate', $orderType = 'DESC'){
		$orderByDql = $this->getOrderByDqlForPagedBlogEntries($orderField, $orderType);
		$dql = "SELECT b, c FROM GC\Entity\BlogEntry b JOIN b.category c $orderByDql";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setMaxResults($resultsPerPage);
        $query->setFirstResult($resultsPerPage * ($page -1));
        return $query->getResult();
	}
	
	public function getPagedBlogEntriesForCategory($categoryId, $page = 1, $resultsPerPage = 10, $orderField = 'postDate', $orderType = 'DESC'){
		$categoryId = (int)$categoryId;
		$orderByDql = $this->getOrderByDqlForPagedBlogEntries($orderField, $orderType);
		$dql = "SELECT b, c FROM GC\Entity\BlogEntry b JOIN b.category c WHERE c.id = ?1 $orderByDql";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter(1, $categoryId); 
        $query->setMaxResults($resultsPerPage);
        $query->setFirstResult($resultsPerPage * ($page -1));
        return $query->getResult();
	}
	
	protected function getOrderByDqlForPagedBlogEntries($orderField, $orderType){
		$orderByDql = '';
		switch($orderField){
			case 'title':
				$orderByDql = "ORDER BY b.title $orderType, b.postDate DESC";
				break;
			case 'category':
				$orderByDql = "ORDER BY c.name $orderType, b.postDate DESC";
				break;
			default:
				$orderByDql = "ORDER BY b.postDate $orderType, b.id $orderType";
		}
		return $orderByDql;
	}
	
	public function doKeywordSearch($searchTerm){
		if(trim($searchTerm) == ''){
			return array();
		}
		$searchTerm = (string) $searchTerm;
		$keywords = preg_split('/\s+/', trim($searchTerm));
		$dql = "SELECT b, c FROM GC\Entity\BlogEntry b JOIN b.category c";
		$dql .= $this->getKeywordSearchWhereClause($keywords);
		$dql .= 'ORDER BY b.postDate DESC, b.id DESC';
        $query = $this->getEntityManager()->createQuery($dql);
        for($i = 0; $i < count($keywords); $i++){
        	$query->setParameter(($i + 1), "%{$keywords[$i]}%"); 
        }
        return $query->getResult();
    }
    
    protected function getKeywordSearchWhereClause($keywords){
    	$whereClause = ' WHERE';
    	$noKeywords = (int) count($keywords);
		for($i = 1; $i <= $noKeywords; $i++){
			$whereClause .= " b.content LIKE ?$i ";
			if($i != $noKeywords){
				$whereClause .= 'AND ';
			}
		}
		return $whereClause;
    }
    
	public function save($blogEntry){
    	if($blogEntry->id == 0){
    		$this->getEntityManager()->persist($blogEntry);
    	}
    	$this->getEntityManager()->flush();
    }
}