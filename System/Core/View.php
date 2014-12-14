<?php

/**
 * Aparg Framework
 * 
 * @author Aparg
 * @link http://www.aparg.com/
 * @copyright Aparg
 */

namespace System\Core;


class View extends Singleton{ 
    
    private $data = [];
    private $outputBuffering = true;
    private $appPath = '';
    
    public function init(){
        
        $this->outputBuffering = Config::obj()->get('output_buffering');
        $this->appPath = Config::obj()->get('app_path');
        $this->bufferStart();
    }
    public function render(){
        
        $this->bufferFlush();
    }
    
    private function bufferStart(){
       //'\System\Core\View::bufferCallback'
        if($this->outputBuffering){
            ob_start(array($this,'bufferCallback'));
        }
    }

    private function bufferCallback($buffer){
        
        return $buffer;        
    }
    
    private  function bufferFlush(){
        if($this->outputBuffering){
            ob_end_flush();
        }
    }
    
    public function load($route = '', $data = [], $return = false){ 
                
        $this->data = $data;
        
        $route = empty ($route) ? URI::obj()->route : $route;
        
        if(file_exists($this->appPath . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . $route . '.php')){
            if($return){
                ob_start();
            }                        
            require $this->appPath . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . $route . '.php';
            if($return){
                return ob_get_clean();                                
            }  
            return true;
        }else{
            return false;
        }
    }
    
    public function __set($name, $value){
        
        $this->data[$name] = $value;
    }
    public function __get($name){
        
        return isset($this->data[$name]) ? $this->data[$name] : null;
    }
}
