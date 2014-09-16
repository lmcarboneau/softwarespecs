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
Config::write('hostname', 'us-cdbr-azure-central-a.cloudapp.net');
Config::write('database', 'ipstest');
Config::write('username', 'b16d99ad59ac38');
Config::write('password', '4b984b87');
Config::write('drivers', array(PDO::ATTR_PERSISTENT => false));
?>
