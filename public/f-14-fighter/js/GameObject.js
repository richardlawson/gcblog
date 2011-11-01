/** 
 * @class GameObject 
 * @constructor
 * @return 
 */
function GameObject(elementClass){
	this._elementClass = elementClass;
	this._element;
	this._canvas;
	this._x;
	this._y;
	this._width;
	this._height;
}

/** 
 * startup method. should be called before anything else
 * creates a DOM element - visual representation of this object - and adds it to the canvas at the given xy point
 */
GameObject.prototype.activate = function(canvas, x, y){
	this._canvas = canvas;
	this._createElement();
	this._addElementToCanvas();
	this._setSize();
	this.moveTo(x, y);
}

GameObject.prototype._createElement = function(){
	this._element = $('<div class="' + this._elementClass + '"><!-- --></div>');	
}

GameObject.prototype._addElementToCanvas = function(){
	this._canvas.element.append(this._element);
}

GameObject.prototype._setSize = function(){
	this._width = this._element.width();
	this._height = this._element.height();
}

GameObject.prototype.moveTo = function(x, y){
	this.setX(x);
	this.setY(y);
}

GameObject.prototype.getElement = function(){
	return this._element;
}
 
GameObject.prototype.setX = function(newPos){
	this._x = newPos;
	this._element.css('left', this._x);
}

GameObject.prototype.getX = function(){
	return this._x;
}

/** 
 * is an alias of get X
 * @see getX
 */
GameObject.prototype.getLeft = function(){
	return this._x;
}

GameObject.prototype.getRight = function(){
	return this._x + this._width;
}

GameObject.prototype.setY = function(newPos){
	this._y = newPos;
	this._element.css('top', this._y);
}

GameObject.prototype.getY = function(){
	return this._y;
}

/** 
 * is an alias of get Y
 * @see getY
 */
GameObject.prototype.getTop = function(){
	return this._y;
}

GameObject.prototype.getBottom = function(){
	return this._y + this._height;
}

GameObject.prototype.getWidth = function(){
	return this._width;
}

GameObject.prototype.getHeight = function(){
	return this._height;
}

GameObject.prototype.getVerticalMidPoint = function(){
	return (this._y + (this._height/2));
}

GameObject.prototype.getHorizontalMidPoint = function(){
	return (this._x + (this._width /2));
}

/** 
 * removes game object's element from DOM
 */
GameObject.prototype.destroy = function(){	
	this._element.remove();
}
