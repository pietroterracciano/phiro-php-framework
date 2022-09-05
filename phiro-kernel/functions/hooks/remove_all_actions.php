<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @author Pietro Terracciano
* @since  0.170703
*
* @see @function remove_all_filters()
*   @defineIn \phiro-kernel\functions\...\remove_all_filters.php
* 
* @param $poolName                             : Nome Pool di Azioni
* @param $callbackPriority                     : Priorità delle funzioni nel Pool di Azioni
* @return Boolean
*
* Restituisce "true" se le Funzioni con priorità @param $callbackPriority vengono rimosse dall'Azione @param $poolName, "false" altrimenti
*
* @likeAs WordPress remove_all_actions()
**/
function remove_all_actions($paramsOrPoolName = '', $callbackPriority = 10) {
    return remove_all_filters($paramsOrPoolName, $callbackPriority);
}

?>