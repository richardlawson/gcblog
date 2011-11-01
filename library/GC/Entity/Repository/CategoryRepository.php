<?php
namespace GC\Entity\Repository;

use Doctrine\ORM\Query,
    Doctrine\ORM\EntityRepository; 
    
class CategoryRepository extends EntityRepository{
		
	public function findAllOrderedByPosition(){
		return $this->findBy(array(), array('position' => 'ASC'));
	}

	public function getHighestPosition(){
		$dql = "SELECT MAX(c.position) FROM GC\Entity\Category c"; 
        $query = $this->getEntityManager()->createQuery($dql);
        return $query->getSingleScalarResult();
	}
	
	public function reorder($id, $reorderType){
    	$id = (int) $id;
    	$reorderType = (int) $reorderType;
    	if(\GC\Entity\Category::REORDER_UP == $reorderType){
			$this->reorderUp($id);
		}elseif(\GC\Entity\Category::REORDER_DOWN == $reorderType){
			$this->reorderDown($id);
		}	
    }
    
	public function reorderUp($id){
		$id = (int) $id;
    	$selectedCategory = $this->find($id);
    	if($selectedCategory->position > 1){
    		$previousCategory = $this->findOneBy(array('position' => ($selectedCategory->position - 1)));
    		$selectedCategory->position--;
    		$previousCategory->position++;
    		$this->getEntityManager()->flush();
    	}
    }
    
	public function reorderDown($id){
		$id = (int) $id;
		$selectedCategory = $this->find($id);
		if($selectedCategory->position < $this->getHighestPosition()){
	    	$nextCategory = $this->findOneBy(array('position' => ($selectedCategory->position + 1)));
	    	$selectedCategory->position++;
	    	$nextCategory->position--;
	    	$this->getEntityManager()->flush();
		}
    }
    
 	public function save($category){
    	if($category->id == 0){
    		$category->position = $this->getHighestPosition() + 1;
    		$this->getEntityManager()->persist($category);
    	}
    	$this->getEntityManager()->flush();
    }

    public function delete($id){
    	$id = (int)$id;
    	$category = $this->find($id);
    	$this->moveupAllBelowPosition($category->position);
    	$this->getEntityManager()->remove($category);
    	$this->getEntityManager()->flush();
    }
    
    public function moveupAllBelowPosition($position){
    	$position = (int) $position;
    	$dql = "UPDATE GC\Entity\Category c SET c.position = (c.position - 1) WHERE c.position > ?1";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setParameter(1, $position); 
        $query->execute();
    }
	
}