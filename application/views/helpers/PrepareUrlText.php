<?php
class Application_View_Helper_PrepareUrlText extends Zend_View_Helper_Abstract{
	
	public function prepareUrlText($string){
		//remove all characters that aren't a-z, 0-9, dash, undescore or space
		$notAcceptableRegex = "#[^-a-zA-Z0-9_ ]#";
		$string = preg_replace($notAcceptableRegex, '', $string);
		$string = trim($string);
		// change all dashes, underscores and spaces to dashes
		$string = preg_replace('#[-_ ]+#', '-', $string);
		return strtolower($string); 
	}
	
}