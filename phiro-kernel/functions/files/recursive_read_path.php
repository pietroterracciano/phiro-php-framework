<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @author Pietro Terracciano
* @since  0.170707
* 
* @param $path                         : Path da cui iniziare la lettura 
* @param $extensions                   : Estensioni dei Files
* @return Array
*
* @algorithmType RECURSIVE
*
* Restituisce ricorsivamente tutti i Paths e i Files presenti in @param $path
* Se @param $extensions è considerato, vengono restituiti solo i Files compatibili con le estensioni dichiarate
**/
function recursive_read_path($path = '', $extensions = '') {
    return read_path($path, $extensions);
}

?>