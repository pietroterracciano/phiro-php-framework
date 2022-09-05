<?php

namespace Phiro\Cache;

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @see @class Phiro\Lang\Object
*   @definedIn \phiro-kernel\classes\lang\Object.php
**/
abstract class Driver extends \Phiro\Lang\Object {

    /**
    * @since 0.170605
    **/
    const CACHE_CIPHER_KEY_IS_EMPTY__ERROR_ID  = -1;
    const CACHE_CIPHER_KEY_IS_EMPTY__ERROR_MESSAGE = 'Cache Cipher Key is empty. Cache use a Cipher Key together Internal Private Key for create safe cache Data';
    const CACHE_PATH_IS_EMPTY__ERROR_ID  = -2;
    const CACHE_PATH_IS_EMPTY__ERROR_MESSAGE = 'Cache Path is empty';

    /**
    * @since  0.170602
    *
    * @define 
    *   @param $cachePoolName                   : Nome del Cache Pool
    *   @param $cacheType                       : Tipologia di Cache (Driver)
    *   @param $cacheCipherKey                  : Chiave del Cipher (Utilizzata per la criptazione delle informazioni della Cache)
    *   @param $cacheCipher
    **/
    protected $cacheType;
    protected $cachePoolName;
    protected $cachePath;
    protected $cacheCipherKey;
    protected $cacheCipher;

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @see 
    *   @function recursive_array_map()
    *       @definedIn \phiro-kernel\functions\...\recursive_array_map.php
    *
    * @access public
    * @param $paramsOrCachePoolName           : Array di Parametri OPPURE Nome del Cache Pool    
    *
    * Istanzia un oggetto Driver Cache
	**/
    public function __construct($paramsOrCachePoolName = null, $cacheCipherKey = '') {
        parent::__construct();

        if(is_array($paramsOrCachePoolName)) {
            $this->cachePoolName = ( !empty($paramsOrCachePoolName['cachePoolName'])) ? $paramsOrCachePoolName['cachePoolName'] : ( (!empty($paramsOrCachePoolName['poolName'])) ? $paramsOrCachePoolName['poolName'] : '');
            $this->cacheCipherKey = ( !empty($paramsOrCachePoolName['cacheCipherKey'])) ? $paramsOrCachePoolName['cacheCipherKey'] : ( (!empty($paramsOrCachePoolName['cipherKey'])) ? $paramsOrCachePoolName['cipherKey'] : '');
            $this->cachePath = ( !empty($paramsOrCachePoolName['cachePath'])) ? $paramsOrCachePoolName['cachePath'] : ( (!empty($paramsOrCachePoolName['path'])) ? $paramsOrCachePoolName['path'] : '');
        } else {
            $this->cachePoolName = $paramsOrCachePoolName;
            $this->cacheCipherKey = $cacheCipherKey;
        }

        $classExploded = explode('\\', $this->getClass());
        $this->cacheType = $classExploded[count($classExploded)-1];

        if( empty($this->cachePoolName = trim($this->cachePoolName)  ) ) {
            global $PHIRO__CACHE__POOL_NAME;
            $this->cachePoolName = $PHIRO__CACHE__POOL_NAME;
        }

        if( empty($this->cacheCipherKey = trim($this->cacheCipherKey)  ) ) {
            global $PHIRO__CACHE__CIPHER_KEY;
            $this->cacheCipherKey = $PHIRO__CACHE__CIPHER_KEY;
        }

        if( empty($this->cachePath = trim($this->cachePath)  ) ) {
            global $PHIRO__CACHE__PATH;
            $this->cachePath = $PHIRO__CACHE__PATH;
        }

        if( empty($this->cacheCipherKey) )
            $this->setError(
                self::CACHE_CIPHER_KEY_IS_EMPTY__ERROR_ID,
                self::CACHE_CIPHER_KEY_IS_EMPTY__ERROR_MESSAGE
            );
        else if( empty($this->cachePath))
            $this->setError(
                self::CACHE_PATH_IS_EMPTY__ERROR_ID,
                self::CACHE_PATH_IS_EMPTY__ERROR_MESSAGE
            );
        else {
            global $PhiroServer;
            $cipherType = ( $PhiroServer->isTwoWayCipherAvailable('OpenSSL') ) ? 'OpenSSL' : ( ( $PhiroServer->isTwoWayCipherAvailable('MCrypt') ) ? 'MCrypt' : '' );

            if( !empty($cipherType) ) {
                $cipherAlgorithms = $PhiroServer->getAvailableTwoWayCipherAlgorithms($cipherType);
                if( in_array_insensitive( 'RIJNDAEL-256-CBC', $cipherAlgorithms ) ) 
                    $cipherAlgorithm = 'RIJNDAEL-256-CBC';
                else if ( in_array_insensitive( 'AES-256-CBC', $cipherAlgorithms ) )
                    $cipherAlgorithm = 'AES-256-CBC';
                else if ( !empty($cipherAlgorithms[0]) )
                    $cipherAlgorithm = $cipherAlgorithms[0];
                else
                    $cipherAlgorithm = '';
                if( !empty( $cipherAlgorithm) )
                    $this->cacheCipher = new \Phiro\Security\Ciphers\TwoWay(
                        array(
                            'privateKey' => $this->cacheCipherKey,
                            'algorithm' => $cipherAlgorithm,
                            'type' => $cipherType,
                        )
                    );
            }

            /*
            if( !empty($this->cacheCipher) )
                $this->cacheCipher = new \Phiro\Security\Ciphers\TwoWay(
                    array(
                        'privateKey' => '{;isT!A{+6gb%)oRJ{]3j@!{t;:?§(An',
                        'publicKey' => random_string(64, 'WITH_SPECIAL_CHARS'),
                        'type' => 'Pseudo',
                    )
                );

            $crypted = $this->cacheCipher->encrypt('Effettua una criptazione di prova Bla bla bla bla bla');

            echo $crypted."\n\n";

            echo $this->cacheCipher->decrypt( $crypted );
            exit;
            */
            $this->error = &$this->cacheCipher->error;
        }
    }

    abstract public function addToPool();
} 

?>