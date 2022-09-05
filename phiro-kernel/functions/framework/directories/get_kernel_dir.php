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
*   @global @var $PHIRO_KERNEL_DIR
*       @definedIn \phiro-kernel\defines\directories.php
*
* @return String
*
* Restituisce la Cartella Kernel 
**/
function get_kernel_dir() {
    global $PHIRO_KERNEL_DIR;
    return $PHIRO_KERNEL_DIR;
}

?>