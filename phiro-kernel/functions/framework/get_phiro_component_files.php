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
*   @function recursive_read_path()
*       @definedIn \phiro-kernel\functions\files\recursive_read_path.php
* 
* @param $path                         : Path da cui iniziare la lettura 
* @param $extensions                   : Estensioni dei Files
* @return Array
*
* @algorithmType RECURSIVE
*
* Restituisce tutti i Files presenti in @param $path
* Permette di caricare velocemente un componente del Framework tramite un foreach($files as $file) require_once $file
**/
function get_phiro_component_files($path = '', $extensions = 'php') {
    return recursive_read_path($path, $extensions);
}

?>