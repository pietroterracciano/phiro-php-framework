<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @author Pietro Terracciano
* @since  0.170524
*
* @see  @function json_decode()
* @pseudo @override json_decode()
*
* @param $object                         : Oggetto su cui effettuare la Decodifica JSON (es. Stringa JSON, Array JSON, ...)
* @return String JavaScript Object Notation / JSON
*
* Restituisce un Oggetto ottenuto dalla conversione di @param $object
* Se l'oggetto originario non è un oggetto JSON restituisce null
**/
function json_secure_decode($object = '') {
    if( !is_json($object) ) return $object;
    $object = @json_decode( $object );
    return ( json_last_error() == JSON_ERROR_NONE ) ? $object : null;
}

function _json_decode($object = '') {
    return json_secure_decode($object);
}

?>