/** 
 * @class BossEnemy 
 * @constructor
 * @return 
 * @see SmartEnemy SmartEnemy is the base class 
 */
function BossEnemy(movementArea, elementClass, speed){
	this.movementArea = movementArea;
	if(elementClass === undefined){
		elementClass = 'bossEnemy'; 
	}
	this._elementClass = elementClass;
	if(speed === undefined){
		speed = 3;
	}
	this.speed = speed;
	this.health = 15;
	this.value = 40;
	this.attackRate = 0.94;
	this.rocketFireable = true;
	this.moveStrategy = new SimpleUpDownMoveStrategy(this.movementArea);
}

BossEnemy.prototype = new SmartEnemy();