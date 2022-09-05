<?php

/**
* @see @namespace Phiro\Cache\Drivers
**/
namespace Phiro\Cache\Drivers;


/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @see @class Phiro\Lang\Object
*   @definedIn \phiro-kernel\classes\lang\Object.php
**/
class File extends \Phiro\Cache\Driver {

    final public function __construct($paramsOrCachePoolName = null, $cacheCipherKey = '') {
        parent::__construct($paramsOrCachePoolName, $cacheCipherKey);

    }
    
    public function addToPool($fileName = '', $object = null) {
        if($this->isOnError() || empty($fileName) || !is_string($fileName) ) return false;
        $dirs = explode('\\', $this->cachePath.'\\'.$this->cachePoolName);
        $path = '';
        for($i = 0; $i < count($dirs); $i++) {
            if(!empty($dirs[$i])) {
                $path .= $dirs[$i];
                if(file_exists($path) && !is_readable($path)) echo "NO";
                else if( !file_exists($path) && !mkdir($path, 0777, true) ) echo "NO";
                $path .= '\\';
            }
        }

        echo md5_file($path.'\\'.$this->cacheCipher->encrypt($fileName).'.phiro');
        exit;
        $fp = fopen( $path.'\\'.$this->cacheCipher->encrypt($fileName).'.phiro', "w+");
        fwrite( $fp, $this->cacheCipher->encrypt($object) ) ;
        fclose($fp );

    }



}

?>