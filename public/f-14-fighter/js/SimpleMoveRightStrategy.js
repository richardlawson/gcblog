/** 
 * @class SimpleMoveRightStrategy
 * moves gameObject horizontally from right to left
 * @constructor
 * @return  
 * @see MoveStrategy MoveStratgey is the base class 
 */
function SimpleMoveRightStrategy(){}

SimpleMoveRightStrategy.prototype = new MoveStrategy();

SimpleMoveRightStrategy.prototype.move = function(movingGameObject){
	movingGameObject.moveRight(movingGameObject.speed);
}


