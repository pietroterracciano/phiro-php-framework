<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @author Pietro Terracciano
* @since  0.170528
*
* @see @global @var $PAGE_TEMPLATE
*   @definedIn \phiro-admin\loader.php
*
* @return Boolean
*
* Restituisce "true" se il Template della Pagina corrente è EXCEPTION, "false" altrimenti
**/
function is_exception_page() {
    global $PAGE_TEMPLATE;
    return ($PAGE_TEMPLATE == EXCEPTION__TEMPLATE) ? true : false;
}

?>