<?php

/**
* @since 0.170528
*
* @define @global @var $PHIRO_ADMIN_DIR
*
* Cartella ADMIN
* Phiro mappa la Definizione in una Variabile globale invece di usare il metodo define(). Consente di ottenere prestazioni maggiori
*
* @trick PERFORMANCE
**/
global $PHIRO_ADMIN_DIR;
$PHIRO_ADMIN_DIR = 'phiro-admin';

/**
* @since 0.170424
*
* @define @global @var $PHIRO_KERNEL_DIR
*
* Cartella KERNEL
* Phiro mappa la Definizione in una Variabile globale invece di usare il metodo define(). Consente di ottenere prestazioni maggiori
*
* @trick PERFORMANCE
**/
global $PHIRO_KERNEL_DIR;
$PHIRO_KERNEL_DIR = 'phiro-kernel';

/**
* @since 0.170528
*
* @define @global @var $MY_PHIRO_DIR
*
* Cartella MY / USER / DEVELOPER
* Phiro mappa la Definizione in una Variabile globale invece di usare il metodo define(). Consente di ottenere prestazioni maggiori
* E' la cartella utilizzata per creare il proprio progetto (Si può vedere come la cartella "/wp-themes/%MIO_TEMA%/" di WordPress)
*
* @trick PERFORMANCE
**/
global $MY_PHIRO_DIR;
$MY_PHIRO_DIR = 'my-phiro';

/**
* @since 0.170605
*
* @define @global @var $PHIRO_CACHE_DIR
*
* Cartella CACHE
* Phiro mappa la Definizione in una Variabile globale invece di usare il metodo define(). Consente di ottenere prestazioni maggiori
*
* @trick PERFORMANCE
**/
global $PHIRO_CACHE_DIR;
$PHIRO_CACHE_DIR = 'phiro-cache';

?>