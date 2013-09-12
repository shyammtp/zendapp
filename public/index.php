<?php
/**
 * This makes our life easier when dealing with paths. Everything is relative
 * to the application root now.
 */
ini_set('display_errors',1);
chdir(dirname(__DIR__));

// Decline static file requests back to the PHP built-in webserver
if (php_sapi_name() === 'cli-server' && is_file(__DIR__ . parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH))) {
    return false;
}

// Setup autoloading
require 'init_autoloader.php';

define('SITE_ROOT', getcwd());

$siteCore = SITE_ROOT.'/site.php';

if(!file_exists($siteCore))
{
    die("Error: Application Core file not found");
}

require $siteCore;

Site::run();




