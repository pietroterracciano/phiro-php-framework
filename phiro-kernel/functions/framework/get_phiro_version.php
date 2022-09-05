<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @author Pietro Terracciano
* @since  0.170707
*
* @see
*   @global @var $PHIRO_VERSION
*       @definedIn \phiro-kernel\defines\config.php
* 
* @return String
*
* Restituisce la versione attuale del Framework
**/
function get_phiro_version($path = '', $extensions = 'php') {
    global $PHIRO_VERSION;
    return $PHIRO_VERSION;
}

?>