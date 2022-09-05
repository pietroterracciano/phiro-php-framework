<?php

namespace Phiro\Lang;

if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @see @class \StdClass
**/
class Object extends \StdClass {

    /**
    * @since  0.170422
    **/
    const NO__ERROR_ID = 0;
    const NO__ERROR_MESSAGE = '';

    /**
    * @since  0.170422
    *
    * @define
    *   @param $class                : Nome della Classe
    *   @param $error                : Informazioni sull'Errore corrente (Se presente)
    **/
    protected $class;
    protected $error;

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @access public
    *
    * Istanzia un oggetto Object
	**/
    public function __construct() {
        $this->class = get_class($this);
        $this->error = array();
        $this->error['ID'] = self::NO__ERROR_ID;
        $this->error['message'] = self::NO__ERROR_MESSAGE;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @access public
    * @param Integer $paramsOrID            : Array di parametri OPPURE Identificativo dell'Errore
    * @param $message                       : Messaggio dell'Errore
    *
    * Imposta @param $error
	**/
    final public function setError($paramsOrID = '', $message = '') {
        if( is_array($paramsOrID ) ) {
            $ID = ( isset($paramsOrID['ID']) ) ? $paramsOrID['ID'] : 0;
            $message = ( isset($paramsOrID['message']) ) ? $paramsOrID['message'] : 0;
        } else
            $ID = $paramsOrID;
        $this->error['ID'] = (int) $ID;
        $this->error['message'] = trim($message);
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170702
    *
    * @access public
    * @param $message                       : Messaggio dell'Errore
    *
    * Imposta $error['message']
	**/
    final public function setErrorMessage($message = '') {
        $this->error['message'] = trim($message);
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @access public
    *
    * Resetta @param $error
	**/
    final public function setNoError() {
        $this->error['ID'] = (int) self::NO__ERROR_ID;
        $this->error['message'] = self::NO__ERROR_MESSAGE;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @access public
    * @param $class           : Nome della Classe
    * @return Boolean
    *
    * Restituisce "true" se l'Istanza corrente è un oggetto figlio di @param $class, "false" altrimenti
	**/
    final public function isSubclassOf($class = null) {
        return is_subclass_of($this, $class);
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @access public
    * @param $instance           : Istanza
    * @return Boolean
    *
    * Restituisce "true" se l'Istanza corrente è una istanza di @param $instance, "false" altrimenti
	**/
    final public function isInstanceOf($instance = null) {
        return ($this instanceof $instance);
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @access public
    * @return Boolean
    *
    * Restituisce "true" se l'Istanza corrente presenta un errore, "false" altrimenti
	**/
    public function isOnError() {
        return ($this->error['ID'] != 0) ? true : false;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170605
    *
    * @access public
    * @return Boolean
    *
    * Restituisce "true" se l'Istanza corrente non presenta errori, "false" altrimenti
	**/
    final public function isWorking() {
        return ($this->error['ID'] == 0) ? true : false;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @access public
    * @return String
    *
    * Restituisce @param $class
	**/
    final public function getClass() {
        return $this->class;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @access public
    * @return String
    *
    * Restituisce @param $error['ID']
	**/
    final public function getErrorID() {
        return $this->error['ID'];
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @access public
    * @return String
    *
    * Restituisce @param $error['message']
	**/
    final public function getErrorMessage() {
        return $this->error['message'];
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170703
    *
    * @access public
    * @return String
    *
    * Restituisce lo Status dell'Oggetto
	**/
    final public function getStatus() {
        return ($this->isWorking()) ? 'Is working' : 'Is on error';
    }
    
}


?>