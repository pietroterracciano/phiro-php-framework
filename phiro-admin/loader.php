<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit; 

define('STANDARD__TEMPLATE', 0);
define('DOCUMENTATION__TEMPLATE', 1);
define('EXCEPTION__TEMPLATE', 2);

global $PAGE_TEMPLATE;
$PAGE_TEMPLATE = STANDARD__TEMPLATE;

/**
* @since 0.170528
*
* Carica le funzioni del Tema Amministrativo
**/
$initPath = str_replace('\\', '/', dirname(__FILE__));
$files = get_phiro_component_files($initPath.'/functions');
if(!empty($files)) { foreach($files as $file) require_once($file);  }

?>