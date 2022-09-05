<?php

namespace Phiro\Security\Ciphers\TwoWay;

/**
* @trick SECURITY
**/ 
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @see @class Phiro\Lang\Object
*   @defineIn \phiro-kernel\classes\lang\Object.php
**/
abstract class Driver extends \Phiro\Lang\Object {

    /**
    * @since  0.170603
    **/
    const CIPHER_PRIVATE_KEY_IS_EMPTY__ERROR_ID = -1;
    const CIPHER_PRIVATE_KEY_IS_EMPTY__ERROR_MESSAGE = 'Cipher Private Key is empty';
    const CIPHER_ALGORITHM_IS_EMPTY__ERROR_ID = -2;
    const CIPHER_ALGORITHM_IS_EMPTY__ERROR_MESSAGE = 'Cipher Algorithm is empty';
    const CIPHER_ALGORITHM_NOT_SUPPORTED_BY_PHP__ERROR_ID = -3;
    const CIPHER_ALGORITHM_NOT_SUPPORTED_BY_PHP__ERROR_MESSAGE = 'Cipher Algorithm not supported by PHP';
    const CIPHER_KEYS_LENGTH_IS_NOT_VALID__ERROR_ID = -4;
    const CIPHER_KEYS_LENGTH_IS_NOT_VALID__ERROR_MESSAGE = 'Cipher Keys Length is not valid';
    const IMPOSSIBLE_TO_DECRYPT_STRING__ERROR_ID = -5;
    const IMPOSSIBLE_TO_DECRYPT_STRING__ERROR_MESSAGE = 'Impossible to Decrypt String. Please verify if the algorithms used are the same OR verify if the Public Keys used are the same. Remember that a String is crypted by an unique Public Key. You can use Phiro\Security\Ciphers\TwoWay::_extrapolatePublicKey($cryptedData) to get the String Public Key';

    /**
    * @since 0.170614
    **/
    const MAX_CIPHER_KEYS_LENGTH = 1024; // 1024 caratteri ovvero 1KB di chiave!!! Solo numeri pari (32, 64, 128, 256, 512, 1024, 2048, 4096)

