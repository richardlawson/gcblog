<?php
namespace GC\Util;
class DateHelperTest extends \SimpleTestCase{
	
	public function testisddmmyyyyformattedWithddmmyyyyString(){
		$this->assertTrue(DateHelper::isddmmyyyyFormatted('15/12/2011'));
	}
	
	public function testisddmmyyyyformattedWithNonddmmyyyyString(){
		$this->assertFalse(DateHelper::isddmmyyyyFormatted('30 oct 2011'));
	}
	
	public function testConvertddmmyyyyStringToMysqlDateString(){
		$this->assertEquals('2011-10-30', DateHelper::convertddmmyyyyStringToMysqlDateString('30/10/2011'));
	}
	
	/**
     * @expectedException GC\Util\InvalidDateFormatException
     */
	public function testConvertddmmyyyyyStringToMysqlDateStringUsingInvalidDateFormat(){
		$mysqlDate = DateHelper::convertddmmyyyyStringToMysqlDateString('30 Oct 2011');
	}
	
	/**
     * @expectedException GC\Util\InvalidDateException
     */
	public function testConvertddmmyyyyStringToMysqlDateStringWithInvalidDate(){
		$mysqldate = DateHelper::convertddmmyyyyStringToMysqlDateString('30/02/2011');
	}
	
	
}