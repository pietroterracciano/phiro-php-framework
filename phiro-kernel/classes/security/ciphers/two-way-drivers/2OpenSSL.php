<?php

namespace Phiro\Security\Ciphers\TwoWay\Drivers;

/**
* @trick SECURITY
**/ 
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @see @class Phiro\Security\Ciphers\TwoWay\Driver
*   @defineIn \phiro-kernel\classes\security\ciphers\two-way-drivers\&Driver.php
**/
class OpenSSL extends \Phiro\Security\Ciphers\TwoWay\Driver {

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @see
    *   @function openssl_cipher_iv_length()
    *
    * @access public
    *
    * Analizza l'Algoritmo di Criptazione scelto, impostando il @param $cipherKeysLength
	**/
    protected function checkCipherKeys() {
        if(!$this->beforeCheckCipherKeys()) return;
        $this->cipherKeysLength = (int) @openssl_cipher_iv_length( $this->cipherAlgorithm );
        $this->afterCheckCipherKeys();
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @see
    *   @function openssl_encrypt()
    *
    * @access public
    * @param $object                       : Oggetto / Informazioni da Criptare
    * @return String
    *
    * Restituisce l'Oggetto criptato (sotto forma di Stringa)
	**/
    public function cipherEncrypt($object = null) {
        if( $this->isOnError() ) return '';
        return $this->afterCipherEncrypt( 
            @openssl_encrypt( 
                $this->beforeCipherEncrypt( $object ), // Può essere vuoto
                $this->cipherAlgorithm,
                $this->cipherPrivateKey, 
                OPENSSL_RAW_DATA, 
                $this->cipherPublicKey
            ) 
        );
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @see
    *   @function openssl_decrypt()
    * 
    * @access public
    * @param $cryptedData                : Oggetto / Informazioni da Decriptare
    * @return String
    *
    * Restituisce l'Oggetto originale partendo da una Stringa criptata
	**/
    public function cipherDecrypt($cryptedData = '') {
        if( $this->isOnError() ) return  $this->afterCipherDecrypt('');
        return $this->afterCipherDecrypt(
            @openssl_decrypt( 
                $this->beforeCipherDecrypt( $cryptedData ),
                $this->cipherAlgorithm, 
                $this->cipherPrivateKey, 
                OPENSSL_RAW_DATA, 
                $this->cipherPublicKey
            )
        );
    }

} 

?>