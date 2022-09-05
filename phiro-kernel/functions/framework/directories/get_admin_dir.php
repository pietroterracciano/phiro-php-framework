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
*   @global @var $PHIRO_ADMIN_DIR
*       @definedIn \phiro-kernel\defines\directories.php
*
* @return String
*
* Restituisce la Cartella Admin
**/
function get_admin_dir() {
    global $PHIRO_ADMIN_DIR;
    return $PHIRO_ADMIN_DIR;
}

?>