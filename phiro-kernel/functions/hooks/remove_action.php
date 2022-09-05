<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @author Pietro Terracciano
* @since  0.170703
*
* @see @function remove_filter()
*   @defineIn \phiro-kernel\functions\...\remove_filter.php
* 
* @param $poolName                             : Nome Pool di Azioni
* @param $callback                             : Nome Funzione integrata nel Pool di Azioni
* @param $callbackPriority                     : Priorità della funzione nel Pool di Azioni
* @return Boolean
*
* Restituisce "true" se la Funzione viene rimossa correttamente dal Pool specificato, "false" altrimenti
*
* @likeAs WordPress remove_action()
**/
function remove_action($paramsOrPoolName = '', $callback = '', $callbackPriority = 10) {
    return remove_filter($paramsOrPoolName, $callback, $callbackPriority);
}

?>