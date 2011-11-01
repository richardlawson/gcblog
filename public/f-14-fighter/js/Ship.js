/**
 * @class Ship
 * @constructor
 * @return
 * @see MovingGameObject MovingGameObject is the base class
 */
function Ship(movementArea){
	var that = this;
	var observers = new Array();
	this._elementClass = 'ship';
	this._life = 2;
	this._shield = 3;
	this.movementArea = movementArea;
	this._movementAreaOffset = 6;
	this.speed = 6;
	this.grace = false;
	this.rocketFireable = true;
	
	this.setShield = function(shield){
		this._shield = shield;
		this._healthChanged();
	}
	
	this.getShield = function(){
		return this._shield;
	}
	
	this.setLife = function(life){
		this._life = life;
		this._healthChanged();
	}
	
	this.getLife = function(){
		return this._life;
	}
	
	this.hide = function(){
		this._element.hide();
	}
	
	this.move = function(){
		var moveAmount = this._getMoveAmount();
		if(this.movingLeft && InnerBoundaryChecker.isInLeftBounds(this, this.movementArea, this._movementAreaOffset)){
			this.moveLeft(moveAmount);
		}
		if(this.movingRight && InnerBoundaryChecker.isInRightBounds(this, this.movementArea, this._movementAreaOffset)){
			this.moveRight(moveAmount);
		}
		if(this.movingUp && InnerBoundaryChecker.isInUpperBounds(this, this.movementArea, this._movementAreaOffset)){
			this.moveUp(moveAmount);
		}
		if(this.movingDown && InnerBoundaryChecker.isInLowerBounds(this, this.movementArea, this._movementAreaOffset)){
			this.moveDown(moveAmount);
		}
	}
	
	this._getMoveAmount = function(){
		if(this.isMovingInMoreThanOneDirection()){
			return Math.floor(this.speed / 1.5);
		}
		return this.speed;
	}
	
	/** 
	 * fires a rocket from middle of ship. 
	 * It is recommended that ship.rocketFireable is checked before calling this function 
	 * @throws {RocketNoFireable} If ship.rocketFireable is false;
	 */
	this.fireRocket = function(){
		if(!this.rocketFireable){
			throw "RocketNotFireable";
		}
		var rocket = new Rocket(this.speed);
		rocket.activate(this._canvas, this._getWeaponFireXPos(), this._getWeaponFireYPos());
		return rocket;
	}
	
	this._getWeaponFireXPos = function(){
		var weaponXOffSet = 5;
		return this.getRight() + weaponXOffSet;
	}
	
	this._getWeaponFireYPos = function(){
		var weaponYOffSet = 10;
		return this.getVerticalMidPoint() + weaponYOffSet;
	}

	this.doDamage = function(){
		if(!this.grace){
			this.setShield((this._shield - 1));
			if(this._shield <= 0){
				this._reduceLifeAndRespawn();
			}
		}
	}
	
	this._reduceLifeAndRespawn = function(){
		this._reduceLife();
		this._respawn();
	}
	
	this._reduceLife = function(){
		this.setLife((this._life - 1));
		if(this._life <= 0){
			throw "NoLifeException";
		}
	}

	this._respawn = function(){
		this.grace = true;
		this.setShield(3);
		this._fadeShipOutMoveToStartPosAndFadeBackIn();
	}
	
	this._fadeShipOutMoveToStartPosAndFadeBackIn = function(){
		this._element.fadeOut('slow', function(){
			that.moveTo(5,5);
			that._element.fadeIn(2000, function(){
				that.grace = false;
			});
		});
	}

	this.reset = function(){
		this.setShield(3);
		this.setLife(2);
		this._resetMovingDirections();
		this.moveTo(5,5);
		this._element.show();
	}
	
	this._resetMovingDirections = function(){
		this.movingLeft = false;
		this.movingRight = false;
		this.movingUp = false;
		this.movingDown = false;
	}

	this._healthChanged = function(){
		this.notifyObservers();
	}

	this.registerObserver = function(observer){
		observers.push(observer);
	}
	
	this.removeObserver = function(observer){
		Util.removeByElement(observers, observer);
	}

	this.notifyObservers = function(){
		for(var i = 0; i < observers.length; i++){
			observers[i].updateHealth();
		}
	}
}

Ship.prototype = new MovingGameObject();