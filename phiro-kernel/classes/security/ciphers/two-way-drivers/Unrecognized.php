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
class Unrecognized extends \Phiro\Security\Ciphers\TwoWay\Driver {

    public function checkCipherKeys() { $this->cipherKeysLength = 0; }
    public function cipherEncrypt() { return ''; }
    public function cipherDecrypt() { return ''; }

} 

?>