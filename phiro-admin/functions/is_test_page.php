<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @author Pietro Terracciano
* @since  0.170602
*
* @see @global @var $PAGE_TEMPLATE
*   @definedIn \phiro-admin\loader.php
*
* @return Boolean
*
* Restituisce "true" se il Template della Pagina corrente è TEST, "false" altrimenti
**/
function is_test_page() {
    global $PAGE_TEMPLATE;
    return ($PAGE_TEMPLATE == TEST__TEMPLATE) ? true : false;
}

?>