<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @author Pietro Terracciano
* @since  0.170602
*
* @param $object                         : Oggetto su cui effettuare l'operazione
* @return Boolean
*
* Restituisce "true" se @param $object è un Oggetto JSON, "false" altrimenti
**/
function is_json($object = null) {
    if( is_array($object) || is_object($object) || ( $objectLength = strlen($object) ) < 3) return false;

    $firstObjectCharacter = $object[0];
    $lastObjectCharacter = $object[$objectLength - 1];

    if(
        ($firstObjectCharacter ===  '{' && $lastObjectCharacter === '}') 
        || ($firstObjectCharacter ===  '[' && $lastObjectCharacter === ']') 
        || ($firstObjectCharacter ===  '"' && $lastObjectCharacter === '"')
    ) return true;
    return false;
}

?>