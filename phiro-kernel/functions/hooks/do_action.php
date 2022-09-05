<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @author Pietro Terracciano
* @since  0.170703
* 
* @param $paramsOrPoolName             : Array di parametri (contenente gli argomenti da passare al Pool) OPPURE Nome Pool di azioni da richiamare
* @return Boolean
*
* Restituisce "true" se il Pool di Azioni viene eseguito correttamente, "false" altrimenti
**/
function do_action($paramsOrPoolName = '') {
    return apply_filters($paramsOrPoolName, func_get_args());
}

?>