    /**
    * @since  0.170603
    * @define 
    *   @param $cipherType                             : Tipologia di Cipher
    *   @param $cipherAlgorithm                        : Algoritmo di criptazione/decriptazione utilizzato dal Cipher
    *   @param $cipherMode                             : Modalità di esecuzione dell'Algoritmo di criptazione/decriptazione da parte del Cipher (Solitamente è utilizzato da MCrypt)
    *   @param $cipherKeysLength                       : Lunghezza delle Chiavi calcolata in automatico a seconda dell'Algoritmo utilizzato
    *   @param $cipherPrivateKey                       : Chiave privata del Cipher
    *   @param $cipherPublicKey                        : Chiave pubblica del Cipher
    *   @param $cipherEncryptTime                      : Tempo di criptazione del Cipher
    *   @param $cipherDecryptTime                      : Tempo di decriptazione del Cipher
    **/
    protected $cipherType;
    protected $cipherAlgorithm;
    protected $cipherMode;
    protected $cipherKeysLength;
    protected $cipherPrivateKey;
    protected $cipherPublicKey;
    protected $cipherEncryptTime;
    protected $cipherDecryptTime;

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @see 
    *   @function strings_compare()
    *       @definedIn \phiro-kernel\functions\...\strings_compare.php
    *
    * @access public
    * @param $paramsOrCipherAlgorithm                     : Array di Parametri OPPURE Algoritmo di criptazione/decriptazione utilizzato dal Cipher
    * @param $cipherPrivateKey                            : Chiave private del Cipher
    * @param $cipherPublicKey                             : Chiave pubblica del Cipher / Se vuota viene generata in automatico   
    *
    * Istanzia un oggetto Driver Two Way Cipher
	**/
    final public function __construct($paramsOrCipherAlgorithm = '', $cipherPrivateKey = '', $cipherPublicKey = '') {
        parent::__construct();

        if(is_array($paramsOrCipherAlgorithm)) {
            $this->cipherAlgorithm = ( !empty($paramsOrCipherAlgorithm['cipherAlgorithm'])) ? $paramsOrCipherAlgorithm['cipherAlgorithm'] : ( (!empty($paramsOrCipherAlgorithm['algorithm'])) ? $paramsOrCipherAlgorithm['algorithm'] : '');
            $this->cipherPrivateKey = ( !empty($paramsOrCipherAlgorithm['cipherPrivateKey'])) ? $paramsOrCipherAlgorithm['cipherPrivateKey'] : ( (!empty($paramsOrCipherAlgorithm['privateKey'])) ? $paramsOrCipherAlgorithm['privateKey'] : '');
            $this->cipherPublicKey = ( !empty($paramsOrCipherAlgorithm['cipherPublicKey'])) ? $paramsOrCipherAlgorithm['cipherPublicKey'] : ( (!empty($paramsOrCipherAlgorithm['publicKey'])) ? $paramsOrCipherAlgorithm['publicKey'] : '');
        } else {
            $this->cipherAlgorithm =  $paramsOrCipherAlgorithm;
            $this->cipherPrivateKey = $cipherPrivateKey;
            $this->cipherPublicKey = $cipherPublicKey;
        }

        $classExploded = explode('\\', $this->getClass());
        $this->cipherType = $classExploded[count($classExploded)-1];

        if(!strings_compare($this->cipherType, 'Unrecognized')) {
            if(empty($this->cipherPrivateKey = trim($this->cipherPrivateKey))) {
                global $PHIRO__TWO_WAY_CIPHER__PRIVATE_KEY;
                $this->cipherPrivateKey = $PHIRO__TWO_WAY_CIPHER__PRIVATE_KEY;
            }

            if(empty($this->cipherAlgorithm = trim($this->cipherAlgorithm))) {
                global $PHIRO__TWO_WAY_CIPHER__ALGORITHM;
                $this->cipherAlgorithm = $PHIRO__TWO_WAY_CIPHER__ALGORITHM;
            }

            /**
            * Utilizzando una funzione al posto di una Eccezione (Exception Object) avremo un minore consumo di risorse e overhead
            *
            * @trick PERFORMANCE
            **/
            global $PhiroServer;
            if( empty($this->cipherPrivateKey) ) 
                $this->setError(
                    self::CIPHER_PRIVATE_KEY_IS_EMPTY__ERROR_ID, 
                    self::CIPHER_PRIVATE_KEY_IS_EMPTY__ERROR_MESSAGE
                );
            else if(!strings_compare($this->cipherType, 'Pseudo') ){
                if( empty($this->cipherAlgorithm) ) 
                    $this->setError(
                        self::CIPHER_ALGORITHM_IS_EMPTY__ERROR_ID, 
                        self::CIPHER_ALGORITHM_IS_EMPTY__ERROR_MESSAGE
                    );
                else if ( !$PhiroServer->isTwoWayCipherAlgorithmAvailable($this->cipherType, $this->cipherAlgorithm) )
                    $this->setError(
                        self::CIPHER_ALGORITHM_NOT_SUPPORTED_BY_PHP__ERROR_ID, 
                        self::CIPHER_ALGORITHM_NOT_SUPPORTED_BY_PHP__ERROR_MESSAGE
                    );
            } else {
                unset($this->cipherAlgorithm);
                unset($this->cipherMode);
            }
            $this->checkCipherKeys();
        }
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @access public
    * @return Boolean
    *
    * Funzione da richiamare PRIMA del Check delle Keys. Restituisce "true" se il Check delle Keys può continuare, "false" altrimenti
	**/
    final protected function beforeCheckCipherKeys() {
        return !$this->isOnError();
    }

    protected abstract function checkCipherKeys();

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @see
    *   @function is_even_number()
    *       @definedIn \phiro-kernel\functions\...\is_even_number.php
    *
    * @access public
    *
    * Funzione da richiamare DOPO il Check delle Keys. Rende le Chiavi compatibili con l'Algoritmo di criptazione scelto
    * Se le Chiavi sono minori del @param $cipherKeysLength allora vengono aggiunti dei caratteri vuoti (Padding)
	**/
    final protected function afterCheckCipherKeys() {
        if($this->cipherKeysLength > 0) {
            if($this->cipherKeysLength > self::MAX_CIPHER_KEYS_LENGTH) $this->cipherKeysLength = self::MAX_CIPHER_KEYS_LENGTH;
            if( !is_even_number($this->cipherKeysLength) ) $this->cipherKeysLength++;

            for($i=0; $i < $this->cipherKeysLength; $i++) {
                 if( !isset($this->cipherPrivateKey[$i]) ) $this->cipherPrivateKey[$i] = ' ';
            }
            $this->cipherPrivateKey = substr($this->cipherPrivateKey, 0, $this->cipherKeysLength);

            if(!empty($this->cipherPublicKey)) {
                for($i=0; $i < $this->cipherKeysLength; $i++) {
                    if( !isset($this->cipherPublicKey[$i]) ) $this->cipherPublicKey[$i] = ' ';
                }
                $this->cipherPublicKey = substr($this->cipherPublicKey, 0, $this->cipherKeysLength); 
            } else $this->cipherPublicKey = random_string($this->cipherKeysLength, 'WITH_SPECIAL_CHARS');
            
        } else {
            $this->setError(
                self::CIPHER_KEYS_LENGTH_IS_NOT_VALID__ERROR_ID,
                self::CIPHER_KEYS_LENGTH_IS_NOT_VALID__ERROR_MESSAGE
            );
        }
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @see 
    *   @function serialize()
    *
    * @access public
    * @return String
    *
    * Funzione da richiamare PRIMA della Criptazione
    * Converte qualsiasi Oggetto PHP (Array, Object, String, Integer, ...) in una Stringa
	**/
    final protected function beforeCipherEncrypt($object = null) {
        $this->cipherEncryptTime = microtime(true);
        return @serialize( $object ); // Può essere vuoto
    }

    public abstract function cipherEncrypt();

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @see 
    *   @function number_module()
    *       @definedIn \phiro-kernel\functions\...\number_module.php
    *   @function base64_encode()
    *
    * @access public
    * @param $cryptedData                  : Informazioni criptate
    * @return String
    *
    * Funzione da richiamare DOPO la Criptazione
    * Aggiunge alla Stringa criptata la Chiave pubblica, la lunghezza della Chiave pubblica e converte il tutto in base64 
    * (Queste informazioni servono per una possibile Decriptazione)
	**/
    final protected function afterCipherEncrypt($cryptedData = '') {
        $this->cipherEncryptTime = number_module( microtime(true) - $this->cipherEncryptTime );
        return @base64_encode(
            substr($this->cipherPublicKey, 0, $this->cipherKeysLength / 2).$cryptedData.substr($this->cipherPublicKey, $this->cipherKeysLength / 2).
            (( strlen($this->cipherKeysLength) > 1) ? $this->cipherKeysLength : '0'.$this->cipherKeysLength)
        );
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @see 
    *   @function base64_decode()
    *
    * @access public
    * @return String
    *
    * Funzione da richiamare PRIMA della Decriptazione
    * Estrapola le informazioni contenute in @param $cryptedData
    * (Queste informazioni servono per la Decriptazione)
	**/
    final protected function beforeCipherDecrypt($cryptedData = '') {
        $this->cipherDecryptTime = microtime(true);
        return substr( 
            $cryptedData = @base64_decode($cryptedData),
            ($this->cipherKeysLength / 2), 
            - ( ($this->cipherKeysLength / 2 + 2) ) 
        );
    }

    public abstract function cipherDecrypt();

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @see 
    *   @function number_module()
    *       @definedIn \phiro-kernel\functions\...\number_module.php
    *   @function unserialize()
    *
    * @access public
    * @return String
    *
    * Funzione da richiamare DOPO la Decriptazione
    * Restituisce l'Oggetto iniziale
	**/
    final protected function afterCipherDecrypt($object = null) {
        $object = @unserialize($object);
        if(!empty($object)) {
            $this->cipherDecryptTime = number_module( microtime(true) - $this->cipherDecryptTime );
            return $object;
        }
        $this->setError(
            self::IMPOSSIBLE_TO_DECRYPT_STRING__ERROR_ID,
            self::IMPOSSIBLE_TO_DECRYPT_STRING__ERROR_MESSAGE
        );
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @access public
    * @return Integer
    *
    * Restituisce la Lunghezza delle Chiavi del Cipher
	**/
    final public function getCipherKeysLength() {
        return (int) $this->cipherKeysLength;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @access public
    * @return String
    *
    * Restituisce la Chiave privata del Cipher
	**/
    final public function getCipherPrivateKey() {
        return $this->cipherPrivateKey;
    }
    
    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @access public
    * @return String
    *
    * Restituisce la Chiave pubblica del Cipher
	**/
    final public function getCipherPublicKey() {
        return $this->cipherPublicKey;
    }
    
    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @access public
    * @return Float
    *
    * Restituisce il Tempo di Criptazione del Cipher
	**/
    final public function getCipherEncryptTime() {
        return (float) $this->cipherEncryptTime;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @access public
    * @return Float
    *
    * Restituisce il Tempo di Decriptazione del Cipher
	**/
    final public function getCipherDecryptTime() {
        return (float) $this->cipherDecryptTime;
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
        return ( !$this->isOnError() && strings_compare( $this->cipherEncrypt($object), $cryptedData ) ) ? true : false;
    } 

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @access public
    * @param                                 : Informazioni criptate
    * @return String
    *
    * Estrapola la Chiave pubblica a partire da una Informazione criptata (Stringa criptata)
	**/
    final public static function _extrapolatePublicKey($cryptedData = '') {
        $cryptedData = @base64_decode($cryptedData);
        $publicKeyLength = (int) substr($cryptedData, strlen($cryptedData) - 2);
        if(strlen($cryptedData) > $publicKeyLength)
            return substr($cryptedData, 0, $publicKeyLength / 2).substr($cryptedData, - ($publicKeyLength / 2 + 2), $publicKeyLength / 2) ;
        return 'Impossible to Extrapolate Public Key';
    }

} 

?>