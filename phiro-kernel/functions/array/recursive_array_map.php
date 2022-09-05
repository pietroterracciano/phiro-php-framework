<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @author Pietro Terracciano
* @since  0.170426
*
* @see @function array_map()
* 
* @param String $callback                          : Funzione da applicare sui Valori dell'Array
* @param Array $array                              : Array su cui effettuare le operazioni richieste
* @return Array()
*
* @algorithm RECURSIVE
*
* Restituisce un Array sui cui Valori viene applicata una funzione a runtime (Callback)
**/
function recursive_array_map($callback = '', $array = null) {
    $result = array();

    if( !is_array($array) ) return $result;
    if( empty($callback) || !is_string($callback) ) return $array;

    foreach($array as $key => $value) {
        if( is_array($value) )
            $result[$key] = recursive_array_map($callback, $value);
        else
            $result[$key] = call_user_func($callback, $value);
    }

    return $result;
}

?>