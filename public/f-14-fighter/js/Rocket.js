/**
 * @class Rocket
 * @constructor
 * @return
 * @see MovingGameObject MovingGameObject is the base class
 */
function Rocket(shipSpeed){
	this._elementClass = 'rocket';
	this.speed = shipSpeed + 5;
	this.moveStrategy = new SimpleMoveRightStrategy();
}

Rocket.prototype = new MovingGameObject();

Rocket.prototype.move = function(){
	this.moveStrategy.move(this);
}


