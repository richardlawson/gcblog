function ScoreManager(){
	this._total = 0;
	this._observers = new Array();

	this.registerObserver = function(observer){
		this._observers.push(observer);
	}
	
	this.removeObserver = function(observer){
		Util.removeByElement(this._observers, observer);
	}

	this.notifyObservers = function(){
		for(var i = 0; i < this._observers.length; i++){
			this._observers[i].updateScore();
		}
	}

	this.getTotal = function(){
		return this._total;
	}

	this.setTotal = function(total){
		this._total = total;
		this._scoreChanged();
	}

	this.updateScore = function(score){
		this._total += score;
		this._scoreChanged();
	}

	this._scoreChanged = function(){
		this.notifyObservers();
	}

	this.reset = function(){
		this.setTotal(0);
	}
}