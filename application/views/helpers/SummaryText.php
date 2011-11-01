<?php
class Application_View_Helper_SummaryText extends Zend_View_Helper_Abstract{
	
	public function summaryText($string = '', $maxLength){
		$string = (string) $string;
		$maxLength = (int) $maxLength;
		if(strlen($string) > $maxLength){
			$string = substr($string, 0, $maxLength);
			$string = trim($string) . '...'; 
		}
		return $string;
	}
	
}