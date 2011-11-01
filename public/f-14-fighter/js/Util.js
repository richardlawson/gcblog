/** 
 * @class Util 
 * @constructor
 * @return 
 */
function Util(){
}

Util.removeByElement = function(array, element){
	for(var i=0; i < array.length; i++){ 
 		if(array[i] == element){
 			array.splice(i,1); 
 		}
 	} 
}