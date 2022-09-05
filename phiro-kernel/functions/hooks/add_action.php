<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @define
*   @global @array $PHIRO__ACTIONS
*
* Phiro inserisce i Pool di Azioni all'interno di questo array
* Inoltre mappa le Funzioni anonime in __ANONYMOUS_CALLBACKS__ perchè non possono essere Serializzate in Phiro\ADT\Queue
**/
$PHIRO__ACTIONS = array(
    '__ANONYMOUS_CALLBACKS__' => array()
);

/**
* @author Pietro Terracciano
* @since  0.170703
*
* @see @function add_filter()
*   @defineIn \phiro-kernel\functions\...\add_filter.php
* 
* @param $poolName                             : Nome Pool di Azioni
* @param $callback                             : Nome Funzione OPPURE Funzione anonima da integrare nel Pool di Azioni
* @param $callbackPriority                     : Priorità della funzione che ha nel Pool di Azioni
* @param $callbackParamsNumber                 : Numero di Parametri che la funzione richiede
* @return Boolean
*
* Restituisce "true" se la Funzione viene aggiunta correttamente al Pool specificato, "false" altrimenti
*
* @likeAs WordPress add_action()
**/
function add_action($paramsOrPoolName = '', $callback = '', $callbackPriority = 10, $callbackParamsNumber = 5) {
    add_filter($paramsOrPoolName, $callback, $callbackPriority, $callbackParamsNumber);
}

?>