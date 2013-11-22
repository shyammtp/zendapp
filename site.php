<?php  
define('DS', DIRECTORY_SEPARATOR);
define('PS', PATH_SEPARATOR);

if(file_exists(SITE_ROOT.DS.'module'.DS.'Core'.DS.'src'.DS.'Core'.DS.'Model'.DS.'Functions.php'))
    include_once SITE_ROOT.DS.'module'.DS.'Core'.DS.'src'.DS.'Core'.DS.'Model'.DS.'Functions.php';
else
    die('Functions.php file not found in core module structure');

final class Ething
{
    public static $_config;
    
    public static function run()
    { 
        self::$_config = new \Core\Model\Functions();
        
        // Run the application!
        Zend\Mvc\Application::init(require 'config/application.config.php')->run();
         
    }
    
    public static function init()
    {
        self::$_config = new \Core\Model\Functions();
    }
    
    public static function config()
    {
        return self::$_config;
    }
    
    public static function getClassInstance($modelClass = '', $arguments = array())
    { 
        return self::config()->getClassInstance($modelClass, $arguments);
    }
    
    public static function getLocale()
    {
        $localtype = require 'config/autoload/locale.global.php';
        return $localtype;
    }
    
    public static function getTimezones()
    {
        $localtype = require 'config/autoload/timezone.global.php';
        return $localtype;
    }
    
    public static function getSiteConfig($path)
    { 
        return self::config()->getConfigData($path);
    }
    
}