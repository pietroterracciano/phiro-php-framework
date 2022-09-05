<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @author Pietro Terracciano
* @since  0.170604
* 
* @param $number                         : Numero
* @return Boolean
*
* Converte @param $number al numero pari più vicino per eccesso. Se è già un numero pari, ritorna lo stesso numero
**/
function convert_to_even_number($number = 0) {
    $number = (int) $number;
    return ( !is_even_number($number) ) ? $number + 1 : $number;
}

?>