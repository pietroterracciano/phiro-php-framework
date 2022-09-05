<?php

namespace Phiro\Lang;

if(!defined('Phiro\Constants\KERNEL_DIR')) exit;

use Phiro\Constants;
use Phiro\IO;

class Habitat {

    const EXCEPTION_TAG = 'CORE_ENV_CLASS';

    const APACHE_MIN_REQUIRED_VERSION = 2410;
    const PHP_MIN_REQUIRED_VERSION = 5515;

    private static $ApacheVersion;
    private static $OpenSSLVersion;
    private static $PHPVersion;

    /**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @see $_SERVER
    * @see preg_split()
    * @see preg_match()
    * @see Phiro\Lang\Exception
    *
    * @access public
    *
    * Verifica se Phiro è compatibile con le specifiche del Server. Se l'esito è positivo il caricamento del Framework continua, 
    * altrimenti è necessario correggere le incompatibilità riscontrate
	**/
    public static function _checkServerCompatibilities($SERVER = null) {
        if(empty($SERVER)) $SERVER = $_SERVER;

        self::$ApacheVersion = self::$PHPVersion = self::$OpenSSLVersion = null;
        $serverSoftware = preg_split('/\s+/', $_SERVER['SERVER_SOFTWARE']);
        if(!empty($serverSoftware) && is_array($serverSoftware)) {
            foreach($serverSoftware as $serverSoftwareMeta) {
                preg_match('/Apache\/([0-9.]*)/i', $serverSoftwareMeta, $version);
                if(!empty($version) && is_array($version)) self::$ApacheVersion = (int) str_replace('.', '', $version[1]);
                preg_match('/OpenSSL\/([0-9.]*)/i', $serverSoftwareMeta, $version);
                if(!empty($version) && is_array($version)) self::$OpenSSLVersion = (int) str_replace('.', '', $version[1]);
                preg_match('/PHP\/([0-9.]*)/i', $serverSoftwareMeta, $version);
                if(!empty($version) && is_array($version)) self::$PHPVersion = (int) str_replace('.', '', $version[1]);
            }
        }

        if(empty(self::$ApacheVersion))
            new Exception('Apache WebServer not running', 'Please check Apache Services', self::EXCEPTION_TAG, Exception::FAST_LAUNCH, Exception::LAUNCH_AS_HTML);
        if(self::$ApacheVersion < self::APACHE_MIN_REQUIRED_VERSION)
            new Exception('Apache WebServer is not up to date ', 'Your version: <b>'.self::$ApacheVersion.'</b><br />Minimum required version: <b>'.self::APACHE_MIN_REQUIRED_VERSION.'</b><br /><br />Please update', self::EXCEPTION_TAG, Exception::FAST_LAUNCH, Exception::LAUNCH_AS_HTML);
        if(!self::_isApacheModuleLoaded('mod_rewrite')) 
            new Exception('Apache Module "mod_rewrite" not running', 'Please active Apache Module', self::EXCEPTION_TAG, Exception::FAST_LAUNCH, Exception::LAUNCH_AS_HTML);
        if(self::$PHPVersion < self::PHP_MIN_REQUIRED_VERSION)
            new Exception('PHP Module is not up to date ', 'Your version: <b>'.self::$PHPVersion.'</b><br />Minimum required version: <b>'.self::PHP_MIN_REQUIRED_VERSION.'</b><br /><br />Please update', self::EXCEPTION_TAG, Exception::FAST_LAUNCH, Exception::LAUNCH_AS_HTML);
    }

    /**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @see apache_get_modules()
    *
    * @access public
    * @return Boolean                       : Restituisce "true" se il $moduleName di Apache è attivo, "false" altrimenti
	**/
    private static function _isApacheModuleLoaded($moduleName = null) {
        if(empty($moduleName)) return false;
        $modules = apache_get_modules();
        if(!empty($modules) && is_array($modules)) return in_array($moduleName, $modules);
        return false;
    }

    /**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @access public
    * @return Attributo
	**/
    public static function _getApacheVersion() {
        return $this->ApacheVersion;
    }

    /**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @access public
    * @return Attributo
	**/
    public static function _getOpenSSLVersion() {
        return $this->OpenSSLVersion;
    }

    /**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @access public
    * @return Attributo
	**/
    public static function _getPHPVersion() {
        return $this->PHPVersion;
    }

    /**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @see Phiro\IO\File
    * @see Phiro\Constants
    *
    * @access public
    *
    * Carica i file che compongono il namespace Phiro\Constants
	**/
    /* public static function _loadConstants() {
        $files = IO\File::_getFromDirectories(Constants\KERNEL_DIR.'/classes/constants/*', 'php');
        if(!empty($files)) { foreach($files as $file) require_once($file);  }
    } */

    /**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @see Phiro\IO\File
    * @see Phiro\Constants
    *
    * @access public
    *
    * Carica i file che compongono il namespace Phiro\Core
	**/
    /* public static function _loadLang() {
        $files = IO\File::_getFromDirectories(Constants\KERNEL_DIR.'/classes/lang/*', 'php');
        if(!empty($files)) { foreach($files as $file) require_once($file);  }
    }*/

    /**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @see Phiro\IO\File
    * @see Phiro\Constants
    *
    * @access public
    *
    * Carica i file che compongono il namespace Phiro\IO (Input Output)
	**/
    /* public static function _loadIo() {
        $files = IO\File::_getFromDirectories(Constants\KERNEL_DIR.'/classes/io/*', 'php');
        if(!empty($files)) { foreach($files as $file) require_once($file);  }
    }*/

    /**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @see Phiro\IO\File
    * @see Phiro\Constants
    *
    * @access public
    *
    * Carica i file che compongono il namespace Phiro\UI (User Interface)
	**/
    /* public static function _loadUi() {
        $files = IO\File::_getFromDirectories(Constants\KERNEL_DIR.'/classes/ui/widgets/*', 'php');
        if(!empty($files)) { foreach($files as $file) require_once($file);  }
        $files = IO\File::_getFromDirectories(Constants\KERNEL_DIR.'/classes/ui/partials/*', 'php');
        if(!empty($files)) { foreach($files as $file) require_once($file);  }
    }*/

    /**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @see Phiro\IO\File
    * @see Phiro\Constants
    *
    * @access public
    *
    * Carica i file che compongono il namespace Phiro\Utils (Utilities)
	**/
    /* public static function _loadUtils() {
        $files = Io\File::_getFromDirectories(Constants\KERNEL_DIR.'/classes/utils/*', 'php');
        if(!empty($files)) { foreach($files as $file) require_once($file);  }
    } */


}

?>