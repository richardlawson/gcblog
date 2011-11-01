/** 
 * @class SimpleUpDownMoveStrategy
 * moves game object up and down 
 * @constructor
 * @return  
 * @see MoveStrategy MoveStratgey is the base class 
 */
function SimpleUpDownMoveStrategy(movementArea, startVerticalMovementAtPercent){
	this.movementArea = movementArea;
	//percentage of movementArea that object will move horizontally to before starting to move up and down.	
	if(startVerticalMovementAtPercent === undefined){
		startVerticalMovementAtPercent = 25;
	}
	this.startVerticalMovementAtPercent = startVerticalMovementAtPercent;
}

SimpleUpDownMoveStrategy.prototype = new MoveStrategy();

SimpleUpDownMoveStrategy.prototype.move = function(movingGameObject){
	if(this.isTimeForVerticalMovement(movingGameObject)){
		this.moveVertically(movingGameObject);
	}else{
		movingGameObject.moveLeft(movingGameObject.speed); 
	}
}

SimpleUpDownMoveStrategy.prototype.isTimeForVerticalMovement = function(movingGameObject){
	return (movingGameObject.getX() <= this.getVerticalMovementStartXPos());
}

SimpleUpDownMoveStrategy.prototype.getVerticalMovementStartXPos = function(){
	return (this.movementArea.width - Math.round((this.startVerticalMovementAtPercent / 100) * this.movementArea.width));
}

SimpleUpDownMoveStrategy.prototype.moveVertically = function(movingGameObject){
	if(this.isMovingUp(movingGameObject)){
		movingGameObject.moveUp(movingGameObject.speed);
	}else{
		movingGameObject.moveDown(movingGameObject.speed);
	}		
}

SimpleUpDownMoveStrategy.prototype.isMovingUp = function(movingGameObject){
	if(!InnerBoundaryChecker.isInUpperBounds(movingGameObject, this.movementArea, this.verticalOffset)){
		movingGameObject.movingUp = false;
	}else if(!InnerBoundaryChecker.isInLowerBounds(movingGameObject, this.movementArea, this.verticalOffset)){
		movingGameObject.movingUp = true;
	}
	return movingGameObject.movingUp;
}
