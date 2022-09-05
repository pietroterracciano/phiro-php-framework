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
class FastStack extends \Phiro\ADT {

    public function add() {

    }

    public function peek() {

    }

    public function remove() {

    }
    
    /**
    * @since  0.170702
    **/
    const ADT_IS_FULL__ERROR_MESSAGE = 'Stack is full';
    
    /**
    * @author Pietro Terracciano
    * @since  0.170701
    *
    * @access public
    * @return Boolean
    *
    * Aggiunge un qualsiasi Oggetto in cima allo Stack convertendolo in una Stringa
    * Restituisce "true" se l'Oggetto è stato inserito correttamente, "false" altrimenti
	**/
    final public function push() {
        $pushed = $this->addADTElement(func_get_args());
        if($pushed) return true;
        if($this->getErrorID() == -1) $this->setErrorMessage(self::ADT_IS_FULL__ERROR_MESSAGE);
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170701
    *
    * @access public
    * @return Boolean
    *
    * Preleva la Stringa in cima allo Stack e la riconverte in Oggetto
    * Se la conversione fallisce restituisce "null", altrimenti restituisce l'Oggetto
	**/
    final public function pop() {
        return $this->removeADTElement( $this->ADTFilling - 1 );
    }


}



?>