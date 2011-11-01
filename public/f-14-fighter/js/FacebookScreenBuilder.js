/**
 * @class ScreenBuilder
 * @constructor
 * @return
 */
function ScreenBuilder(screenElement, gameController){
	this.screen = screenElement;
	this.gameController = gameController;
	var that = this;
	
	this.buildGameEndedScreen = function(score, callbackFunc){
		this.screen.html('');
		this.screen.append($('<div>GAME OVER</div>'));
		this.screen.append(getScorePanel(score));
		this.screen.append(getScoreForm(score));
		$('#char1, #char2, #char3').autotab_magic().autotab_filter({
				format: 'alpha',
		        uppercase: true
		});
		return this.screen;
	}

	this.buildLevelEndedScreen = function(score, callbackFunc){
		this.screen.html('');
		this.screen.append($('<div>LEVEL COMPLETE<br/><span class="small-text">Level 2 coming soon...</span></div>'));
		this.screen.append(getScorePanel(score));
		this.screen.append(getScoreForm(score));
		//$('.charfield').alpha({allow:" "});
		$('#char1, #char2, #char3').autotab_magic().autotab_filter({
			format: 'alpha',
	        uppercase: true
		});
		return this.screen;
	}
	
	this.buildHighScoreScreen = function(highScores){
		this.screen.html('');
		this.screen.append(getReplayButton(this.screen, function(){that.gameController.resetGame();}));
		var highScoreTable = getHighScoreTable(highScores);
		this.screen.append(highScoreTable);
	}
	
	var getHighScoreTable = function(highScores){
		var table = '<table class="high-score-table" cellpadding="2">';
		table += '<tr><th colspan="2">High Scores</th></tr>'
		for(var i=0; i < highScores.length; i++){
			highScores[i].handle
			if(highScores[i].handle == ""){
				highScores[i].handle = "___";
			}
			var tableRow = '<tr><td width="82%">' + highScores[i].handle + '</td><td width="18%">' + highScores[i].points + ' points</td></tr>';
			table += tableRow;
		}
		table += '</table>';
		return table;
	}
	
	this.updateGamerHighScorePanel = function(highScore){
		$('#high-score-panel').html(highScore);
	}

	var getScorePanel = function(score){
		var scorePanel = $('<div id="score-panel"></div>');
		scorePanel.text('You Scored: ' + score + ' points');
		return scorePanel;	
	}
	
	var getScoreForm = function(score){
		var scoreForm = $('<div><form id="scoreform"><label>Name:</label>&nbsp;<input name="char1" maxlength="1" class="charfield" id="char1">&nbsp;<input name="char2" maxlength="1" class="charfield" id="char2">&nbsp;<input name="char3" maxlength="1" class="charfield" id="char3">&nbsp;<br/><input type="submit" value="Save Score" class="submit"></form></div>');
		scoreForm.submit(function(event){
	    	// stop form from submitting normally 
	    	event.preventDefault();
	    	//var url = 'http://gamesandcode.localhost/facebook/save/';
	    	var url = 'http://www.gamesandcode.co.uk/facebook/save/';
	    	// get form data 
	    	var $form = $(this);
	    	$('input[type=submit]').attr('disabled', 'disabled');
	    	var handle = $form.find('input[name="char1"]').val() + $form.find('input[name="char2"]').val() + $form.find('input[name="char3"]').val();
	    	// show saving progess 
	    	$('#saving-panel').show();
	    	$('#saving-dialogue').show();
		    /* Send the data using post and put the results in a div */
		    $.post(
		    	url, 
		    	{handle: handle, points: score},
		    	function(data){
		    		$('#saving-panel').hide();
		    		$('#saving-dialogue').hide();
		    		that.updateGamerHighScorePanel(data.gamerHighScore);
		    		that.buildHighScoreScreen(data.highScores);
		    	}
		    	, 'json'
		    );
		});
		return scoreForm;	
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