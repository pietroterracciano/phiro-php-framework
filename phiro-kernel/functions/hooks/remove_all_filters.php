<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @author Pietro Terracciano
* @since  0.170703
*
* @see @class Phiro\ADT\Queue
*   @defineIn \phiro-kernel\classes\adt\Queue.php
* 
* @param $poolName                             : Nome Pool di Filtri
* @param $callbackPriority                     : Priorità della funzione nel Pool di Filtri
* @return Boolean
*
* Restituisce "true" se le Funzioni con priorità @param $callbackPriority vengono rimosse dal Filtro @param $poolName, "false" altrimenti
*
* @likeAs WordPress remove_all_filters()
**/
function remove_all_filters($paramsOrPoolName = '', $callbackPriority = 10) {
    $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);

    if(!empty($backtrace[1]['function']) && $backtrace[1]['function'] === 'remove_all_actions') {
        global $PHIRO__ACTIONS;
        $_STRUCTURE = &$PHIRO__ACTIONS;
    } else {
        global $PHIRO__FILTERS;
        $_STRUCTURE = &$PHIRO__FILTERS;
    }

    if(is_array($paramsOrPoolName)) {
        foreach($paramsOrPoolName as $key => $value)
            ${$key} = $value;
    } else
        $poolName = $paramsOrPoolName;
    
    $poolName = trim($poolName);

    if(empty($poolName) 
        || empty($_STRUCTURE[$poolName][$callbackPriority])
        || !is_a($_STRUCTURE[$poolName][$callbackPriority], 'Phiro\ADT\Queue') ) return false;

    unset($_STRUCTURE[$poolName][$callbackPriority]);
    return true;
}

?>