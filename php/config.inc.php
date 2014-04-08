<?php
/*
 * Config Include
 * 
 * Used to write config information into a static var to be
 * used anywhere
 */

/*
 * Get the Config class
 */
require_once('config.class.php');

/*
 * Write settings to the config
 */
Config::write('hostname', 'localhost');
Config::write('database', 'pms');
Config::write('username', 'root');
Config::write('password', 'root');
Config::write('drivers', array(PDO::ATTR_PERSISTENT => true));
?>