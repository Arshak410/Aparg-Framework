<?php

/**
 * Aparg Framework
 * 
 * @author Aparg
 * @link http://www.aparg.com/
 * @copyright Aparg
 */

use \System\Core\Autoloader;
use \System\Core\Config;
use \System\Core\Controller;
use \System\Core\URI;

abstract class App{
    
    
    protected $config = null;    
    protected $URI = null;
            
    protected function __construct(){
        
        $this->config = Config::obj();
        $this->URI = URI::obj();        
    }
    
    public static function start($config = []){      
        
        require_once __DIR__ . DIRECTORY_SEPARATOR . 'Core' . DIRECTORY_SEPARATOR . 'Autoloader.php';
        Autoloader::init();
        
        //Init config
        Config::init($config);  
        
        //Check compatibility        
        if(phpversion() < Config::obj()->get('min_php_version')){ 
            trigger_error('Suported PHP version is 5.3.3 and above.', E_USER_ERROR);                    
        }
 
        //Check debug mode
        error_reporting((Config::obj()->get('debug_mode')) ? -1 : 0);
        
                       
        //Init URI
        URI::init($_SERVER['REQUEST_URI']);                                
        
        Controller::load(URI::obj()->route, URI::obj()->vars);
        
    }
}