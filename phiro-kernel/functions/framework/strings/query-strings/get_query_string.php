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
* @return String
*
* Restituisce la Query String dello Script corrente se @param $URL è vuoto, 
* altrimenti calcola la Query String dell'URL
**/
function get_query_string($URL = '') {
    global $PhiroServer;
    if( ($PhiroServer instanceof Phiro\Lang\Server) && ( empty($URL) || !is_string($URL) )) {
        global $PhiroServer;
        return $PhiroServer->getQueryString();
    } 
    return strtok($URL, '?');
}

?>