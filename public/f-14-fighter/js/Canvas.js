/**
 * @class CollisionDetector
 * @constructor
 * @return
 */
function Canvas(element){
	this.element = element;
	this._backgroundXPos = 0;
	this.backgroundSpeed = 2;
	this._width = element.width();
	this._height = element.height();

	this.setWidth = function(newWidth){
		this._width = newWidth;
	}

	this.getWidth = function(){
		return this._width;
	}

	this.setHeight = function(newHeight){
		this._height = newHeight;
	}

	this.getHeight = function(){
		return this._height;
	}
	
	this.scrollBackground = function(){
		this._backgroundXPos -= this.backgroundSpeed;
		this.element.css("background-position", this._backgroundXPos + "px");
	}
}