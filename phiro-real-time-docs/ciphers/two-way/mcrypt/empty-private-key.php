<?php

require_once '../../../../phiro-loader.php';
$PARTIAL_HEAD_TITLE = 'Two Way Cipher "MCrypt Empty Private Key" Test';
ob_start(); ?>

<h3><?php echo $PARTIAL_HEAD_TITLE; ?></h3>

<p>$myInstance = new Phiro\Security\Ciphers\TwoWay()</p>
<pre>
<?php
$PhiroTwoWayCipher = new Phiro\Security\Ciphers\TwoWay(
    array(
        'type' => 'MCrypt',
        'algorithm' => 'RIJNDAEL-256-CBC',
        'privateKey' => '',
    )
);
print_r($PhiroTwoWayCipher);
?>
</pre>

<div class='break'></div>
<div class='break'></div>

<p>Crypto results of "Phiro Framework is been developed by Pietro Terracciano" string</p>
<pre>
<?php
$cryptedData = $PhiroTwoWayCipher->encrypt('Phiro Framework is been developed by Pietro Terracciano');
echo $cryptedData;
?>
</pre>

<div class='break'></div>
<div class='break'></div>

<p>Encrypt Time</p>
<pre>
<?php echo $PhiroTwoWayCipher->getEncryptTime(); ?>
</pre>

<div class='break'></div>
<div class='break'></div>

<p>Verify previously crypted data with $myInstance->verify($myObject, $cryptedData)</p>
<pre>
<?php
if ($PhiroTwoWayCipher->verify('Phiro Framework is been developed by Pietro Terracciano', $cryptedData)) echo "Are the same";
else echo "Are different";
?>
</pre>

<div class='break'></div>
<div class='break'></div>

<p>Decrypto results of $cryptedData</p>
<pre>
<?php
print_r($PhiroTwoWayCipher->decrypt($cryptedData));
?>
</pre>

<div class='break'></div>
<div class='break'></div>

<p>Decrypt Time</p>
<pre>
<?php echo $PhiroTwoWayCipher->getDecryptTime(); ?>
</pre>

<?php 
$testContent = ob_get_clean(); 
require_once $PHIRO_ABS_ADMIN_PATH.'\\test.php';

?>

