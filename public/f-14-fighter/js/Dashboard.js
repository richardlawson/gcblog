/** 
 * @class Dashboard
 * @constructor
 * @return 
 * @see GameObject GameObject is the base class  
 */

function Dashboard(ship, scoreManager){
	this.ship = ship;
	this.ship.registerObserver(this);
	this.scoreManager = scoreManager;
	this.scoreManager.registerObserver(this);
}

Dashboard.prototype = new GameObject();
Dashboard.superclass = GameObject.prototype;


Dashboard.prototype.activate = function(canvas, x, y){
	Dashboard.superclass.activate.call(this, canvas, x, y);
	this.initDashboardInfo();
}


Dashboard.prototype._createElement = function(){
	this._element = $('<div id="dashboard"><div id="health"></div><div id="score"></div></div>');
}

Dashboard.prototype.initDashboardInfo = function(){
	this.updateScore();
	this.updateHealth();
}

Dashboard.prototype.updateScore = function(){
	$('#score').text("Score: " + this.scoreManager.getTotal());
}

Dashboard.prototype.updateHealth = function(){
	$('#health').text("Life: " + this.ship.getLife() + "  Shield: " + this.ship.getShield());
}
