<?php

namespace Phiro\Security\Ciphers;

/**
* @trick SECURITY
**/ 
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @see @class Phiro\Lang\Object
*   @defineIn \phiro-kernel\classes\lang\Object.php
**/
class OneWay extends \Phiro\Lang\Object {

    /**
    * @since  0.170602
    **/
    const NO_ONE_WAY_CIPHER_HASH_ALGORITHMS_AVAILABLE__ERROR_ID = -1;
    const NO_ONE_WAY_CIPHER_HASH_ALGORITHMS_AVAILABLE__ERROR_MESSAGE = 'No One Way Cipher Hash Algorithms available';
    const ONE_WAY_CIPHER_HASH_ALGORITHM_IS_EMPTY__ERROR_ID = -2;
    const ONE_WAY_CIPHER_HASH_ALGORITHM_IS_EMPTY__ERROR_MESSAGE = 'One Way Hash Algorithm is empty';
    const ONE_WAY_CIPHER_HASH_ALGORITHM_NOT_SUPPORTED_BY_PHP__ERROR_ID = -3;
    const ONE_WAY_CIPHER_HASH_ALGORITHM_NOT_SUPPORTED_BY_PHP__ERROR_MESSAGE = 'One Way Cipher Hash Algorithm not supported by PHP';
    const ONE_WAY_CIPHER_SALT_KEY_IS_EMPTY__ERROR_ID = -3;
    const ONE_WAY_CIPHER_SALT_KEY_IS_EMPTY__ERROR_MESSAGE = 'One Way Cipher SALT Key is empty';

    /**
    * @since  0.170602
    * @define
    *   @param $hashAlgorithm             : Algoritmo Hash da utilizzare (Tipologia di Cipher)
    *   @param $SALTKey                   : Chiave SALT del Cipher
    *   @param $SALTKeyLength             : Lunghezza della Chiave SALT del Cipher (usata come cache)
    *   @param $encryptTime               : Tempo di Criptazione
    **/
    protected $hashAlgorithm;
    protected $SALTKey;
    protected $SALTKeyLength;
    protected $encryptTime;

