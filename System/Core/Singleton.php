<?php

/**
 * Aparg Framework
 * 
 * @author Aparg
 * @link http://www.aparg.com/
 * @copyright Aparg
 */
namespace System\Core;

abstract class Singleton {

    private static $instances;

    final public static function &obj() {
        $className = get_called_class();

        if(!isset(self::$instances[$className])) {          
            self::$instances[$className] = new static();
        }
        return self::$instances[$className];
    }
    
    final public static function isObj(){
        
        $className = get_called_class();        
        return isset(self::$instances[$className]);
    }

    final protected function  __construct() { } 
    
    final public function __clone() { }

    final public function __wakeup() { }

}


