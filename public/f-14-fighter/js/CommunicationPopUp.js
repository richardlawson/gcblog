/** 
 * @class CommunicationPopUp 
 * @constructor
 * @return 
 */
function CommunicationPopUp(element){
	this.element = element
	this.doMessage = function(text, callbackFunc){
		// Make local copy of element to pass to callbacks. Using this.element in callbacks won't work beacuse of the keyword this 
		var ele = this.element;
		this.element.animate({
		  	"left": "+=272px" 
			}, 2000, function(){
				ele.text(text);
				ele.typewriter(function(){
					ele.animate({"left": "-=272px"}, 2000, callbackFunc);
				});
		});
	}
}
