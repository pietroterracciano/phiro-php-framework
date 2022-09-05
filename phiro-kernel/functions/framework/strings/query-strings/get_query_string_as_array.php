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
* @return Array
*
* Restituisce la Query String dello Script corrente come Array di parametri
**/
function get_query_string_as_array($URL = '') {
    if(empty($URL) || !is_string($URL) ) {
        global $PhiroServer;
        $queryString = $PhiroServer->getQueryString();
    } else
        $queryString = get_query_string($URL);
    parse_str($queryString, $queryParams);
    return $queryParams;
}

?>