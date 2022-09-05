<?php

/**
* @see @namespace Phiro\Lang
**/
namespace Phiro\Lang;

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

use Phiro\Constants;
use Phiro\IO;

/**
* @see @class Phiro\Lang\Object
*   @defineIn \phiro-kernel\classes\lang\Object.php
**/
class Server extends Object {

    /**
    * @since  0.170424
    *
    * @define @consts ERRORS
    **/
    const UNRECOGNIZED__WEB_SERVER__ERROR_ID = -1;
    const UNRECOGNIZED__WEB_SERVER__ERROR_MESSAGE = 'Unrecognized WebServer';

    /**
    * @since  0.170422
    *
    * @define @consts FLAGS
    **/
    const UNRECOGNIZED__WEB_SERVER = 'Unrecognized';
    const UNRECOGNIZED__WEB_SERVER__TYPE = -1;

    const APACHE__WEB_SERVER__NAME = 'Apache';
    const APACHE__WEB_SERVER__TYPE = 1;

    const IIS__WEB_SERVER__NAME = 'IIS / Internet Information Services';
    const IIS__WEB_SERVER__TYPE = 2;

    /**
    * @since 0.170422
    *
    * @define
    *   @param $DNS                   : Domain Name System associato all'IP / Server
    *   @param $IP                    : IP del Server
    *   @param (int) $port            : Porta su cui è stata effettuata la connessione al Server
    *   @param $webServer             : Informazioni relative all'applicativo WebServer in esecuzione sul Server
    *   @param $PHP                   : Informazioni relative al linguaggio di scripting PHP in esecuzione sul Server
    *
    *
    * @since 0.170703
    *
    * @define
    *   @param $isHTTPsEnabled                      : "true" se è disponibile la connessione sicura
    *   @param $relativeWebPath                     : Web Path relativo allo Script corrente 
    *                                                 Permette di calcolare tutti i Path Web (URI remoti)
    *   @param $queryString                         : Query String dell'indirizzo @param $relativeWebPath
    *
    *
    * @since 0.170706
    * @define
    *   @param $relativeOSPath                      : OS Path relativo allo Script corrente 
    *                                                 Permette di calcolare tutti i Path OS (URI interni)
    *   @param $absoluteOSPath                      : OS Path assoluto allo Script corrente 
    *                                                 Permette di calcolare tutti i Path OS (URI interni)
    *
    * @since 0.170708
    * @define
    *   @param $isWebServerRewriteModuleEnabled     : "true" se il Modulo Rewrite del Web Server è attivo
    **/
    protected $isHTTPsEnabled;
    protected $isWebServerRewriteModuleEnabled;
    protected $DNS;
    protected $IP;
    protected $port;
    protected $relativeWebPath;
    protected $queryString;
    protected $relativeOSPath;
    protected $absoluteOSPath;
    protected $webServer;
    protected $PHP;

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @see 
    *   @global @array $_SERVER
    *   @function get_rel_os_path()
    *       @definedIn /phiro-kernel/functions/framework/.../get_rel_os_path.php
    *   @function get_abs_os_path()
    *       @definedIn /phiro-kernel/functions/framework/.../get_abs_os_path.php
    *
    * @access public
    *
    * Istanzia un oggetto Habitat. L'Habitat contiene tutte le informazioni relative al Server (nome del Web Server, versione del Web Server, DBMS disponibili, ...)
	**/
    final public function __construct() {
        parent::__construct();

        $this->isHTTPsEnabled = ( $_SERVER['SERVER_PORT'] == 443) ? true : false;
        $this->DNS = $_SERVER['SERVER_NAME'];
        $this->relativeWebPath = strtok(str_replace('\\', '/', $_SERVER['REQUEST_URI']), '?');
            /*( ( $relativeWebPathLength = string_length($relativeWebPath) > 1 ) && strings_compare($relativeWebPath[$relativeWebPathLength-1], '/') ) ? 
                substr($relativeWebPath, 0, -1) 
            : 
                $relativeWebPath;*/
        $this->queryString = $_SERVER['QUERY_STRING'];
        $this->relativeOSPath = get_relative_os_path();
        $this->absoluteOSPath = get_absolute_os_path();
        $this->IP = (!strings_compare_insensitive($this->DNS, 'localhost')) ? $_SERVER['REMOTE_ADDR'] : '127.0.0.1';
        $this->port = (int) $_SERVER['SERVER_PORT'];

        $this->webServer = array();
        foreach(
            array(
                array(
                    'name' => self::APACHE__WEB_SERVER__NAME,
                    'type' => self::APACHE__WEB_SERVER__TYPE,
                ),
                array(
                    'name' => self::IIS__WEB_SERVER__NAME,
                    'type' => self::IIS__WEB_SERVER__TYPE,
                )
            ) as $key => $array) {
            if( stripos( $_SERVER['SERVER_SOFTWARE'], $array['name'] ) !== false) {
              $this->webServer['name'] = $array['name'];
              $this->webServer['type'] = $array['type'];
              break;
            }
        }

        if( empty($this->webServer['name']) ) {
            $this->webServer['name'] = self::UNRECOGNIZED__WEB_SERVER;
            $this->webServer['type'] = self::UNRECOGNIZED__WEB_SERVER__TYPE;
            $this->setError(
                self::UNRECOGNIZED__WEB_SERVER__ERROR_ID,
                self::UNRECOGNIZED__WEB_SERVER__ERROR_MESSAGE
            );
        } else {
            /**
            * Utilizzando le Chiavi dell'Array al posto dei Valori dell'Array, potremmo effettuare 
            * una ricerca tramite tabella Hash con complessità computazione O(1)
            *
            * @trick PERFORMANCE
            **/
            $this->webServer['availableModules'] = ( $this->isApacheWebServer()  && function_exists("apache_get_modules") ) ? array_flip(apache_get_modules()) : array();    
        }
        
        $this->isWebServerRewriteModuleEnabled = 
            ( $this->isWebServerModuleAvailable('mod_rewrite') 
                || $this->isWebServerModuleAvailable('IIS_UrlRewriteModule') 
                || !empty($_SERVER['MOD_REWRITE']) 
                || !empty($_SERVER['REDIRECT_MOD_REWRITE']) ) ? true : false;
        if($this->isWebServerRewriteModuleEnabled()) {
            if($this->isApacheWebServer())
                $this->webServer['availableModules']['mod_rewrite'] = null;
            else if($this->isIISWebServer()) 
                $this->webServer['availableModules']['IIS_UrlRewriteModule'] = null;
        }

        $this->PHP = array();
        $this->PHP['version'] = PHP_VERSION;
        $this->PHP['versionID'] = PHP_VERSION_ID;
        /**
        * Utilizzando le Chiavi dell'Array al posto dei Valori dell'Array, potremmo effettuare 
        * una ricerca tramite tabella Hash con complessità computazione O(1)
        *
        * @trick PERFORMANCE
        **/
        $this->PHP['availableExtensions'] = (function_exists("get_loaded_extensions")) ? array_flip( array_map('strtolower', get_loaded_extensions()) ) : array(); /* @trick PERFORMANCE */
        $this->PHP['availableCiphers'] = array();
        $this->PHP['availableCiphers']['oneWay'] = array();
        $this->PHP['availableCiphers']['oneWay']['hashAlgorithms'] = (function_exists("hash_algos")) ? array_flip( array_map('strtoupper', hash_algos())) : array(); /* @trick PERFORMANCE */
        $this->PHP['availableCiphers']['oneWay']['hashAlgorithms']['PASSWORD'] = null;
        $this->PHP['availableCiphers']['twoWays'] = array();
        $this->PHP['availableCiphers']['twoWays']['pseudo'] = array();
        if($this->isPHPExtensionAvailable('mcrypt')) {
            $MCryptAlgorithms = array();
            if(function_exists("mcrypt_list_algorithms") && function_exists("mcrypt_list_modes"))
                foreach(mcrypt_list_algorithms() as $algorithm) {
                    foreach(mcrypt_list_modes() as $mode) 
                        $MCryptAlgorithms[] = strtoupper($algorithm.'-'.$mode);
                }
            $MCryptAlgorithms = array_flip($MCryptAlgorithms); /* @trick PERFORMANCE */
            $this->PHP['availableCiphers']['twoWays']['mcrypt'] = array(
                'algorithms' => $MCryptAlgorithms
            );
        }
        if($this->isPHPExtensionAvailable('openssl')) 
            $this->PHP['availableCiphers']['twoWays']['openssl'] = array(
                'version' => OPENSSL_VERSION_TEXT,
                'versionID' => OPENSSL_VERSION_NUMBER,
                'algorithms' => (function_exists("openssl_get_cipher_methods")) ? array_flip( array_map('strtoupper', openssl_get_cipher_methods()) ) : array() /* @trick PERFORMANCE */
            );
        
        $this->PHP['availableDBMS'] = array(); /* @trick PERFORMANCE */
        if($this->isPHPExtensionAvailable('mysql')) {
            $mySQLVersion = mysql_get_server_info();
            $this->PHP['availableDBMS']['mysql'] = $this->PHP['availableDBMS']['mariadb'] = array(
                'version' => $mySQLVersion,
                'versionID' => str_replace('.', '', $mySQLVersion)
            );
        }
        if($this->isPHPExtensionAvailable('mysqli')) {
            $this->PHP['availableDBMS']['mysqli'] = null;
            $this->PHP['availableDBMS']['mariadbi'] = null;
        }
        if($this->isPHPExtensionAvailable('mssql') )
            $this->PHP['availableDBMS']['mssql'] = null;
        if($this->isPHPExtensionAvailable('sqlsrv') )
            $this->PHP['availableDBMS']['sqlserver'] = null;
        if($this->isPHPExtensionAvailable('pdo')) {
            if($this->isPHPExtensionAvailable('pdo_mysql')) 
                $this->PHP['availableDBMS']['pdo_mysql'] = null;
        }
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170424
    *
    * @access public
    * @return String
    *
    * Restituisce il DNS associato all'IP / Server
	**/
    final public function getDNS() {
        return $this->DNS;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170424
    *
    * @access public
    * @return String
    *
    * Restituisce l'IP del Server
	**/
    final public function getIP() {
        return $this->IP;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170424
    *
    * @access public
    * @return Integer
    *
    * Restituisce la Porta su cui è stata effettuata la connessione al Server
	**/
    final public function getPort() {
        return $this->port;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170706
    *
    * @access public
    * @return String
    *
    * Restituisce il Web Path relativo dello Script corrente
	**/
    final public function getRelativeWebPath() {
        return $this->relativeWebPath;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170706
    *
    * @access public
    * @return String
    *
    * Restituisce il Web Path assoluto dello Script corrente
	**/
    final public function getAbsoluteWebPath() {
        return (!empty($this->absoluteWebPath)) ? $this->absoluteWebPath : ( $this->absoluteWebPath = $this->DNS.( (($this->port != 80)) ? ':'.$this->port : '').$this->relativeWebPath);
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170706
    *
    * @access public
    * @return String
    *
    * Restituisce l'URL Web relativo dello Script corrente
	**/
    final public function getRelativeWebURL() {
        return (!empty($this->relativeWebURL)) ? $this->relativeWebURL : ( $this->relativeWebURL = $this->getAbsoluteWebPath().((!empty($this->queryString)) ? '?'.$this->queryString : ''));
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170706
    *
    * @access public
    * @return String
    *
    * Restituisce l'URL Web assoluto dello Script corrente
	**/
    final public function getAbsoluteWebURL() {
        return ((!empty($this->absoluteWebURL)) ? $this->absoluteWebURL : ($this->absoluteWebURL = (($this->isHTTPsEnabled()) ? 'https://' : 'http://').$this->getRelativeWebURL()));
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170706
    *
    * @access public
    * @return String
    *
    * Restituisce il Path OS relativo dello Script corrente
	**/
    final public function getRelativeOSPath() {
        return $this->relativeOSPath;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170706
    *
    * @access public
    * @return String
    *
    * Restituisce il Path OS assoluto dello Script corrente
	**/
    final public function getAbsoluteOSPath() {
        return $this->absoluteOSPath;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170706
    *
    * @access public
    * @return String
    *
    * Restituisce l'URL OS relativo dello Script corrente
	**/
    /*final public function getRelativeOSURL() {
        return (!empty($this->relativeOSURL)) ? $this->relativeOSURL : ( $this->relativeOSURL = str_replace('\\', '/', $this->relativeOSPath));
    }*/

    /**
    * @author Pietro Terracciano
    * @since  0.170706
    *
    * @access public
    * @return String
    *
    * Restituisce l'URL OS assoluto dello Script corrente
	**/
    /*final public function getAbsoluteOSURL() {
        return (!empty($this->absoluteOSURL)) ? $this->absoluteOSURL : ( $this->absoluteOSURL = 'file:///'.str_replace('\\', '/', $this->absoluteOSPath));
    }*/

    /**
    * @author Pietro Terracciano
    * @since  0.170703
    *
    * @access public
    * @return String
    *
    * Restituisce la Query String dello Script corrente
	**/
    final public function getQueryString() {
        return $this->queryString;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170703
    *
    * @access public
    * @return Boolean
    *
    * Restituisce "true" se lo Script corrente gira su protocollo HTTPs, "false" altrimenti
	**/
    final public function isHTTPsEnabled() {
        return $this->isHTTPsEnabled;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170708
    *
    * @access public
    * @return Boolean
    *
    * Restituisce "true" se il Modulo Rewrite del WebServer corrente è attivo "false" altrimenti
	**/
    final public function isWebServerRewriteModuleEnabled() {
        return $this->isWebServerRewriteModuleEnabled;
    }
    
    /**
    * @author Pietro Terracciano
    * @since  0.170424
    *
    * @access public
    * @return StdClass Object
    *
    * Restituisce tutte le informazioni del WebServer
	**/
    final public function getWebServer() {
        return $this->webServer;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @access public
    * @return String
    *
    * Restituisce @param $webServer->name
	**/
    final public function getWebServerName() {
        return $this->webServer['name'];
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @access public
    * @return String
    *
    * Restituisce @param $webServer->version
	**/
    /*final public function getWebServerVersion() {
        return $this->webServer->version;
    }*/

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @access public
    * @return Integer
    *
    * Restituisce @param $webServer->type
    * Viene utilizzato per conoscere velocemente il tipo di WebServer
	**/
    final public function getWebServerType() {
        return $this->webServer['type'];
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170531
    *
    * @see @function array_key_exists()
    *
    * @access public
    * @param $name                     : Nome del Modulo
    * @return Boolean
    *
    * Restituisce "true" se il Modulo del WebServer @param $name è disponibile, "false" altrimenti
	**/
    final public function isWebServerModuleAvailable($name = '') {
        return (is_string($name)) ? array_key_exists($name, $this->webServer['availableModules']) : false;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @access public
    * @return Boolean
    *
    * Restituisce "true" se il WebServer è Apache, "false" altrimenti
	**/
    final public function isApacheWebServer() {
        return ($this->webServer['type'] == self::APACHE__WEB_SERVER__TYPE) ? true : false;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @access public
    * @return Boolean
    *
    * Restituisce "true" se il WebServer è IIS / Internet Information Services, "false" altrimenti
	**/
    final public function isIISWebServer() {
        return ($this->webServer['type'] == self::IIS__WEB_SERVER__TYPE) ? true : false;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170424
    *
    * @access public
    * @return Boolean
    *
    * Restituisce "true" se il WebServer è Sconosciuto, "false" altrimenti
	**/
    final public function isUnrecognizedWebServer() {
        return ($this->webServer['type'] == self::UNRECOGNIZED__WEB_SERVER__TYPE) ? true : false;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170708
    *
    * @access public
    * @return Array
    *
    * Restituisce un Array contenente tutte le informazioni PHP disponibili
	**/
    final public function getPHP() {
        return $this->PHP;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170531
    *
    * @access public
    * @return Array
    *
    * Restituisce un Array contenente tutte le estensioni PHP disponibili
	**/
    final public function getPHPAvailableExtensions() {
        return $this->PHP['availableExtensions'];
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170531
    *
    * @see @function array_key_exists()
    *
    * @access public
    * @param $name                     : Nome dell'Estensione PHP
    * @return Boolean
    *
    * Restituisce "true" se l'estensione PHP @param $name è disponibile, "false" altrimenti
	**/
    final public function isPHPExtensionAvailable($name = '') {
        return (is_string($name)) ? array_key_exists( strtolower(trim($name)), $this->PHP['availableExtensions']) : false;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @access public
    * @return Array
    *
    * Restituisce un Array contenente tutti i Ciphers disponibili (Estensioni PHP)
	**/
    final public function getAvailableCiphers() {
        return $this->PHP['availableCiphers'];
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @access public
    * @return Array
    *
    * Restituisce un Array contenente tutti gli Algoritmi Hash del Cipher One Way disponibili (Estensioni PHP)
	**/
    final public function getAvailableOneWayCipherHashAlgorithms() {
        return $this->PHP['availableCiphers']['oneWay']['hashAlgorithms'];
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @see @function in_array_insensitive()
    *   @definedIn \phiro-kernel\functions\...\in_array_insensitive.php
    *
    * @access public
    * @param $name                     : Nome dell'Algoritmo di Hash
    * @return Boolean
    *
    * Restituisce "true" se l'Algoritmo Hash del Cipher One Way è disponibile, "false" altrimenti
	**/
    final public function isOneWayCipherHashAlgorithmAvailable($name = '') {
        return (is_string($name)) ? array_key_exists( strtoupper(trim($name)), $this->PHP['availableCiphers']['oneWay']['hashAlgorithms'] ) : false;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @access public
    * @return Array
    *
    * Restituisce tutti i Ciphers Two Ways disponibili (Estensioni PHP)
	**/
    final public function getAvailableTwoWaysCiphers() {
        return $this->PHP['availableCiphers']['twoWays'];
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @see @function array_key_exists()
    *
    * @access public
    * @param $name                     : Nome del Cipher
    * @return Boolean
    *
    * Restituisce "true" se il Cipher Two Ways è disponibile, "false" altrimenti
	**/
    final public function isTwoWaysCipherAvailable($name = '') {
        return (is_string($name)) ? array_key_exists( strtolower(trim($name)), $this->PHP['availableCiphers']['twoWays'] ) : false;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @access public
    * @param $cipherName                     : Nome del Cipher Two Ways
    * @return Array
    *
    * Restituisce un Array contenente tutti gli Algoritmi del Cipher Two Ways disponibili
	**/
    final public function getAvailableTwoWaysCipherAlgorithms($cipherName = '') {
        if(!is_string($cipherName)) return array();
        $cipherName = strtolower(trim($cipherName));
        return ( $this->isTwoWaysCipherAvailable($cipherName) && isset($this->PHP['availableCiphers']['twoWays'][$cipherName]['algorithms']) ) ? 
            $this->PHP['availableCiphers']['twoWays'][$cipherName]['algorithms'] 
        : 
            array();
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @see @function array_key_exists()
    *
    * @access public
    * @param $cipherName                     : Nome del Cipher
    * @param $algoName                       : Nome dell'Algoritmo del Cipher
    * @return Boolean
    *
    * Restituisce "true" se l'Algoritmo del Cipher Two Ways è disponibile, "false" altrimenti
	**/
    final public function isTwoWaysCipherAlgorithmAvailable($cipherName = '', $algoName = '') {
        return ( is_string($algoName) && isset($this->getAvailableTwoWaysCipherAlgorithms($cipherName)[strtoupper(trim($algoName))]) ) ? true : false;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @access public
    * @return Array
    *
    * Restituisce un Array contenente tutti i DBMS disponibili (Estensioni PHP)
	**/
    final public function getAvailableDBMS() {
        return $this->PHP['availableDBMS'];
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @see @function array_key_exists()
    *
    * @access public
    * @param $name                     : Nome del DBMS
    * @return Boolean
    *
    * Restituisce "true" se il DBMS è disponibile, "false" altrimenti
	**/
    final public function isDBMSAvailable($name = '') {
        return (is_string($name)) ? array_key_exists( str_replace(array(' ', '+', '-'), '_', strtolower(trim($name))), $this->PHP['availableDBMS']) : false;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170602
    *
    * @access public
    * @return Array
    *
    * Restituisce un Array contenente tutti gli Algoritmi Hash disponibili (Estensioni PHP)
	**/
    final public function getAvailableHashAlgorithms() {
        return $this->PHP->availableHashAlgorithms;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170602
    *
    * @see @function array_key_exists()
    *
    * @access public
    * @param $name                     : Nome dell'Algoritmo Hash
    * @return Boolean
    *
    * Restituisce "true" se l'Algoritmo Hash è disponibile, "false" altrimenti
	**/
    final public function isHashAlgorithmAvailable($name = '') {
        return (is_string($name)) ? array_key_exists($name, $this->PHP->availableHashAlgorithms) : false;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170531
    *
    * @access public
    * @return Integer
    *
    * Restituisce @param $PHP->version
	**/
    final public function getPHPVersion() {
        return $this->PHP->version;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170531
    *
    * @access public
    * @return Integer
    *
    * Restituisce @param $PHP->versionID
	**/
    final public function getPHPVersionID() {
        return $this->PHP->versionID;
    }

}

?>