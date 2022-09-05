<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @define
*   @global @array $PHIRO__FILTERS
*
* Phiro inserisce i Pool di Filtri all'interno di questo array
* Inoltre mappa le Funzioni anonime in __ANONYMOUS_CALLBACKS__ perchè non possono essere Serializzate in Phiro\ADT\Queue
**/
$PHIRO__FILTERS = array(
    '__ANONYMOUS_CALLBACKS__' => array()
);

/**
* @author Pietro Terracciano
* @since  0.170703
*
* @see @class Phiro\ADT\Queue
*   @defineIn \phiro-kernel\classes\adt\Queue.php
* 
* @param $poolName                             : Nome Pool di Filtri
* @param $callback                             : Nome Funzione OPPURE Funzione anonima da integrare nel Pool di Filtri
* @param $callbackPriority                     : Priorità della funzione che ha nel Pool di Filtri
* @param $callbackParamsNumber                 : Numero di Parametri che la funzione richiede
* @return Boolean
*
* Restituisce "true" se la Funzione viene aggiunta correttamente al Pool specificato, "false" altrimenti
*
* @likeAs WordPress add_filter()
**/
function add_filter($paramsOrPoolName = '', $callback = '', $callbackPriority = 10, $callbackParamsNumber = 5) {
    $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);

    if(!empty($backtrace[1]['function']) && $backtrace[1]['function'] === 'add_action') {
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
    $callbackParamsNumber = (int) $callbackParamsNumber;
    $callbackPriority = (int) $callbackPriority;

    if( empty($poolName) || empty($callback) || !is_callable($callback) ) return false;
    if(!is_a($callback, 'Closure')) $callback = trim($callback);
    else {
        $position = count($_STRUCTURE['__ANONYMOUS_CALLBACKS__']);
        $_STRUCTURE['__ANONYMOUS_CALLBACKS__'][$position] = $callback;
        $callback = '__ANONYMOUS_CALLBACK__'.$position;
    }

    if( empty($_STRUCTURE[$poolName][$callbackPriority]) 
        || !is_a($_STRUCTURE[$poolName][$callbackPriority], 'Phiro\ADT\Queue')) 
        $_STRUCTURE[$poolName][$callbackPriority] = new Phiro\ADT\Queue();

    krsort($_STRUCTURE[$poolName], SORT_NUMERIC);

    return $_STRUCTURE[$poolName][$callbackPriority]->add(
        array(
            'callback' => $callback,
            'callbackParamsNumber' => $callbackParamsNumber,
        )
    );
}

?>