<?php
namespace GC\Entity\Repository;

use Doctrine\ORM\Query,
    Doctrine\ORM\EntityRepository; 
    
class ScoreRepository extends EntityRepository{
		
	public function getHighScores($noScores = 10){
		$dql = "SELECT s, g FROM GC\Entity\Score s JOIN s.gamer g ORDER BY s.points DESC, s.id";
        $query = $this->getEntityManager()->createQuery($dql);
        $query->setMaxResults($noScores);
        return $query->getResult();
	}
}