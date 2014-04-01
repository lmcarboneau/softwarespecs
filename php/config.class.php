<?php
 /**
 * Reads the Config file
 *
 * This file reads the config.inc.class file cread during setup
 *
 * PHP version 5.2.17 or higher
 *
 * LICENSE: TBD
 *
 * @package    BlackHawk
 * @subpackage Internal Functions
 * @author     Chris Christoff <chris@futuregencode.com>
 * @copyright  2012 Project BlackHawk
 * @license    http://www.futuregencode.com/blackhawk/404  License 1.00
 * @version    0.3.0
 * @since      File available since Release 0.3.0
 */
 
 /**
 * Implements method to grab stored config values
 *
 * @package    BlackHawk
 * @subpackage Internal Functions
 * @author     Chris Christoff <chris@futuregencode.com>
 * @copyright  2012 Project BlackHawk
 * @license    http://www.futuregencode.com/blackhawk/404  License 1.0
 * @version    0.3.0
 * @since      File available since Release 0.3.0
 */ 
class Config {
	/**
	 * @var $configArray
	 *
	 * Used to store all the configs
	 */
	static $confArray;
	/**
	 * Config Read function
	 * 
	 * Reads the config value from the $confArray
	 * 
	 * @param string $name the key in the array
	 */
	public static function read($name) {
		return self::$confArray[$name];
	}
	/**
	 * Config Write function
	 * 
	 * Writes data to the $confArray
	 * 
	 * @param string $name the key in the array
	 * @param string $value the value of the key in the array
	 */
	public static function write($name, $value) {
		self::$confArray[$name] = $value;
	}
}
?>
