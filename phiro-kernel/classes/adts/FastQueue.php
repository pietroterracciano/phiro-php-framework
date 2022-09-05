<?php

namespace Phiro\ADTs;

/**
* @trick SECURITY
**/ 
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @see @class Phiro\ADT\Drivers\FastQueue
*   @defineIn \phiro-kernel\classes\adt\drivers\&FastQueue.php
**/
class FastQueue extends \Phiro\ADT {

    /**
    * @since  0.170708
    **/
    const ADT_IS_FULL__ERROR_MESSAGE = 'Queue is full';

    public function add($object = null) {
        if( is_null($object) ) return false;
        
        if($this->isDynamic()) {
            $position = $this->capacity;
            $this->capacity++;
        } else {
            if($this->isFull()) {
                $this->setError(
                    self::ADT_IS_FULL__ERROR_ID,
                    self::ADT_IS_FULL__ERROR_MESSAGE
                );
                return false;
            }
            $position = $this->filling % $this->capacity;
        }
        $this->filling++;

        $this->im[$position] = 
            @serialize(
                $object
            );

        return true;

    }

    public function peek() {

        if( $this->filling < 1 || !is_numeric($position) || !isset($this->im[$position])) return null;
        
        $position = (int) $position;
        $ADTElement = @unserialize($this->im[$position]);
        
        if(empty($ADTElement))  return null;
        return $ADTElement;

    }

    public function remove() {

    }

}



?>