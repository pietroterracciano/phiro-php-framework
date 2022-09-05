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
*   @global @var $PHIRO_CACHE_DIR
*       @definedIn \phiro-kernel\defines\directories.php
*
* @return String
*
* Restituisce la Cartella Cache
**/
function get_cache_dir() {
    global $PHIRO_CACHE_DIR;
    return $PHIRO_CACHE_DIR;
}

?>