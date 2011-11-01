<?php
namespace GC\Util;
class DateHelper{
	public static function convertddmmyyyyStringToMysqlDateString($dateString){
		$dateString = (string) $dateString;
		if(!self::isddmmyyyyFormatted($dateString)){
			throw new InvalidDateFormatException('Date string should be in dd/MM/YYYY format');
		} 
		$day = self::getDayFromddmmyyyyString($dateString);
		$month = self::getMonthFromddmmyyyyString($dateString);
		$year = self::getYearFromddmmyyyyString($dateString);
		if(!checkdate($month, $day, $year)){
			throw new InvalidDateException("Date $dateString is an invalid date");
		}
		return "$year-$month-$day";	
	}
	
	public static function isddmmyyyyFormatted($dateString){
		$dateString = (string) $dateString;
		return (preg_match('`^\d{2}/\d{2}/\d{4}$`', $dateString) == 1);
	}
	
	protected static function getDayFromddmmyyyyString($dateString){
		return substr($dateString, 0, 2);
	}
	
	protected static function getMonthFromddmmyyyyString($dateString){
		return substr($dateString, 3, 2);
	}
	
	protected static function getYearFromddmmyyyyString($dateString){
		return substr($dateString, 6, 4);
	}

}