/** 
 * @class MovingGameObject 
 * Should be considered abstract
 * @constructor
 * @return 
 * @see GameObject GameObject is the base class 
 */
function MovingGameObject(elementClass, speed){
	this._elementClass = elementClass;
	this.speed = speed;
	this.movingLeft = false;
	this.movingRight = false;
	this.movingUp = false;
	this.movingDown = false;
}

MovingGameObject.prototype = new GameObject();

/** 
 * this method should be implemented by child classes.   
 */
MovingGameObject.prototype.move = function(){}

MovingGameObject.prototype.moveUp = function(moveAmount){
	this.setY(this.getY() - moveAmount);
}

MovingGameObject.prototype.moveDown = function(moveAmount){
	this.setY(this.getY() + moveAmount);
}

MovingGameObject.prototype.moveLeft = function(moveAmount){
	this.setX(this.getX() - moveAmount);
}

MovingGameObject.prototype.moveRight = function(moveAmount){
	this.setX(this.getX() + moveAmount);
}

MovingGameObject.prototype.isMovingInMoreThanOneDirection = function(){
	var noDirections = 0;
	if(this.movingLeft == true){
		noDirections++;
	}
	if(this.movingRight == true){
		noDirections++;
	}
	if(this.movingUp == true){
		noDirections++;
	}
	if(this.movingDown == true){
		noDirections++;
	}

	if(noDirections > 1){
		return true;
	}else{
		return false;
	}
}


