/** 
 * @class ImagePreLoader 
 * @constructor
 * @return 
 */
function ImagePreLoader(progressBarContainerElement, progressBarElement){
	var that = this;
	this.images = new Array();
	this.noLoadedImages = 0;
	this.progressBar = progressBarElement;
	this.progressBarContainer = progressBarContainerElement;
	this._moveAmountPerImage = null;

	this.addImage = function(image){
		this.images.push(image);
	}
	
	this.launch = function(){
		this.preLoadImages();
	}
	
	this.preLoadImages = function(){
		for(var i=0; i< this.images.length; i++){
			var image = $('<img src="' + this.images[i] + '"/>');
			image.load(function(){
				that.doImageLoadAction();
			});
		}
	}

	this.doImageLoadAction = function(){
		this.noLoadedImages++;
		if(this.areAllImagesLoaded()){
			this.removePreLoaderFromPage();
		}else{
			this.moveProgressBar();
		}
		
	}

	this.areAllImagesLoaded = function(){
		return (this.noLoadedImages >= this.images.length);
	}

	this.removePreLoaderFromPage = function(){
		this.progressBarContainer.remove();
	}

	this.moveProgressBar = function(){
		this.progressBar.css('left', this.progressBar.position().left + this.getMoveAmountPerImage());
	}

	this.getMoveAmountPerImage = function(){
		if(this._moveAmountPerImage === null){
			this._moveAmountPerImage = this.progressBar.width() / this.images.length;
		}
		return this._moveAmountPerImage;
	}

}