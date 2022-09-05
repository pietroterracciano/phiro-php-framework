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
class TwoWay extends \Phiro\Lang\Object {

    /**
    * @since  0.170603
    **/
    const NO_TWO_WAY_CIPHERS_AVAILABLE__ERROR_ID = -1;
    const NO_TWO_WAY_CIPHERS_AVAILABLE__ERROR_MESSAGE = 'No Two Way Ciphers available';
    const TWO_WAY_CIPHER_NOT_SUPPORTED_BY_PHP__ERROR_ID = -2;
    const TWO_WAY_CIPHER_NOT_SUPPORTED_BY_PHP__ERROR_MESSAGE = 'Two Way Cipher not supported by PHP';
    const TWO_WAY_CIPHER_NOT_SUPPORTED_BY_PHIRO__ERROR_ID = -2;
    const TWO_WAY_CIPHER_NOT_SUPPORTED_BY_PHIRO__ERROR_MESSAGE = 'Two Way Cipher not supported by Phiro';
    const NO_TWO_WAY_CIPHER_ALGORITHMS_AVAILABLE__ERROR_ID = -3;
    const NO_TWO_WAY_CIPHER_ALGORITHMS_AVAILABLE__ERROR_MESSAGE = 'No Two Way Cipher Algorithms available';
    
    /**
    * @since  0.170603
    *
    * @define 
    *   @param $Driver                            : Driver utilizzato / Puntatore ad una Istanza di Phiro\Security\Ciphers\TwoWay\Drivers\%TIPO_DI_DRIVER%
    **/
    protected $Driver;

