<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @author Pietro Terracciano
* @since  0.170422
*
* @see @function in_array()
* 
* @param $needle                         : Valore da ricercare
* @param $haystack                       : Array in cui effettuare la Ricerca
* @return Boolean
*
* Restituisce "true" se $needle è presente in $haystack, "false" altrimenti
**/
function in_array_insensitive($needle = '', $haystack = null) {
    if(!is_array($haystack) ) return false;
    foreach($haystack as $key => $value) {
        if( strings_compare_insensitive($value, $needle) ) 
            return true;
    }
    return false;
}

?>