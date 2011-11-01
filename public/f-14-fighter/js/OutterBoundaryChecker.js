/**
 * @class OutterBoundaryChecker 
 * @constructor
 * @return
 */
function OutterBoundaryChecker(){
	
}

OutterBoundaryChecker.isInBounds = function(gameObject, area, offset){
	if(this.isInLeftBounds(gameObject, area, offset)){
		return true; 
	}
	if(this.isInRightBounds(gameObject, area, offset)){
		return true; 
	}
	if(!this.isInUpperBounds(gameObject, area, offset)){
		return true; 
	}
	if(!this.isInLowerBounds(gameObject, area, offset)){
		return true; 
	}
	return false;
}

OutterBoundaryChecker.isInLeftBounds = function(gameObject, area, offset){
	if(offset === undefined){
		offset = 0;
	}
	return (gameObject.getRight() >= area.x + offset);
}

OutterBoundaryChecker.isInRightBounds = function(gameObject, area, offset){
	if(offset === undefined){
		offset = 0;
	}
	return (gameObject.getLeft() <= area.width - offset);
}

OutterBoundaryChecker.isInUpperBounds = function(gameObject, area, offset){
	if(offset === undefined){
		offset = 0;
	}
	return (gameObject.getBottom() >= area.y + offset);
}

OutterBoundaryChecker.isInLowerBounds = function(gameObject, area, offset){
	if(offset === undefined){
		offset = 0;
	}
	return (gameObject.getTop() <= area.height - offset);
}