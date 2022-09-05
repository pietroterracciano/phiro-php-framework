<?php

namespace Phiro\Lang;

if(empty($PHIRO_KERNEL_DIR)) exit;

use Phiro\UI;
use Phiro\Utils;

/**
* @see @class \Exception
**/
class Exception extends \Exception {

    /**
    * @since  0.170512
    *
    * @define @params INSTANCE
    * @define
    *   @param \Exception->$message               : Messaggio dell'Eccezione
    *   @param $ID                                : Identificativo dell'Eccezione
    **/
    private $ID;

	/**
    * @author Pietro Terracciano
    * @since  0.170512
    *
    * @see 
    *   @function \Exception->__construct()
    *
    * @access public                        
    * @param $arrayOrID                           : Array di Parametri OPPURE Identificativo dell'Eccezione
    * @param $ID                                  : Identificativo dell'Eccezione
    *
    * Istanzia una Eccezione
	**/
    final public function __construct($arrayOrID = null, $message = '') {
        if(!is_array($arrayOrID)) {
            $ID = trim($arrayOrID);
            $message = trim($message);
        } else {
            $arrayOrID = recursive_array_map('trim', $arrayOrID);
            $ID = (!empty($arrayOrID['ID'])) ? $arrayOrID['ID'] : '';
            $message = (!empty($arrayOrID['message'])) ? $arrayOrID['message'] : '';
        }

        $this->ID = $ID;

        parent::__construct($message);
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170512
    *
    * @access public
    * @return String / Param Value
    *
    * Restituisce @param $ID
	**/
    final public function getID() {
        return $this->ID;
    }

}

?>