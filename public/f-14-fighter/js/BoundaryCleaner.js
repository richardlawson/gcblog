/**
 * @class BoundaryCleaner 
 * @constructor
 * @return
 */
function BoundaryCleaner(){
	
}

BoundaryCleaner.doFullBoundaryCleanUp = function(movingGameObjects, movementArea){
	for(var i=0; i < movingGameObjects.length(); i++){
		if(!OutterBoundaryChecker.isInBounds(movingGameObjects.getItemAt(i), movementArea)){
			movingGameObjects.destroyAndRemoveItemAt(i);
		}
	}
}

BoundaryCleaner.doLeftBoundaryCleanUp = function(movingGameObjects, movementArea){
	for(var i=0; i < movingGameObjects.length(); i++){
		if(!OutterBoundaryChecker.isInLeftBounds(movingGameObjects.getItemAt(i), movementArea)){
			movingGameObjects.destroyAndRemoveItemAt(i);
		}
	}
}

BoundaryCleaner.doRightBoundaryCleanUp = function(movingGameObjects, movementArea){
	for(var i=0; i < movingGameObjects.length(); i++){
		if(!OutterBoundaryChecker.isInRightBounds(movingGameObjects.getItemAt(i), movementArea)){
			movingGameObjects.destroyAndRemoveItemAt(i);
		}
	}
}

BoundaryCleaner.doUpperBoundaryCleanUp = function(movingGameObjects, movementArea){
	for(var i=0; i < movingGameObjects.length(); i++){
		if(!OutterBoundaryChecker.isInUpperBounds(movingGameObjects.getItemAt(i), movementArea)){
			movingGameObjects.destroyAndRemoveItemAt(i);
		}
	}
}

BoundaryCleaner.doLowerBoundaryCleanUp = function(movingGameObjects, movementArea){
	for(var i=0; i < movingGameObjects.length(); i++){
		if(!OutterBoundaryChecker.isInLowerBounds(movingGameObjects.getItemAt(i), movementArea)){
			movingGameObjects.destroyAndRemoveItemAt(i);
		}
	}
}