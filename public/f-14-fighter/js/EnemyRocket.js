/**
 * @class EnemyRocket
 * @constructor
 * @return
 * @see MovingGameObject MovingGameObject is the base class
 */
function EnemyRocket(enemySpeed){
	this._elementClass = 'enemyRocket';
	this.speed = enemySpeed + 5;
	this.moveStrategy = new SimpleMoveLeftStrategy();
}

EnemyRocket.prototype = new MovingGameObject();

EnemyRocket.prototype.move = function(){
	this.moveStrategy.move(this);
}
