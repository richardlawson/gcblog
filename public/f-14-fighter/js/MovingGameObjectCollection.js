/** 
 * @class MovingGameObjectCollection 
 * @constructor
 * @return 
 * @see SimpleCollection SimpleCollection is the base class 
 * note: it is recommended that destroyAndRemove methods are used in preference of simple removes. 
 *       This ensures that the game object destroy method is called before removing it from the collection.
 */
function MovingGameObjectCollection(){
	this._items = new Array();
}

MovingGameObjectCollection.prototype = new SimpleCollection();

MovingGameObjectCollection.prototype.move = function(){
	for(var i = 0; i < this._items.length; i++){ 
 		this._items[i].move();
 	} 
}

MovingGameObjectCollection.prototype.destroyAndRemoveItem = function(MovingGameObject){
 	MovingGameObject.destroy();
 	this.removeItem(MovingGameObject); 
}

MovingGameObjectCollection.prototype.destroyAndRemoveItemAt = function(pos){
	this.destroyItemAt(pos);
 	this.removeItemAt(pos); 
}

MovingGameObjectCollection.prototype.destroyAndRemoveAll = function(){
	for(var i = 0; i < this._items.length; i++){ 
		this.destroyItemAt(i);
 	} 
	this.removeAll();
}

MovingGameObjectCollection.prototype.destroyItemAt = function(pos){
	this._items[pos].destroy();
}