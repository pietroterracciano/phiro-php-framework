<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @author Pietro Terracciano
* @since  0.170706
*
* @return String
*
* Restituisce l'URL Web relativo dello Script corrente
**/
function get_relative_web_url() {
    global $PhiroServer;
    return $PhiroServer->getRelativeWebURL();
}

?>