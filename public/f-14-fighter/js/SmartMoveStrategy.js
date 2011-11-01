/** 
 * @class SmartMoveStrategy
 * moves sprite horizontally from left to right by speed
 * also tries to verticlally align sprite with player
 * @constructor
 * @return  
 * @see MoveStrategy MoveStratgey is the base class 
 */
function SmartMoveStrategy(ship, movementArea, alignmentOffset){
	this.ship = ship;
	this.movementArea = movementArea;
	if(alignmentOffset === undefined){
		alignmentOffset = 5;
	}
	this.alignmentOffset = alignmentOffset;
}

SmartMoveStrategy.prototype = new MoveStrategy();

SmartMoveStrategy.prototype.move = function(movingGameObject){
	if(this.isAboveShip(movingGameObject)){
		movingGameObject.moveDown(this.getVerticalSpeed(movingGameObject)); 
	}
	if(this.isBelowShip(movingGameObject)){
		movingGameObject.moveUp(this.getVerticalSpeed(movingGameObject));
	}
	movingGameObject.moveLeft(movingGameObject.speed); 
}

SmartMoveStrategy.prototype.isAboveShip = function(movingGameObject){
	return (movingGameObject.getY() < this.ship.getY() - this.alignmentOffset);
}

SmartMoveStrategy.prototype.isBelowShip = function(movingGameObject){
	return (movingGameObject.getY() > this.ship.getY() + this.alignmentOffset);
}
	
SmartMoveStrategy.prototype.getVerticalSpeed = function(movingGameObject){
	return Math.ceil(movingGameObject.speed / 1.5);
}

