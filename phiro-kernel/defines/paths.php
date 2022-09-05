<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

$serverDocumentRoot = str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']);

/**
* @since 0.170706
*
* @see 
*   @function dirname()
*
* @define @global @var $PHIRO_REL_OS_PATH
*
* Path relativo in cui il Framework è installato
* Phiro mappa la Definizione in una Variabile globale invece di usare il metodo define(). Consente di ottenere prestazioni maggiori
*
* @trick PERFORMANCE
**/
global $PHIRO_REL_OS_PATH;
$absoluteOSPath = str_replace('\\','/', dirname(dirname(dirname(__FILE__))));
$PHIRO_REL_OS_PATH = str_replace( $serverDocumentRoot, '', $absoluteOSPath );

/**
* @since 0.170706
*
* @define @global @var $PHIRO_ABS_OS_PATH
*
* Path assoluto in cui il Framework è installato
* Phiro mappa la Definizione in una Variabile globale invece di usare il metodo define(). Consente di ottenere prestazioni maggiori
*
* @trick PERFORMANCE
**/
global $PHIRO_ABS_OS_PATH;
$PHIRO_ABS_OS_PATH = $serverDocumentRoot.$PHIRO_REL_OS_PATH;

?>