/**
 * @class ScreenBuilder
 * @constructor
 * @return
 */
function ScreenBuilder(screenElement){
	this.screen = screenElement;
	
	this.buildGameEndedScreen = function(score, callbackFunc){
		this.screen.html('');
		this.screen.append($('<div>GAME OVER</div>'));
		this.screen.append(getScorePanel(score));
		this.screen.append(getReplayButton(this.screen, callbackFunc));
		return this.screen;
	}

	this.buildLevelEndedScreen = function(score, callbackFunc){
		this.screen.html('');
		this.screen.append($('<div>LEVEL COMPLETE<br/><span class="small-text">Level 2 coming soon...</span></div>'));
		this.screen.append(getScorePanel(score));
		this.screen.append(getReplayButton(this.screen, callbackFunc));
		return this.screen;
	}

	var getScorePanel = function(score){
		var scorePanel = $('<div id="score-panel"></div>');
		scorePanel.text('You Scored: ' + score + ' points');
		return scorePanel;	
	}

	var getReplayButton = function(screen, callbackFunc){
		var replayButton = $('<a href="" id="replay-button">Replay Game</a>');
		replayButton.click(function(event){
			event.preventDefault();
			callbackFunc();
			screen.hide();
		});
		return replayButton;	
	}
}