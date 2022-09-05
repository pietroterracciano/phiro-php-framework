<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @author Pietro Terracciano
* @since  0.170531
*
* @see @function array_key_exists()
* 
* @param $needle                         : Valore da ricercare
* @param $haystack                       : Array in cui effettuare la Ricerca
* @return Boolean
*
* Restituisce "true" se $needle è presente in $haystack, "false" altrimenti
**/
function array_key_exists_insensitive($needle = '', &$haystack = null) {
    if(!is_array($haystack) ) return false;
    foreach($haystack as $key => $value) {
        if( strings_compare_insensitive($key, $needle) ) 
            return true;
    }
    return false;
}

?>