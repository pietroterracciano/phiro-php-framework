<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @author Pietro Terracciano
* @since  0.170524
*
* @see  @function json_encode()
* @pseudo @override json_encode()
*
* @param $object                     : Oggetto su cui effettuare la Codifica JSON (es. Stringa, Array, Standard Class ...)
* @return String JavaScript Object Notation / JSON
*
* Restituisce una Stringa JSON ottenuta dalla conversione di @param $object
* Se l'oggetto non è convertibile in JSON restituisce una Stringa vuota
**/
function json_secure_encode($object = '') {
    if( is_json($object) ) return $object;
    $object = @json_encode( $object );
    return ( json_last_error() == JSON_ERROR_NONE && $object != 'null' ) ? $object : '';
}

function _json_encode($object = '') {
    return json_secure_encode($object);
}

?>