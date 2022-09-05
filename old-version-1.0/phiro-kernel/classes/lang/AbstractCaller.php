<?php

namespace Phiro\Lang;

if(!defined('Phiro\Constants\KERNEL_DIR')) exit;

use ReflectionClass;

abstract class AbstractCaller {

    public function __construct() {
        $args = func_get_args();
        if(empty($args) || !is_array($args) || count($args) < 1) return null;
    }

    /**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @access public
    * @param $classToCall
    * @param ...$args
    **/
    public function __call($classToCall = null, $args = null) {
        if(empty($classToCall)) return null;
        $className = get_class($this);
        if(!class_exists($classToCall)) {
            if(class_exists($className.'\\'.$classToCall)) 
                $classToCall = $className.'\\'.$classToCall;
            else return null;
        }
        if(!is_subclass_of($classToCall, $className)) return null;
        $reflection = new ReflectionClass($classToCall); 
        $instance = $reflection->newInstanceArgs($args);
        return $instance;
    }
    
}