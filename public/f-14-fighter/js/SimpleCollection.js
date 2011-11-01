/** 
 * @class SimpleCollection
 * Simple wrapper for js array so that it can support subclassing (functionality does not exist currently) 
 * @constructor
 * @return 
*/
function SimpleCollection(){
	this._items = new Array();
}

SimpleCollection.prototype.length = function(){
	return this._items.length;
}

SimpleCollection.prototype.addItem = function(item){
	this._items.push(item);
}

SimpleCollection.prototype.addItems = function(items){
	for(var i=0; i < items.length; i++){
		this._items.push(items[i]);
	}
}

SimpleCollection.prototype.getItemAt = function(pos){
	return this._items[pos];
}

SimpleCollection.prototype.getItems = function(){
	return this._items;
}

SimpleCollection.prototype.removeItemAt = function(pos){
	this._items.splice(pos,1);
}

SimpleCollection.prototype.removeItem = function(item){
	for(var i = 0; i < this._items.length; i++){ 
 		if(this._items[i] == item){
 			this.removeItemAt(i); 
 		}
 	} 
}

SimpleCollection.prototype.removeAll = function(){
	this._items.splice(0,this._items.length);
}
