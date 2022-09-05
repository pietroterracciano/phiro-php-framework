<?php

namespace Phiro\Utils;

if(!defined('Phiro\Constants\KERNEL_DIR')) exit;

class Json {

    /**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @access public
    * @param $object                            : Oggetto su cui effettuare l'operazione (es. Stringa, Array, StdClassm ...)
    * @return JSON Object                       : Restituisce un Oggetto JSON ottenuto dalla conversione dell'oggetto $object
	**/
    public static function _encode($object = null) {
        if(empty($object)) return null;
        return json_encode($object);
    }

    /**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @access public
    * @param $jsonObject                         : Oggetto su cui effettuare l'operazione (es. Stringa JSON, Array JSON, ...)
    * @return JSON Object                        : Restituisce un Oggetto ottenuto dalla conversione dell'oggetto $jsonObject
	**/
    public static function _decode($jsonObject = null) {
        if(empty($jsonObject)) return null;
        return json_decode($jsonObject);
    }
    
}

?>