    /**
    * @author Pietro Terracciano
    * @since  0.170602
    *
    * @see
    *   @global @var $PHIRO__ONE_WAY_CIPHER__HASH_ALGORITHM
    *       @definedIn \phiro-kernel\defines\config.php
    *           @pasteFrom @const PHIRO__ONE_WAY_CIPHER__HASH_ALGORITHM 
    *               @definedIn \phiro-config.php
    *   @global @var $PHIRO__ONE_WAY_CIPHER__SALT_KEY
    *       @definedIn \phiro-kernel\defines\config.php
    *           @pasteFrom @const PHIRO__ONE_WAY_CIPHER__SALT_KEY 
    *               @definedIn \phiro-config.php
    *   @function is_even_number()
    *       @definedIn \phiro-kernel\functions\...\is_even_number.php
    *   @function string_length()
    *       @definedIn \phiro-kernel\functions\...\string_length.php
    *
    * @access public
    * @param $paramsOrHashAlgorithm         : Array di parametri OPPURE tipologia di Algoritmo di Hash
    * @param $SALTKey                       : SALT Key
    *
    * Istanzia un oggetto One Way Cipher (Cipher che non consente la decriptazione)
	**/
    final public function __construct($paramsOrHashAlgorithm = null, $SALTKey = '') {
        parent::__construct();

        if(is_array($paramsOrHashAlgorithm)) {
            foreach($paramsOrHashAlgorithm as $key => $value) $this->{$key} = $value;
        } else {
            $this->hashAlgorithm = $paramsOrHashAlgorithm;
            $this->SALTKey = $SALTKey;
        }

        $this->hashAlgorithm = trim($this->hashAlgorithm);

        if(empty($this->hashAlgorithm)) {
            global $PHIRO__ONE_WAY_CIPHER__HASH_ALGORITHM;
            $this->hashAlgorithm = $PHIRO__ONE_WAY_CIPHER__HASH_ALGORITHM;
        }

        if(empty($this->SALTKey)) {
            global $PHIRO__ONE_WAY_CIPHER__SALT_KEY;
            $this->SALTKey = $PHIRO__ONE_WAY_CIPHER__SALT_KEY;
        }

        global $PhiroServer;
        $availableHashAlgorithms = $PhiroServer->getAvailableOneWayCipherHashAlgorithms();
        if( empty($availableHashAlgorithms) || count($availableHashAlgorithms) < 1) 
            $this->setError(
                self::NO_ONE_WAY_CIPHER_HASH_ALGORITHMS_AVAILABLE__ERROR_ID,
                self::NO_ONE_WAY_CIPHER_HASH_ALGORITHMS_AVAILABLE__ERROR_MESSAGE
            );
        else if( empty($this->hashAlgorithm) )
            $this->setError(
                self::ONE_WAY_CIPHER_HASH_ALGORITHM_IS_EMPTY__ERROR_ID,
                self::ONE_WAY_CIPHER_HASH_ALGORITHM_IS_EMPTY__ERROR_MESSAGE
            );
        else if(!$PhiroServer->isOneWayCipherHashAlgorithmAvailable($this->hashAlgorithm))
            $this->setError(
                self::ONE_WAY_CIPHER_HASH_ALGORITHM_NOT_SUPPORTED_BY_PHP__ERROR_ID,
                self::ONE_WAY_CIPHER_HASH_ALGORITHM_NOT_SUPPORTED_BY_PHP__ERROR_MESSAGE
            );
        else if( empty($this->SALTKey) ) 
            $this->setError(
                self::ONE_WAY_CIPHER_SALT_KEY_IS_EMPTY__ERROR_ID, 
                self::ONE_WAY_CIPHER_SALT_KEY_IS_EMPTY__ERROR_MESSAGE
            );
        else if( !is_even_number($this->SALTKeyLength = string_length($this->SALTKey)) )  {
                $this->SALTKey .= ' ';
                $this->SALTKeyLength++;
        }
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170602
    *
    * @see
    *   @function serialize()
    *   @function base64_encode()
    *
    * @access public
    * @param $object                       : Oggetto / Informazioni da Criptare
    * @return String
    *
    * Funzione da richiamare PRIMA della Criptazione
    * Converte qualsiasi Oggetto PHP (Array, Object, String, Integer, ...) in una Stringa
    * e successivamente aggiunge la Chiave SALT
	**/
    final private function beforeEncrypt($object = null) {
        do_action('Phiro\Security\Ciphers\OneWay->beforeEncrypt()', @serialize($object) );
        return sha1(substr($this->SALTKey, 0, $this->SALTKeyLength / 2).@serialize($object).substr($this->SALTKey, $this->SALTKeyLength / 2));
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170602
    *
    * @see
    *   @function openssl_digest()
    *   @function password_hash()
    *
    * @access public
    * @param $object                       : Oggetto / Informazioni da Criptare
    * @return String
    *
    * Restituisce l'Oggetto criptato (sotto forma di Stringa)
	**/
    final public function encrypt($object = null) {
        if($this->isOnError()) return '';
        
        $this->encryptTime = microtime(true);

        $object = $this->beforeEncrypt($object);

        if(!strings_compare_insensitive($this->hashAlgorithm, 'password')) {
            global $PhiroServer;
            if($PhiroServer->isExtensionAvailable('openssl'))
                $object = @openssl_digest($object, strtolower($this->hashAlgorithm));
            else 
                $object = @hash(strtolower($this->hashAlgorithm), $object);
        } else 
            $object = @password_hash($object, PASSWORD_DEFAULT);

        $this->encryptTime = number_module( microtime(true) - $this->encryptTime );

        return @base64_encode($object);
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170602
    *
    * @access public
    * @param $object                       : Oggetto / Informazioni
    * @param $cryptedData                  : Informazioni criptate
    * @return Boolean
    *
    * Restituisce "true" se il contenuto di @param $object è lo stesso di @param $cryptedData
	**/
    final public function verify($object = null, $cryptedData = '') {
        if($this->isOnError()) return false;
        if(!strings_compare_insensitive($this->hashAlgorithm, 'password'))
            return ( strings_compare($this->encrypt($object), $cryptedData) ) ? true : false;
        else
            return ( password_verify( $this->beforeEncrypt($object) , @base64_decode($cryptedData)) ) ? true : false;
    } 

    /**
    * @author Pietro Terracciano
    * @since  0.170602
    *
    * @access public
    * @return Float Numeric
    *
    * Restituisce il Tempo di Criptazione
	**/
    final public function getEncryptTime() { return (float) $this->encryptTime; }
    final public function getTime() { return $this->getEncryptTime(); }

    /**
    * @author Pietro Terracciano
    * @since  0.170604
    *
    * @access public
    * @return String
    *
    * Restituisce la Chiave SALT
	**/
    final public function getSALTKey() { return $this->SALTKey; }

} 

?>