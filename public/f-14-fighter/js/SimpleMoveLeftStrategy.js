/** 
 * @class SimpleMoveLeftStrategy
 * moves sprite horizontally from right to left
 * @constructor
 * @return  
 * @see MoveStrategy MoveStratgey is the base class 
 */
function SimpleMoveLeftStrategy(){}

SimpleMoveLeftStrategy.prototype = new MoveStrategy();

SimpleMoveLeftStrategy.prototype.move = function(movingGameObject){
	movingGameObject.moveLeft(movingGameObject.speed);
}



