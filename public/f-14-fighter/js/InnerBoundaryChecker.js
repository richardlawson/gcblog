/**
 * @class InnerBoundaryChecker 
 * @constructor
 * @return
 */
function InnerBoundaryChecker(){
	
}

InnerBoundaryChecker.isInBounds = function(gameObject, area, offset){
	if(!this.isInLeftBounds(gameObject, area, offset)){
		return false; 
	}
	if(!this.isInRightBounds(gameObject, area, offset)){
		return false; 
	}
	if(!this.isInUpperBounds(gameObject, area, offset)){
		return false; 
	}
	if(!this.isInLowerBounds(gameObject, area, offset)){
		return false; 
	}
	return true;
}

InnerBoundaryChecker.isInLeftBounds = function(gameObject, area, offset){
	if(offset === undefined){
		offset = 0;
	}
	return (gameObject.getLeft() >= area.x + offset);
}

InnerBoundaryChecker.isInRightBounds = function(gameObject, area, offset){
	if(offset === undefined){
		offset = 0;
	}
	return (gameObject.getRight() <= area.width - offset);
}

InnerBoundaryChecker.isInUpperBounds = function(gameObject, area, offset){
	if(offset === undefined){
		offset = 0;
	}
	return (gameObject.getTop() >= area.y + offset);
}

InnerBoundaryChecker.isInLowerBounds = function(gameObject, area, offset){
	if(offset === undefined){
		offset = 0;
	}
	return (gameObject.getBottom() <= area.height - offset);
}