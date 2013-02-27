<?php

// Define the core paths
// Define them as absolute paths to make sure that require_once works as expected

// DIRECTORY_SEPARATOR is a PHP pre-defined constant
// (\ for Windows, / for Unix)
defined('DS') ? null : define('DS', DIRECTORY_SEPARATOR);
defined('SITE_ROOT') ? null : define('SITE_ROOT', DS.'home'.DS.'pedro'.DS.'public_html'.DS.'ty');
defined('LIB_PATH') ? null : define('LIB_PATH', SITE_ROOT.DS.'includes');

// load config file first
require_once(LIB_PATH.DS.'config.php');

// load basic functions next so that everything after can use them
require_once(LIB_PATH.DS.'functions.php');

// load core objects
require_once(LIB_PATH.DS.'class_database_object.php');
require_once(LIB_PATH.DS.'class_user.php');
require_once(LIB_PATH.DS.'class_session.php');
require_once(LIB_PATH.DS.'database.php'); // caused trouble if i appened with "class_"
require_once(LIB_PATH.DS.'class_pagination.php');

// load application-related classes
require_once(LIB_PATH.DS.'class_item.php');
require_once(LIB_PATH.DS.'class_contact.php');
require_once(LIB_PATH.DS.'class_address.php');
require_once(LIB_PATH.DS.'class_photograph.php');
require_once(LIB_PATH.DS.'class_note.php');
require_once(LIB_PATH.DS.'class_employee.php');
require_once(LIB_PATH.DS.'class_log.php');
require_once(LIB_PATH.DS.'class_condition_report.php');
require_once(LIB_PATH.DS.'class_locationHistory.php');

/* Set time default */
date_default_timezone_set('America/Chicago');



/* Mysql database */
$database = new MySQLDatabase();
$db =& $database;

/* Session object */
$session = new Session();
$message = $session->message();
?>