    /**
    * @see 
    *   @class Phiro\Security\Ciphers\TwoWay\Driver
    *       @definedIn \phiro-kernel\classes\security\ciphers\two-way-drivers\&Driver.php
    *   @class Phiro\Security\Ciphers\TwoWay\Driver
    *       @definedIn \phiro-kernel\classes\security\ciphers\two-way-drivers\MCrypt.php
    *   @class Phiro\Security\Ciphers\TwoWay\Driver
    *       @definedIn \phiro-kernel\classes\security\ciphers\two-way-drivers\OpenSSL.php
    *
    * @see
    *   @global @var $PHIRO__TWO_WAY_CIPHER__TYPE
    *       @definedIn \phiro-kernel\defines\config.php
    *           @pasteFrom @const PHIRO__TWO_WAY_CIPHER__TYPE 
    *               @definedIn \phiro-config.php
    *
    * @access public
    * @param $paramsOrAlgorithm             : Array di parametri OPPURE Algoritmo del Cipher
    * @param $type                          : Tipologia di Driver / Cipher (MCrypt, OpenSSL, ...)
    * @param $privateKey                    : Chiave privata del Cipher (Se vuota viene prelevata da phiro-config.php)
    * @param $publicKey                     : Chiave pubblica del Cipher (Se vuota viene generata in automatico)
    *
    * Istanzia un oggetto Two Way Cipher (Cipher che consente la decriptazione)
    **/
    final public function __construct($paramsOrAlgorithm = null, $type = '', $privateKey = '', $publicKey = '') {
        parent::__construct();

        if(is_array($paramsOrAlgorithm)) {
            $type = (!empty($paramsOrAlgorithm['type'])) ? $paramsOrAlgorithm['type'] : '';
            $algorithm = $paramsOrAlgorithm;
        }

        if(empty($type = trim($type))) {
            global $PHIRO__TWO_WAY_CIPHER__TYPE;
            $type = $PHIRO__TWO_WAY_CIPHER__TYPE;
        }

        global $PhiroServer;
        $availableTwoWayCiphers = $PhiroServer->getAvailableTwoWayCiphers();
        if( empty($availableTwoWayCiphers) || count($availableTwoWayCiphers) < 1) {
            $this->Driver = new TwoWay\Drivers\Unrecognized($algorithm, $privateKey, $publicKey);
            $this->Driver->setError(
                self::NO_TWO_WAY_CIPHERS_AVAILABLE__ERROR_ID,
                self::NO_TWO_WAY_CIPHERS_AVAILABLE__ERROR_MESSAGE
            );
        } else if(!$PhiroServer->isTwoWayCipherAvailable($type)) {
            $this->Driver = new TwoWay\Drivers\Unrecognized($algorithm, $privateKey, $publicKey);
            $this->Driver->setError(
                self::TWO_WAY_CIPHER_NOT_SUPPORTED_BY_PHP__ERROR_ID, 
                self::TWO_WAY_CIPHER_NOT_SUPPORTED_BY_PHP__ERROR_MESSAGE
            );
        } else {
            switch(strtolower($type)) {
                case 'mcrypt':
                    $this->Driver = new TwoWay\Drivers\MCrypt($algorithm, $privateKey, $publicKey);
                    break;
                case 'openssl': case 'open ssl':
                    $this->Driver = new TwoWay\Drivers\OpenSSL($algorithm, $privateKey, $publicKey);
                    break;
                case 'pseudo':
                    $this->Driver = new TwoWay\Drivers\Pseudo($algorithm, $privateKey, $publicKey);
                    break;
                default:
                    $this->Driver = new TwoWay\Drivers\Unrecognized($algorithm, $privateKey, $publicKey);
                    $this->Driver->setError(
                        self::TWO_WAY_CIPHER_NOT_SUPPORTED_BY_PHIRO__ERROR_ID,
                        self::TWO_WAY_CIPHER_NOT_SUPPORTED_BY_PHIRO__ERROR_MESSAGE
                    );
                    break;
            }
        }
        $this->error = &$this->Driver->error;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @access public
    * @return Numeric
    *
    * Restituisce l'Oggetto @param $object criptato (sotto forma di stringa / informazione criptata)
    * Utilizza il Driver scelto
	**/
    final public function encrypt($object = null) { return $this->Driver->cipherEncrypt($object); }

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @access public
    * @return Numeric
    *
    * Restituisce l'Oggetto iniziale dalla decriptazione di @param $cryptedData
    * Utilizza il Driver scelto
	**/
    final public function decrypt($cryptedData = '') { return $this->Driver->cipherDecrypt($cryptedData); }

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @access public
    * @return Numeric
    *
    * Restituisce "true" se il contenuto di @param $object è lo stesso di @param $cryptedData
    * Utilizza il Driver scelto
	**/
    final public function verify($object = null, $cryptedData = '') { return $this->Driver->verify($object, $cryptedData); }

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @access public
    * @return Numeric
    *
    * Restituisce la Chiave privata (solitamente definita in phiro-config.php)
    * Utilizza il Driver scelto
	**/
    final public function getPrivateKey() { return $this->Driver->getCipherPrivateKey(); }

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @access public
    * @return Numeric
    *
    * Restituisce la Chiave pubblica (solitamente generata casualmente. Si veda random_string() )
    * Utilizza il Driver scelto
	**/
    final public function getPublicKey() { return $this->Driver->getCipherPublicKey(); }

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @access public
    * @return Numeric
    *
    * Restituisce il Tempo di Criptazione
    * Utilizza il Driver scelto
	**/
    final public function getEncryptTime() { return $this->Driver->getCipherEncryptTime(); }

    /**
    * @author Pietro Terracciano
    * @since  0.170602
    *
    * @access public
    * @return Numeric
    *
    * Restituisce il Tempo di Decriptazione
    * Utilizza il Driver scelto
	**/
    final public function getDecryptTime() { return $this->Driver->getCipherDecryptTime(); }

    /**
    * @author Pietro Terracciano
    * @since  0.170602
    *
    * @access public
    * @return Numeric
    *
    * Estrapola la Chiave pubblica da una Informazione Criptata in precedenza
    * E' utile quando è necessaria una comunicazione protetta tra Client - Client o Client - Server (che utilizzano Phiro)
	**/
    final public static function _extrapolatePublicKey($cryptedData = '') { return TwoWay\Driver::_extrapolatePublicKey($cryptedData); }
    
} 

?>