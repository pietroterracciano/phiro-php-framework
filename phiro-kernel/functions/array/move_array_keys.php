<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @author Pietro Terracciano
* @since  0.170611
*
* @param Integer $newPosition                    : Nuova posizione / Numero di spostamenti che una Key deve subire / Offset nuova posizione rispetto a 0
* @param Array $array                            : Array su cui effettuare le operazioni richieste
* @return Array()
*
* Restituisce un Array su cui viene applicato uno spostamento delle Chiavi secondo @param $newPosition
**/
function move_array_keys($array = null, $newPosition = 0) {
    if(is_object($array)) $array = (array) $array;
    else if(!is_array($array)) return array();

    $arraySize = count($array);
    $arrayKeys = array_keys($array);
    
    $newPosition = ( (int) $newPosition ) % $arraySize;
    if( $newPosition > 0 ) $increment = $arraySize - $newPosition;
    else if( $newPosition < 0 ) $increment = -$newPosition;
    else $increment = 0;
    
    if($increment > 0) {
        $newArray = array();
        for($i=0; $i<$arraySize; $i++) {
            $key = $arrayKeys[ ($i + $increment) % $arraySize ];
            $newArray[ $i ] = $array [ $key ];
        }
        $array = $newArray;
    }

    return $array;
}

?>