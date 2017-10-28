<?php
define('LARAVEL_START', microtime(true));

/**
 * Setup auto loading
 */
ini_set('error_reporting', E_ALL); // or error_reporting(E_ALL);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
require __DIR__ . '/../vendor/autoload.php';
