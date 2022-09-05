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
* Restituisce l'URL Web assoluto dello Script corrente
**/
function get_absolute_web_url($withoutQueryString = false) {
    global $PhiroServer;
    return (!$withoutQueryString) ? $PhiroServer->getAbsoluteWebURL() : strtok($PhiroServer->getAbsoluteWebURL(), '?');
}

function get_web_url() {
    return get_absolute_web_url();
}

?>