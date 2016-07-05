<?php
/*

	Configuration for Quandam

	This script provides all configurations for quandam

	Author: Patrick Notar

*/


/**
 * Debug options
 **/
error_reporting(E_ALL);
ini_set( 'session.cookie_httponly', 1 );
ini_set('display_error', 'On');


/**
 * Default constants
 **/
define('PROJECT', 'quandam');
define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);
define('BASE', $_SERVER['DOCUMENT_ROOT'] . DS . PROJECT . DS);
define('API', BASE . "api" . DS);
define('APP', BASE . "app" . DS);
define('LOG_OUT', BASE . "api" . DS . "log" . DS . "log.txt");
define('RESOURCES', DS . "quandam" . DS . "resources" . DS);


/**
 * PHP Class Autoloader
 **/
$include_directories = array(
    API . "util",
    API . "entity",
    APP . "services",
    API . "controller",
    APP . "controller",
    API . "controller" . DS . "impl",
    APP . "controller" . DS . "impl"
);
set_include_path(implode(PATH_SEPARATOR, $include_directories));
spl_autoload_extensions('.php');
spl_autoload_register();


/**
 * Database Connection
 **/
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', PROJECT);


/**
 * Template Engine
 **/
require_once BASE . 'vendor/twig/twig/lib/Twig/Autoloader.php';
Twig_Autoloader::register();
