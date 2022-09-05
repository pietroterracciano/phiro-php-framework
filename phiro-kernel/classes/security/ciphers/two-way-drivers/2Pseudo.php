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
class Pseudo extends \Phiro\Security\Ciphers\TwoWay\Driver {

    /**
    * @author Pietro Terracciano
    * @since  0.170606
    *
    * @access public
    *
    * Analizza l'Algoritmo di Criptazione scelto, impostando il @param $cipherKeysLength
	**/
    protected function checkCipherKeys() {
        if(!$this->beforeCheckCipherKeys()) return;
        $this->cipherKeysLength = string_length($this->cipherPublicKey);
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
        
        /**
        * Ottengo l'Alfabeto comprensivo di Caratteri di punteggiatura e Caratteri speciali
        **/
        $alphabet = get_alphabet(
            array(
                'allowPunctuationCharacters' => true,
                'allowSpecialCharacters' =>  true,
            )
        );
        $alphabetSize = count($alphabet);

        /**
        * Ottengo la Chiave privata come Array di Caratteri
        **/
        $cipherPrivateKey = array();
        for($i=0; $i< string_length($this->cipherPrivateKey); $i++) {
            if( !isset($cipherPrivateKey[$this->cipherPrivateKey[$i]]) ) $cipherPrivateKey[$this->cipherPrivateKey[$i]] = $i;
        }

        /**
        * Effetto uno pseudo shuffle utilizzando @function rand() e salvando il numero casuale in @var $seed
        **/
        $alphabet = move_array_keys($alphabet, $seed = rand(-$alphabetSize, $alphabetSize));

        /**
        * Scambia le chiavi dell'Array con i valori associati
        **/
        $alphabet = array_flip($alphabet);

        /**
        * Effetto le stesse operazioni effettuate sull'Alfabeto
        **/
        $cipherPrivateKey = array_flip(move_array_keys(array_flip($cipherPrivateKey), $seed));

        /**
        * Calcola la Lunghezza massima di un Blocco di codifica che andrà a comporre @var $cryptedData. Viene aggiunto +1 per il TAG, +1 per il segno del Seed
        * $cryptedData = B1 . B2 . B3 . ... . Bn
        **/
        $cryptBlockLength = 1 + 1 + (( $cipherKeysLength = strlen($this->cipherKeysLength) >= $alphabetLength = strlen($alphabetSize) ) ? $cipherKeysLength : $alphabetLength);
        
        /**
        * Genera il Contenuto criptato
        **/
        $object = $this->beforeCipherEncrypt($object);
        $cryptedData = '';
        for($i=0; $i < $objectLength = string_length($object); $i++) {
            $cryptedDataBlock = '';
            if( isset($cipherPrivateKey[$object[$i]]) ) {
                for($j=0; $j < $cryptBlockLength; $j++) $cryptedDataBlock .= 'K';
                $hashValue = $cipherPrivateKey[$object[$i]];
            } else {
                for($j=0; $j < $cryptBlockLength; $j++) $cryptedDataBlock .= '0';
                $hashValue = $alphabet[$object[$i]];
            }
            $cryptedData .= substr($cryptedDataBlock, strlen($hashValue)).$hashValue;
        }
        
        /**
        * Inserisce il Seed in modo casuale nel Contenuto criptato
        **/
        $randomSeedPosition = $cryptBlockLength * rand(0, $objectLength - 1);
        $tCryptedDataBlock = substr($cryptedData, $randomSeedPosition, $cryptBlockLength );

        $cryptedDataBlock = '';
        for($i=0;$i<$cryptBlockLength;$i++) $cryptedDataBlock .= 'S';
        $cryptedDataBlock = substr($cryptedDataBlock, strlen($seed)).$seed;

        return $this->afterCipherEncrypt(substr_replace($cryptedData, $tCryptedDataBlock.$cryptedDataBlock, $randomSeedPosition, $cryptBlockLength));
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
        if( $this->isOnError() ) return '';
        
        /**
        * Ottengo l'Alfabeto comprensivo di Caratteri di punteggiatura e Caratteri speciali
        **/
        $alphabet = get_alphabet(
            array(
                'allowPunctuationCharacters' => true,
                'allowSpecialCharacters' =>  true,
            )
        );
        $alphabetSize = count($alphabet);

        /**
        * Ottengo la Chiave privata come Array di Caratteri
        **/
        $cipherPrivateKey = array();
        for($i=0; $i< string_length($this->cipherPrivateKey); $i++) {
            if( !isset($cipherPrivateKey[$this->cipherPrivateKey[$i]]) ) $cipherPrivateKey[$this->cipherPrivateKey[$i]] = $i;
        }

        /**
        * Calcola la Lunghezza massima di un Blocco codificato che va a comporre @var $cryptedData. Viene aggiunto +1 per il TAG iniziale, +1 per il segno del Seed
        * $cryptedData = B1 . B2 . B3 . ... . Bn
        **/
        $cryptBlockLength = 1 + 1 + (( $cipherKeysLength = strlen($this->cipherKeysLength) >= $alphabetLength = strlen($alphabetSize) ) ? $cipherKeysLength : $alphabetLength);

        $object = '';
        $objectLength = string_length( $cryptedData = $this->beforeCipherDecrypt($cryptedData) ) / $cryptBlockLength;

        /**
        * Cerco il Seed contenuto in @var $cryptedData e lo salvo in @var $seed
        * Successivamente lo rimuovo da @var $cryptedData
        **/
        $seed = 0;
        for($i=0; $i < $objectLength; $i++) {
            $hashValue = '';
            for($j=0; $j < $cryptBlockLength; $j++) $hashValue .= $cryptedData[$j + ($cryptBlockLength*$i)];
            if( !is_numeric($hashValue) && !preg_match('/K{1,'.$cryptBlockLength.'}/i', $hashValue) && preg_match('/S{1,'.$cryptBlockLength.'}/i', $hashValue)) {
                $seed = (int) str_replace('S', '', $hashValue);
                $cryptedData = str_replace($hashValue, '', $cryptedData);
                $objectLength -= 1;
                break;
            }
        }

        /**
        * Effetto uno pseudo shuffle utilizzando @var $seed trovato in precedenza
        **/
        $alphabet = move_array_keys($alphabet, $seed);
        $cipherPrivateKey = move_array_keys(array_flip($cipherPrivateKey), $seed);

        /**
        * Decripto il Contenuto @var $cryptedData in precedenza
        **/
        for($i=0; $i < $objectLength; $i++) {
            $hashValue = '';
            for($j=0; $j < $cryptBlockLength; $j++) $hashValue .= $cryptedData[$j + ($cryptBlockLength*$i)];

            if( !is_numeric($hashValue) ) {
                for($j=0; $j<string_length($hashValue);$j++) {
                    if(is_numeric($hashValue[$j])) {
                        $hashValue = substr($hashValue, $j);
                        break;
                    }
                }
                $object .= $cipherPrivateKey[$hashValue];
            } else 
                $object .= $alphabet[ (int) $hashValue ];
        
        }

        return $this->afterCipherDecrypt($object);
    }

} 

?>