/**
 * @class CollisionDetector
 * @constructor
 * @return
 */
function CollisionDetector(){
	
}
CollisionDetector.isCollision = function(gameObject1, gameObject2) { 
	if(gameObject1.getLeft() > gameObject2.getRight()){
    	return false;
    }
    if(gameObject1.getBottom() < gameObject2.getTop()){
    	return false;
	}
    if(gameObject1.getTop() > gameObject2.getBottom()){
    	return false;
    }
    if(gameObject1.getRight() < gameObject2.getLeft()){
    	return false;
    }
    return true;	
}
