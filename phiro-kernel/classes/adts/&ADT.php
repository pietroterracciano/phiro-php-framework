<?php

namespace Phiro;

/**
* @trick SECURITY
**/ 
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @see @class Phiro\Lang\Object
*   @defineIn \phiro-kernel\classes\lang\Object.php
**/
abstract class ADT extends \Phiro\Lang\Object {

    /**
    * @since  0.170702
    **/
    const ADT_IS_FULL__ERROR_ID = -1;
    const ADT_IS_FULL__ERROR_MESSAGE = 'ADT / Abstract Data Type is full';

    /**
    * @since  0.170701
    * @define 
    *   @param $im          : Struttura Dati utilizzata per simulare un ADT / Abstract Data Type / Tipo di Dato Astratto
    *
    * @since 0.170708
    * @define
    *   @param $capacity    : Capacità massima TDA
    *   @param $filling     : Riempimento TDA
    *   @param $dynamic     : Se "true" il TDA è dinamico e pertanto @param $capacity è sempre uguale a @param $filling
    **/
    protected $im;
    protected $capacity;
    protected $filling;
    protected $dynamic;

    /**
    * @author Pietro Terracciano
    * @since  0.170701
    *
    * Istanzia un oggetto TDA / ADT
	**/
    final public function __construct($capacity = 0) {
        parent::__construct();
        $this->im = array();
        $this->filling = 0;
        $this->allocate($capacity);
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170704
    *
    * Alloca esattamente @param $capacity posizioni per il TDA considerato
    * Se @param $capacity > 0 il TDA diventa statico (Simile ad un Buffer), viceversa si
    * comporta dinamicamente 
	**/
    final public function allocate($capacity = 0) {
        $this->capacity = (int) $capacity;
        if($this->capacity > 0) {
            $this->dynamic = false;
            for($i=0;$i<$this->capacity;$i++) {
                if(!isset($this->im[$i])) $this->im[$i] = null;
            }
        } else {
            $this->capacity = 0;
            $this->dynamic = true;
        }
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170704
    *
    * Restituisce "true" se vengono eliminati tutti i valori contenuti nel TDA, "false" altrimenti
	**/
    final public function flush() {
        $this->im = array();
        if(empty($this->im)) return true;
        return false;
    }
    
    final public function removeAll() { 
        return $this->flush(); 
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170704
    *
    * Restituisce il Riempimento attuale del TDA
	**/
    final public function getFilling() {
        return $this->filling;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170704
    *
    * Restituisce la Capacità massima del TDA
	**/
    final public function getCapacity() {
        return $this->capacity;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170704
    *
    * Restituisce "true" se il TDA è dinamico, "false" altrimenti
	**/
    final public function isDynamic() {
        return $this->dynamic;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170704
    *
    * Restituisce "true" se il TDA è pieno, "false" altrimenti
	**/
    final public function isFull() {
        return ($this->dynamic) ? false : ( ($this->filling == $this->capacity) ? true : false);
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170704
    *
    * Restituisce "true" se il TDA è vuoto, "false" altrimenti
	**/
    final public function isEmpty() {
        return ($this->filling < 1) ? true : false;
    }

    abstract protected function add();

    abstract protected function peek();

    abstract protected function remove();

/*
    final protected function addADTElement($params = null) {
        if( ($paramsSize = count($params) ) < 0 || is_null($params[0])) return false;
        
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

        if($paramsSize < 2) $params = $params[0];

        $this->im[$position] = 
            @serialize(
                $params
            );

        return true;
    }

    final protected function peekADTElement($position = 0) {
        if( $this->filling < 1 || !is_numeric($position) || !isset($this->im[$position])) return null;
        
        $position = (int) $position;
        $ADTElement = @unserialize($this->im[$position]);
        
        if(empty($ADTElement))  return null;
        return $ADTElement;
    }
    
    final protected function removeADTElement($position = 0) {
        $ADTElement = $this->peekADTElement($position);

        unset($this->im[$position]);

        if($ADTElement != null) {
            if($this->isDynamic()) {
                $this->capacity--; 
                if($this->capacity < 0) $this->capacity = 0;
            } else
                $this->im[$position] = null;
            $this->im = array_values($this->im);
            $this->filling--; if($this->filling < 0) $this->filling = 0;
        }

        return $ADTElement;
    }
*/
}

?>