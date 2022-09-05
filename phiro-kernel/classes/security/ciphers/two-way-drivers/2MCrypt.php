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
class MCrypt extends \Phiro\Security\Ciphers\TwoWay\Driver {

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @see
    *   @function mcrypt_get_iv_size()
    *   @function constant()
    *
    * @access public
    *
    * Analizza l'Algoritmo di Criptazione scelto, impostando il @param $cipherKeysLength
	**/
    protected function checkCipherKeys() {
        if(!$this->beforeCheckCipherKeys()) return;
        $algorithmPieces = explode('-', $this->cipherAlgorithm);
        if( count($algorithmPieces) > 2 ) {
            $this->cipherAlgorithm = 'MCRYPT_'.$algorithmPieces[0].'_'.$algorithmPieces[1];
            $this->cipherMode = 'MCRYPT_MODE_'.$algorithmPieces[2];
        } 
        $this->cipherKeysLength = (int) @mcrypt_get_iv_size( constant($this->cipherAlgorithm), constant($this->cipherMode) );
        $this->afterCheckCipherKeys();
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @see
    *   @function mcrypt_encrypt()
    *   @function constant()
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
            mcrypt_encrypt(
                constant( $this->cipherAlgorithm ),
                $this->cipherPrivateKey,
                $this->beforeCipherEncrypt( $object ), // Può essere vuoto
                constant( $this->cipherMode ),
                $this->cipherPublicKey
            ) 
        );
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170603
    *
    * @see
    *   @function mcrypt_decrypt()
    *   @function constant()
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
            @mcrypt_decrypt( 
                constant( $this->cipherAlgorithm ),
                $this->cipherPrivateKey,
                $this->beforeCipherDecrypt( $cryptedData ), // Può essere vuoto
                constant( $this->cipherMode ),
                $this->cipherPublicKey
            )
        );
    }

} 

?>