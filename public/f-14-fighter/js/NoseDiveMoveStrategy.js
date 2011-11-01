/** 
 * @class NoseDiveMoveStrategy
 * moves game object horizontally from left to right by speed
 * starts to nose dive object (move left and down at same time) at the specified percentage
 * @constructor
 * @return  
 * @see MoveStrategy MoveStratgey is the base class 
 */
function NoseDiveMoveStrategy(movementArea, diveAtPercent){
	this.movementArea = movementArea;
	//percentage of movementArea that object will start to nose dive at. 
	// e.g. 30 would mean that the object will move 30% into its movement area before starting to dive  
	if(diveAtPercent === undefined){
		diveAtPercent = 35;
	}
	this.diveAtPercent = diveAtPercent;
}

NoseDiveMoveStrategy.prototype = new MoveStrategy();

NoseDiveMoveStrategy.prototype.move = function(movingGameObject){
	if(this.isTimeForNoseDive(movingGameObject) && InnerBoundaryChecker.isInLowerBounds(movingGameObject, this.movementArea, 5)){
		movingGameObject.moveDown(movingGameObject.speed / 1.5);
	}
	movingGameObject.moveLeft(movingGameObject.speed); 
}

NoseDiveMoveStrategy.prototype.isTimeForNoseDive = function(movingGameObject){
	return (movingGameObject.getX() <= this.getDiveXPos());
}

NoseDiveMoveStrategy.prototype.getDiveXPos = function(){
	return (this.movementArea.width - Math.round((this.diveAtPercent / 100) * this.movementArea.width));
}

NoseDiveMoveStrategy.prototype.getVerticalSpeed = function(movingGameObject){
	return Math.ceil(movingGameObject.speed / 2);
}
