<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @author Pietro Terracciano
* @since  0.170706
* 
* @param $URL                     : URL da cui prelevare la Query String
*
* @return StdClass Object
*
* Restituisce la Query String dello Script corrente come StdClass Object
**/
function get_query_string_as_object($URL = '') {
    return (object) get_query_string_as_array($URL);
}

?>