/** 
 * @class EnemyCollection 
 * @constructor
 * @return 
 * @see MovingGameObjectCollection MovingGameObjectCollection is the base class 
 * note: it is recommended that destroyAndRemove methods are used in preference of simple removes. 
 *       This ensures that the game object destroy method is called before removing it from the collection.
 */
function EnemyCollection(){
	this._items = new Array();
}

EnemyCollection.prototype = new MovingGameObjectCollection();

/** 
 * returns an array of rockets fired by enemies
 */
EnemyCollection.prototype.doAttack = function(){
	var enemyRockets = new Array();
	for(var i = 0; i < this._items.length; i++){ 
		var enemyRocket = this._items[i].doAttack();
		if(enemyRocket){
			enemyRockets.push(enemyRocket);
		}
 	} 
	return enemyRockets;
}