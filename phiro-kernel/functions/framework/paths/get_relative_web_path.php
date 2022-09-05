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
* Restituisce il Web Path relativo dello Script corrente
**/
function get_relative_web_path() {
    global $PhiroServer;
    return $PhiroServer->getRelativeWebPath();
}

?>