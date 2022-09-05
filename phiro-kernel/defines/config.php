<?php

/**
* @trick SECURITY
**/
if( empty($PHIRO_KERNEL_DIR) ) exit;

/**
* @since 0.170528
*
* @define 
*   @global @var $PHIRO_VERSION_ID
*   @global @var $PHIRO_VERSION
*
* Versione attuale di Phiro Framework
**/
global $PHIRO_VERSION_ID, $PHIRO_VERSION;
$PHIRO_VERSION_ID = 0170708;
$PHIRO_VERSION = '0.170708';

/**
* @since 0.170528
*
* @see @global @var $PHIRO_ABS_OS_PATH
*   @definedIn \phiro-kernel\defines\paths.php
*
* @define @global @var $PHIRO_CONFIGURED
*
* Contiene il valore "true" se Phiro è installato / configurato sul Server, "false" altrimenti
**/
global $PHIRO_CONFIGURED;
$PHIRO_CONFIGURED = ( file_exists( $PHIRO_ABS_OS_PATH.'\\phiro-config.php' ) ) ? true : false;

/**
* @since 0.170527
*
* @define @global @var $PHIRO_LANGUAGE
*   @copyFrom @const PHIRO_LANGUAGE
*       @definedIn \phiro-loader.php
*
* @see @function sanitize_string() OPPURE sanitizeString()
*   @definedIn \phiro-kernel\functions\strings\sanitize_string.php
* 
* Mappa la Definizione PHIRO_LANGUAGE, che contiene la lingua corrente del Framework, in $PHIRO_LANGUAGE
*
* Consente di ottenere prestazioni maggiori (in quanto le verifiche sulle definizioni sono più lente)
* @trick PERFORMANCE
**/
global $PHIRO_LANGUAGE;
$PHIRO_LANGUAGE = ( $PHIRO_CONFIGURED && defined('PHIRO_LANGUAGE') && !empty(PHIRO_LANGUAGE) ) ? PHIRO_LANGUANGE : 'IT';

/**
* @since 0.170528
*
* @define 
*   @global @var $PHIRO__ONE_WAY_CIPHER__SALT_KEY
*   @global @var $PHIRO__ONE_WAY_CIPHER__HASH_ALGORITHM
*
* Mappa la Definizione PHIRO__ONE_WAY_CIPHER__SALT_KEY, che contiene la Chiave SALT di default One Way Cipher, in $PHIRO__ONE_WAY_CIPHER__SALT_KEY
* Mappa la Definizione PHIRO__ONE_WAY_CIPHER__HASH_ALGORITHM, che contiene il l'Algoritmo Hash One Way Cipher utilizzato di default, in $PHIRO__ONE_WAY_CIPHER__HASH_ALGORITHM
*
* Consente di ottenere prestazioni maggiori (in quanto le verifiche sulle definizioni sono più lente)
* @trick PERFORMANCE
**/
global $PHIRO__ONE_WAY_CIPHER__SALT_KEY, $PHIRO__ONE_WAY_CIPHER__HASH_ALGORITHM;
$PHIRO__ONE_WAY_CIPHER__SALT_KEY = ( $PHIRO_CONFIGURED && defined('PHIRO__ONE_WAY_CIPHER__SALT_KEY') && !empty(PHIRO__ONE_WAY_CIPHER__SALT_KEY) ) ? PHIRO__ONE_WAY_CIPHER__SALT_KEY : '7g{?J°I£Ah§:0+(a2C?q!M#4£TJLrHUohJ£ASK&Jk]eZsy,KQCT8j}43,:^C4U=}';
$PHIRO__ONE_WAY_CIPHER__HASH_ALGORITHM = ( $PHIRO_CONFIGURED && defined('PHIRO__ONE_WAY_CIPHER__HASH_ALGORITHM') && !empty(PHIRO__ONE_WAY_CIPHER__HASH_ALGORITHM) ) ? PHIRO__ONE_WAY_CIPHER__HASH_ALGORITHM : 'sha512';


$PHIRO__ONE_WAY_CIPHER__SALT_KEY = $PHIRO__ONE_WAY_CIPHER__HASH_ALGORITHM = '';

