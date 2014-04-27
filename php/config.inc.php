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
Config::write('hostname', 'us-cdbr-azure-east-a.cloudapp.net');
Config::write('database', 'ipstest');
Config::write('username', 'b3018fa0e0d448');
Config::write('password', 'd459720c');
Config::write('drivers', array(PDO::ATTR_PERSISTENT => true));
?>