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
* Restituisce "true" se @param $number è un numero pari, "false" altrimenti
**/
function is_even_number($number = 0) {
    return ( is_numeric($number) && $number%2 == 0 ) ? true : false;
}

?>