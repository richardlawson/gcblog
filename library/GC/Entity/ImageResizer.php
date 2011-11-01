<?php
namespace GC\Entity;
class ImageResizer extends EntityBase{
	
	protected $path;
	protected $file;
	protected $thumbPath;
	protected $width = 0;
	protected $height = 0;
	protected $newWidth= 0;
	protected $newHeight = 0;
	
	public function __construct(array $options = null){
		parent::__construct($options);
		$this->thumbPath = $this->path . 'thumbnails/';
		list($this->width, $this->height) = getimagesize($this->path . $this->file);
	}
	
	public function setFile($file){
		$this->file = (string) $file;
	}
	
	public function getFile(){
		return $this->file;
	}
	
	public function setPath($path){
		$this->path = (string) $path;
	}
	
	public function getPath(){
		return $this->path;
	}
	
	public function setThumbPath($thumbPath){
		$this->thumbPath = (string) $thumbPath;
	}
	
	public function getThumbPath(){
		return $this->thumbPath;
	}
	
	public function setHeight($height){
		$this->height = (int) $height;
	}
	
	public function getHeight(){
		return $this->height;
	}
	
	public function setWidth($width){
		$this->width = (int) $width;
	}
	
	public function getWidth(){
		return $this->width;
	}
	
	public function getWidthToHeightRatio(){
		return ($this->width / $this->height);
	}
	
	public function resizeImageToFitWithinMaxDimensions($maxWidth, $maxHeight){
		if($this->width > $maxWidth || $this->height > $maxHeight){
			if($this->width > $this->height){
				$this->resizeImage($maxWidth, $this->getScaledHeight($maxWidth), $this->path . $this->file);
			}else{
				$this->resizeImage($this->getScaledWidth($maxHeight), $maxHeight, $this->path . $this->file);
			} 
		}
    }
    
	public function resizeImage($newWidth, $newHeight, $savePath, $newPath = null){
		if(is_null($newPath)){
			$newPath = $savePath;
		}
		$originalImage = $this->createOriginalImageFromFile($savePath);
    	$newImage = $this->createNewImage($newWidth, $newHeight);
    	// copy original image into new image holder (of required dimensions)
    	imagecopyresampled($newImage, $originalImage, 0, 0, 0, 0, $newWidth, $newHeight, $this->width, $this->height);
    	// move resized image to image directory. it's currently located in the php temp folder 
    	imagejpeg($newImage, $newPath, 100);
    	$this->width = $newWidth;
    	$this->height = $newHeight;
    	$this->doCleanUp(array($newImage, $originalImage));
    }
    
 	public function getScaledHeight($resizeWidth){
		$resizeHeight = (int)round($resizeWidth * (1 / $this->widthToHeightRatio));
		return $resizeHeight;	
    }
    
	public function getScaledWidth($resizeHeight){
		$resizeWidth = (int)round($resizeHeight * $this->widthToHeightRatio);
		return $resizeWidth;	
    }
    
 	private function createOriginalImageFromFile($file){
    	return imagecreatefromjpeg($file);
    }
    
	private function createNewImage($newWidth, $newHeight){
    	return imagecreatetruecolor($newWidth, $newHeight);
    }
    
	public function createThumbnail($pxlSize){
    	$this->createPreCropThumbnail($pxlSize);
    	$this->cropThumbnail($pxlSize);
    }
    
    private function createPreCropThumbnail($pxlSize){
    	if($this->width > $this->height){
			$thumbHeight = $pxlSize;
    		$thumbWidth = $this->getScaledWidth($pxlSize);
		}elseif($this->height > $this->width){
			$thumbHeight = $this->getScaledHeight($pxlSize);
    		$thumbWidth = $pxlSize;
		}else{
			$thumbHeight = $pxlSize;
    		$thumbWidth = $pxlSize;
		}
    	if(!file_exists($this->thumbPath)){
    		mkdir($this->thumbPath);
    	}
		$this->resizeImage($thumbWidth, $thumbHeight, $this->path . $this->file, $this->thumbPath . $this->file); 	
    }
    
	private function cropThumbnail($pxlSize){
	   	$originalImage = $this->createOriginalImageFromFile($this->thumbPath . $this->file);
    	$newImage = $this->createNewImage($pxlSize, $pxlSize);
    	imagecopy($newImage, $originalImage, 0, 0, 0, 0, $pxlSize, $pxlSize);
    	imagejpeg($newImage, $this->thumbPath . $this->file, 100);
    	$this->doCleanUp(array($newImage,$originalImage));	
	 }
    
    private function doCleanUp(array $tmpImages){
    	foreach($tmpImages as $image){ 
    		imagedestroy($image);
    	}
    }
    
	public function getNewWidth(){
		return $this->_newWidth;
	}
	
	public function setNewWidth($newWidth){
		$this->newWidth= (int) $newWidth;
	}
	
	public function getNewHeight(){
		return $this->newHeight;
	}
	
	public function setNewHeight($newHeight){
		$this->newHeight = (int) $newHeight;
	}
	
}

