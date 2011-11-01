/** 
 * @class SmartEnemy 
 * @constructor
 * @return 
 * @see Enemy Enemy is the base class 
 */
function SmartEnemy(ship, movementArea, elementClass, speed){
	this.ship = ship;
	this.movementArea = movementArea;
	if(elementClass === undefined){
		elementClass = 'smartEnemy'; 
	}
	this._elementClass = elementClass;
	if(speed === undefined){
		speed = 3;
	}
	this.speed = speed;
	this.value = 10;
	this.attackRate = 0.97;
	this.rocketFireable = true;
	this.moveStrategy = new SmartMoveStrategy(this.ship, this.movementArea);
}

SmartEnemy.prototype = new Enemy();

SmartEnemy.prototype.doAttack = function(){
	if(Math.random() > this.attackRate){
		var enemyRocket = new EnemyRocket(this.speed);
		enemyRocket.activate(this._canvas, this._getWeaponFireXPos(), this._getWeaponFireYPos());
		return enemyRocket;
	}
	return false;
}