/**
* @since 0.170603
*
* @define 
*   @global @var $PHIRO__TWO_WAY_CIPHER__ALGORITHM
*   @global @var $PHIRO__TWO_WAY_CIPHER__PRIVATE_KEY
*   @global @var $PHIRO__ONE_WAY_CIPHER__HASH_ALGORITHM
* 
* Mappa la Definizione PHIRO__TWO_WAY_CIPHER__ALGORITHM, che contiene l'Algoritmo utilizzato di default dai Two Way Ciphers, in $PHIRO__TWO_WAY_CIPHER__ALGORITHM
* Mappa la Definizione PHIRO__TWO_WAY_CIPHER__PRIVATE_KEY, che contiene la Chiave privata utilizzata di default dai Two Way Ciphers, in $PHIRO__TWO_WAY_CIPHER__PRIVATE_KEY
* Mappa la Definizione PHIRO__TWO_WAY_CIPHER__TYPE, che contiene il Tipo di Two Way Cipher utilizzato di default, in $PHIRO__TWO_WAY_CIPHER__TYPE
*
* Consente di ottenere prestazioni maggiori (in quanto le verifiche sulle definizioni sono più lente)
* @trick PERFORMANCE
**/
global $PHIRO__TWO_WAY_CIPHER__ALGORITHM, $PHIRO__TWO_WAY_CIPHER__PRIVATE_KEY, $PHIRO__TWO_WAY_CIPHER__TYPE;
$PHIRO__TWO_WAY_CIPHER__ALGORITHM = ( $PHIRO_CONFIGURED && defined('PHIRO__TWO_WAY_CIPHER__ALGORITHM') && !empty(PHIRO__TWO_WAY_CIPHER__ALGORITHM) ) ? PHIRO__TWO_WAY_CIPHER__ALGORITHM : '';
$PHIRO__TWO_WAY_CIPHER__PRIVATE_KEY = ( $PHIRO_CONFIGURED && defined('PHIRO__TWO_WAY_CIPHER__PRIVATE_KEY') && !empty(PHIRO__TWO_WAY_CIPHER__PRIVATE_KEY) ) ? PHIRO__TWO_WAY_CIPHER__PRIVATE_KEY : '';
$PHIRO__TWO_WAY_CIPHER__TYPE = ( $PHIRO_CONFIGURED && defined('PHIRO__TWO_WAY_CIPHER__TYPE') && !empty(PHIRO__TWO_WAY_CIPHER__TYPE) ) ? PHIRO__TWO_WAY_CIPHER__TYPE : 'OpenSSL';


/**
* @since 0.170603
*
* @define 
*   @global @var $PHIRO__CACHE__POOL_NAME
*   @global @var $PHIRO__CACHE__PATH
*   @global @var $PHIRO__CACHE__TYPE
*   @global @var $PHIRO__CACHE__CIPHER_KEY
* 
* Mappa la Definizione PHIRO__TWO_WAY_CIPHER__ALGORITHM, che contiene l'Algoritmo utilizzato di default dai Two Way Ciphers, in $PHIRO__TWO_WAY_CIPHER__ALGORITHM
* Mappa la Definizione PHIRO__TWO_WAY_CIPHER__PRIVATE_KEY, che contiene la Chiave privata utilizzata di default dai Two Way Ciphers, in $PHIRO__TWO_WAY_CIPHER__PRIVATE_KEY
* Mappa la Definizione PHIRO__TWO_WAY_CIPHER__TYPE, che contiene il Tipo di Two Way Cipher utilizzato di default, in $PHIRO__TWO_WAY_CIPHER__TYPE
*
* Consente di ottenere prestazioni maggiori (in quanto le verifiche sulle definizioni sono più lente)
* @trick PERFORMANCE
**/











global $PHIRO__CACHE__POOL_NAME, $PHIRO__CACHE__PATH, $PHIRO__CACHE__TYPE, $PHIRO__CACHE__CIPHER_PUBLIC_KEY;
$PHIRO__CACHE__PATH = ( $PHIRO_CONFIGURED && defined('PHIRO__CACHE__PATH') && !empty(PHIRO__CACHE__PATH) ) ? PHIRO__CACHE__PATH : $PHIRO_ABS_OS_PATH.'\\'.$PHIRO_CACHE_DIR;

$PHIRO__CACHE__CIPHER_KEY = 'provola';


$PHIRO__CACHE__POOL_NAME = '';


/* PHIRO_CIPHER_ONE_WAY_SALT_KEY
PHIRO_CIPHER_ONE_WAY_TYPE

PHIRO_CIPHER_TWO_WAY_PRIVATE_KEY
PHIRO_CIPHER_TWO_WAY_TYPE */
?>