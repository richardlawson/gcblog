/** 
 * @class Enemy 
 * @constructor
 * @return 
 * @see MovingGameObject MovingGameObject is the base class 
 */
function Enemy(elementClass, speed){
	if(elementClass === undefined){
		elementClass = 'enemy'; 
	}
	this._elementClass = elementClass;
	if(speed === undefined){
		speed = 4;
	}
	this.speed = speed;
	this.health = 2;
	this.value = 5;
	this.rocketFireable = false;
	this.moveStrategy = new SimpleMoveLeftStrategy();
}

Enemy.prototype = new MovingGameObject();

Enemy.prototype.move = function(){
	this.moveStrategy.move(this);
}

Enemy.prototype.doAttack = function(){
	return false;
}

Enemy.prototype._getWeaponFireXPos = function(){
	var weaponXOffSet = 5;
	return this.getLeft() - weaponXOffSet;
}

Enemy.prototype._getWeaponFireYPos = function(){
	return this.getVerticalMidPoint();
}

Enemy.prototype.doDamage = function(){
	this.health--;
	if(this.health == 0){
		throw 'NoLifeException';
	}
}