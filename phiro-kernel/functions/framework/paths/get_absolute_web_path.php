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
* Restituisce il Web Path assoluto dello Script corrente
**/
function get_absolute_web_path() {
    global $PhiroServer;
    return $PhiroServer->getAbsoluteWebPath();
}

function get_web_path() {
    return get_absolute_web_path();
}

?>