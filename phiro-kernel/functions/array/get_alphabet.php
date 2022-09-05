<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @author Pietro Terracciano
* @since  0.170606
* 
* @param Boolean $paramsOrAllowPunctuationCharacters         : Array di parametri OPPURE se impostato a "true" inserisce i Caratteri di Punteggiatura
* @param Boolean $allowSpecialCharacters                     : Se impostato a "true" inserisce i Caratteri Speciali
* @return Array
*
* Restituisce l'Alfabeto sotto forma di Array
**/
function get_alphabet($paramsOrAllowPunctuationCharacters = false, $allowSpecialCharacters = false) {
    if(is_array($paramsOrAllowPunctuationCharacters)) {
        $allowPunctuationCharacters = ( !empty($paramsOrAllowPunctuationCharacters['allowPunctuationCharacters'])) ? $paramsOrAllowPunctuationCharacters['allowPunctuationCharacters'] : '';
        $allowSpecialCharacters = ( !empty($paramsOrAllowPunctuationCharacters['allowSpecialCharacters'])) ? $paramsOrAllowPunctuationCharacters['allowSpecialCharacters'] : '';
    } else
        $allowPunctuationCharacters = $paramsOrAllowPunctuationCharacters;

    $allowPunctuationCharacters = (bool) $allowPunctuationCharacters;
    $allowSpecialCharacters = (bool) $allowSpecialCharacters;

    /**
    * range(chr(65), chr(90))                       : Alfabeto uppercase
    * range(chr(97), chr(122))                      : Alfabeto lowercase
    * range(chr(48), chr(57))                       : Numeri
    **/ 
    $alphabet = array_merge( range(chr(65), chr(90)), range(chr(97),chr(122)), range(chr(48), chr(57)) );

    /**
    * Caratteri di punteggiatura
    **/
    if( $allowPunctuationCharacters) $alphabet = array_merge($alphabet, range(chr(32), chr(47)), range(chr(58), chr(64)), range(chr(91), chr(96)), range(chr(123), chr(126)) ); 

    /**
    * Caratteri speciali
    **/
    if( $allowSpecialCharacters ) $alphabet = array_merge($alphabet, range(chr(128), chr(253)));

    return $alphabet;
}

?>