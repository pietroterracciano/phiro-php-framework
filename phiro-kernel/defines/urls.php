<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @since 0.170424
*
* @define @global @var $PHIRO_REL_HTTP_URL
*
* URL HTTP relativo
* Phiro mappa la Definizione in una Variabile globale invece di usare il metodo define(). Consente di ottenere prestazioni maggiori
*
* @trick PERFORMANCE
**/
global $PHIRO_REL_HTTP_URL;
$PHIRO_REL_HTTP_URL = $_SERVER['REQUEST_URI'];

/**
* @since 0.170424
*
* @define @global @var $PHIRO_ABS_HTTP_URL
*
* URL HTTP assoluto
* Phiro mappa la Definizione in una Variabile globale invece di usare il metodo define(). Consente di ottenere prestazioni maggiori
*
* @trick PERFORMANCE
**/
global $PHIRO_ABS_HTTP_URL;
$PHIRO_ABS_HTTP_URL = 'http://'.$_SERVER['SERVER_NAME'].$PHIRO_REL_HTTP_URL;

/**
* @since 0.170424
*
* @define @global @var $PHIRO_REL_ADMIN_URL
*
* URL HTTP relativo della Cartella ADMIN
* Phiro mappa la Definizione in una Variabile globale invece di usare il metodo define(). Consente di ottenere prestazioni maggiori
*
* @trick PERFORMANCE
**/
global $PHIRO_REL_ADMIN_URL;
$PHIRO_REL_ADMIN_URL = $PHIRO_REL_HTTP_URL.'/'.$PHIRO_ADMIN_DIR;

?>