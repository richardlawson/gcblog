/** 
 * @class EnemyFactory
 * @constructor
 * @return 
*/
function EnemyFactory(canvas, ship, movementArea){
	this.canvas = canvas;
	this.ship = ship;
	this.movementArea = movementArea;
	this.noSmartEnemies = 0;
	this.noSimpleEnemies = 0;
	this.totalNoEnemies = 0;
	this.bossActive = false;
	
	this.getInstance = function(){
		var enemy;
		if(this.timeForBoss()){
			enemy = this._createBossEnemy();
			this.bossActive = true;
		}else{
			enemy = this._getRandomEnemy();
		}
		this.totalNoEnemies++;
		return enemy;
	}
	
	this.timeForBoss = function(){
		return (this.totalNoEnemies > 25);
	}
	
	this._createBossEnemy = function(){
		var enemy = new BossEnemy(this.movementArea);
		enemy.activate(this.canvas, this.movementArea.width, Math.round(this.movementArea.height / 2));
		return enemy;
	}
	
	this._getRandomEnemy = function(){
		var enemy;
		var randomNo = Math.random();
		if(randomNo > 0.7){
			enemy = this._createSmartEnemy();
			this.noSmartEnemies++;
		}else if(randomNo > 0.5){
			enemy = this._createSimpleNoseDiveEnemy();
			this.noSimpleEnemies++;
		}else{
			enemy = this._createSimpleEnemy();
			this.noSimpleEnemies++;
		}
		return enemy;
	}
	
	this._createSmartEnemy = function(){
		var enemy = new SmartEnemy(this.ship, this.movementArea);
		enemy.activate(this.canvas, this.movementArea.width, 0);
		enemy.setY(this.getRandomStartYPos(enemy));
		return enemy;
	}
	
	this._createSimpleEnemy = function(){
		var enemy = new Enemy();
		enemy.activate(this.canvas, this.movementArea.width, 0);
		enemy.setY(this.getRandomStartYPos(enemy));
		enemy.speed = this.getRandomSpeed(6, 12);
		return enemy;
	}
	
	this._createSimpleNoseDiveEnemy = function(){
		var enemy = new Enemy();
		enemy.activate(this.canvas, this.movementArea.width, 10);
		enemy.speed = this.getRandomSpeed(6, 9);
		enemy.moveStrategy = new NoseDiveMoveStrategy(this.movementArea);
		return enemy;
	}
	
	
	this.getRandomStartYPos = function(enemy){
		return (Math.random() * (this.movementArea.height - enemy.getHeight()));
	}
	
	this.getRandomSpeed = function(minSpeed, maxSpeed){
		return Math.floor(Math.random() * (maxSpeed - minSpeed + 1) + minSpeed);
	}
	
	this.reset = function(){
		this.noSmartEnemies = 0;
		this.noSimpleEnemies = 0;
		this.totalNoEnemies = 0;
		this.bossActive = false;
	}
}