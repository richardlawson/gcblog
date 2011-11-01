/** 
 * @class GameController 
 * @constructor
 * @return 
 */
function GameController(){
	var that = this;
	var canvas;
	var backgrounds = new MovingGameObjectCollection();
	var flightArea = new Rectangle(0, 0, 990, 375);;
	var ship;
	var rockets = new MovingGameObjectCollection();
	var enemyFactory;
	var enemies = new EnemyCollection();
	var enemyRockets = new MovingGameObjectCollection();
	var scoreManager = new ScoreManager();
	var dashboard;
	var communicationPopUp;
	var screenBuilder;
	var gameOver = false;

	this.init = function(){
		preLoadGame();
		canvas = new Canvas($('#canvas'));
		ship = new Ship(flightArea);
		ship.activate(canvas, 6, 6);
		dashboard = new Dashboard(ship, scoreManager);
		dashboard.activate(canvas, 10, 10);
		communicationPopUp = new CommunicationPopUp($('#mission-panel'));
		screenBuilder = new ScreenBuilder($('#info-screen'));
		enemyFactory = new EnemyFactory(canvas, ship, flightArea);
		initBackground();
	}

	var preLoadGame = function(){
		var preLoader = new ImagePreLoader($('#preloader'), $('#progress-bar'));
		preLoader.addImage('/f-14-fighter/images/background/desert.jpg');
		preLoader.addImage('/f-14-fighter/images/background/clouds.png');
		preLoader.addImage('/f-14-fighter/images/background/clouds-small.png');
		preLoader.addImage('/f-14-fighter/images/background/clouds-medium.png');
		preLoader.addImage('/f-14-fighter/images/screen/intro.png');
		preLoader.addImage('/f-14-fighter/images/sprites/bomber.png');
		preLoader.addImage('/f-14-fighter/images/sprites/boss.png');
		preLoader.addImage('/f-14-fighter/images/sprites/enemy.png');
		preLoader.addImage('/f-14-fighter/images/sprites/f-14-small.png');
		preLoader.addImage('/f-14-fighter/images/sprites/fighter.png');
		preLoader.addImage('/f-14-fighter/images/animation/explosion.png');
		preLoader.addImage('/f-14-fighter/images/animation/explosion-large.png');
		preLoader.launch();
	}
	
	var initBackground = function(){
		largeClouds = new RepeatingBackground('background1', 4);
		largeClouds.activate(canvas);
		backgrounds.addItem(largeClouds);
		mediumClouds = new RepeatingBackground('background2', 5);
		mediumClouds.activate(canvas);
		backgrounds.addItem(mediumClouds);
		smallClouds = new RepeatingBackground('background3', 3);
		smallClouds.activate(canvas);
		backgrounds.addItem(smallClouds);
	}

	this.startGame = function(){
		activateControlKeys();
		startGameLoop();
		gameOver = false;
		displayMissionObjectives();
	}

	var activateControlKeys = function(){
		
		$(document).keydown(function(event){
			if(!gameOver){
				switch(event.which){
					case 37: // CURSOR KEYS
						event.preventDefault();
						ship.movingLeft = true;
						break;
					case 38:	
						event.preventDefault();
						ship.movingUp = true;
						break;
					case 39:
						event.preventDefault();
						ship.movingRight = true;
						break; 
					case 40:
						event.preventDefault();
						ship.movingDown = true;
						break;
					case 32: // SPACEBAR KEY
						event.preventDefault();
						if(ship.rocketFireable){
							var rocket = ship.fireRocket();
							rockets.addItem(rocket);
						}
						ship.rocketFireable = false;
						break;
				}
			}
		});

		$(document).keyup(function(event){
			if(!gameOver){
				switch(event.which){
					case 37: // CURSOR KEYS
						event.preventDefault();
						ship.movingLeft = false;
						break;
					case 38:
						event.preventDefault();
						ship.movingUp = false;
						break;
					case 39:
						event.preventDefault();
						ship.movingRight = false;
						break; 
					case 40:
						event.preventDefault();
						ship.movingDown = false;
						break;
					case 32: // SPACEBAR KEY
						event.preventDefault();
						ship.rocketFireable = true;
						break;
				}
			}
		});
	}

	var startGameLoop = function(){
		setInterval(
			function(){
				doGameLoop();
			}, 
			15
		);
	}

	var doGameLoop = function(){
		try{
			doBackgroundAnimation();
			doMovement();
			doBoundaryCleanUp();
			if(!gameOver){
				doCollisions();
			}
			doEnemyAttack();
		}catch(e){
			if(e == "NoLifeException"){
				endGame();
			}
		}
	}

	var doBackgroundAnimation = function(){
       	canvas.scrollBackground();
        backgrounds.move();
	}

	var doMovement = function(){
		ship.move();
		rockets.move();
		enemies.move();
		enemyRockets.move();
	}

	var doBoundaryCleanUp = function(){
		BoundaryCleaner.doLeftBoundaryCleanUp(enemies, flightArea);
		BoundaryCleaner.doLeftBoundaryCleanUp(enemyRockets, flightArea);
		BoundaryCleaner.doRightBoundaryCleanUp(rockets, flightArea);
	}
	
	var doCollisions = function(){
		doShipCollisions();
		doRocketCollisions();
	}

	var doShipCollisions = function(){
		for(var i = 0; i < enemies.length(); i++){
			if(CollisionDetector.isCollision(ship, enemies.getItemAt(i))){
				doShipOnEnemyCollision(ship, enemies.getItemAt(i));
				break;	
			}
		}
		
		for(var i = 0; i < enemyRockets.length(); i++){
			if(CollisionDetector.isCollision(ship, enemyRockets.getItemAt(i))){
				doShipOnEnemyRocketCollision(ship, enemyRockets.getItemAt(i));
				break;
			}
		}
	}

	var doShipOnEnemyCollision = function(ship, enemy){
		// if enemy is not boss, destroy enemy on collison with ship
		if(!(enemy instanceof BossEnemy)){
			destroyEnemy(enemy);
		}
		doShipHit();
	}

	var destroyEnemy = function(enemy){
		scoreManager.updateScore(enemy.value);
		doExplosionAnimation(enemy);
		enemies.destroyAndRemoveItem(enemy);
		if(enemy instanceof BossEnemy){
			endLevel();
		}
	}

	var doShipHit = function(){
		doShipHitAnimation();
		ship.doDamage();
	}

	var doShipOnEnemyRocketCollision = function(ship, enemyRocket){
		doShipHit();
		enemyRockets.destroyAndRemoveItem(enemyRocket);
	}

	var doRocketCollisions = function(){
		for(var i = 0; i < rockets.length(); i++){
			for(var j = 0; j < enemies.length(); j++){
				if(CollisionDetector.isCollision(rockets.getItemAt(i), enemies.getItemAt(j))){
					doRocketOnEnemyCollision(rockets.getItemAt(i), enemies.getItemAt(j));
					break;
				}
			}
		}
	}

	var doRocketOnEnemyCollision = function(rocket, enemy){
		try{
			rockets.destroyAndRemoveItem(rocket);
			enemy.doDamage();
			doEnemyHitAnimation(enemy);
		}catch(e){
			if(e == 'NoLifeException'){
				destroyEnemy(enemy);
			}
		}
	}

	var doEnemyAttack = function(){
		enemyRockets.addItems(enemies.doAttack());
	}

	var displayMissionObjectives = function(){
		var text = 'Mission Objectives: 1. Shoot down enemy fighters. 2. Take out the end of level boss. Good Luck....';
		communicationPopUp.doMessage(text, function(){
			startEnemyCreation();
		});
	}
	
	var startEnemyCreation = function(){
		setInterval(
			function(){
				createEnemies();
			}, 
			2000
		);
	}

	var createEnemies = function(){
		if(!gameOver && !enemyFactory.bossActive){
			var enemy = enemyFactory.getInstance();
			enemies.addItem(enemy);
		}
	}

	var endGame = function(){
		gameOver = true;
		doExplosionAnimation(ship);
		ship.hide()
		screenBuilder.buildGameEndedScreen(scoreManager.getTotal(), function(){
			that.resetGame();								
		}).show();
	}
	
	var endLevel = function(){
		gameOver = true;
		ship.hide()
		screenBuilder.buildLevelEndedScreen(scoreManager.getTotal(), function(){
			that.resetGame();								
		}).show();
	}

	this.resetGame = function(){
		resetMovingGameObjects();
		scoreManager.reset();
		enemyFactory.reset();
		$("#info-screen").hide();
		gameOver = false;
	}
	
	function resetMovingGameObjects(){
		ship.reset();
		rockets.destroyAndRemoveAll();
		enemies.destroyAndRemoveAll();
		enemyRockets.destroyAndRemoveAll();
	}

	var doExplosionAnimation = function(hitObj){
		var element = $('<div class="explosion"></div>');
		element.css("left", hitObj.getX() + "px");
		element.css("top", hitObj.getY() + "px");
		canvas.element.append(element);
		element.fadeOut(500, function(){
								element.remove();
		});
	}

	var doShipHitAnimation = function(){
		var element = $('<div class="ship-hit"></div>');
		ship.getElement().append(element);
		element.fadeOut(500, function(){
								element.remove();
		});
	}

	var doEnemyHitAnimation = function(enemy){
		var element = $('<div class="enemy-hit"></div>');
		enemy.getElement().append(element);
		element.fadeOut(500, function(){
								element.remove();
		});
	}

}	