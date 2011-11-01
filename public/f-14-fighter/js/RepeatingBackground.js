/** 
 * @class RepeatingBackground 
 * @constructor
 * @return 
 */
function RepeatingBackground(elementClass, speed){
	this._elementClass = elementClass;
	this.speed = speed;
	this.background;
	this.backgroundRepeat;
}

RepeatingBackground.prototype.activate = function(canvas){
	this.background = new MovingGameObject(this._elementClass, this.speed);
	this.background.activate(canvas, 0, 0);
	this.backgroundRepeat = new MovingGameObject(this._elementClass, this.speed);
	this.backgroundRepeat.activate(canvas, this.background.getWidth() + 1, 0);
}

RepeatingBackground.prototype.move = function(){
	this.moveBackground(this.background);
	this.moveBackground(this.backgroundRepeat);
}

RepeatingBackground.prototype.moveBackground = function(background){
	if(this.isShiftRequired(background)){
		this.shift(background);
	}
	background.moveLeft(this.speed);
}

RepeatingBackground.prototype.isShiftRequired = function(background){
	return (background.getLeft() < -(background.getWidth()));
}

RepeatingBackground.prototype.shift = function(background){
	background.setX(background.getWidth());
}

RepeatingBackground.prototype.destroy = function(){	
	this.background.destroy();
	this.backgroundRepeat.destroy();
}
