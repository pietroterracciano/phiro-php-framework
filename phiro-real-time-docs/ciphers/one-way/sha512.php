<?php

require_once '../../../phiro-loader.php';
$PARTIAL_HEAD_TITLE = 'One Way Cipher "sha512" Test';
ob_start(); ?>

<h3><?php echo $PARTIAL_HEAD_TITLE; ?></h3>

<p>$myInstance = new Phiro\Security\Ciphers\OneWay()</p>
<pre>
<?php
$PhiroOneWayCipher = new Phiro\Security\Ciphers\OneWay('sha512');
print_r($PhiroOneWayCipher);
?>
</pre>

<div class='break'></div>
<div class='break'></div>

<p>Crypto results of "Phiro Framework is been developed by Pietro Terracciano" string</p>
<pre>
<?php
$cryptedData = $PhiroOneWayCipher->encrypt('Phiro Framework is been developed by Pietro Terracciano');
echo $cryptedData;
?>
</pre>

<div class='break'></div>
<div class='break'></div>

<p>Verify previously crypted data with $myInstance->verify($myObject, $cryptedData)</p>
<pre>
<?php
if ($PhiroOneWayCipher->verify('Phiro Framework is been developed by Pietro Terracciano', $cryptedData)) echo "Are the same";
else echo "Are different";
?>
</pre>

<div class='break'></div>
<div class='break'></div>

<p>Encrypt Time</p>
<pre>
<?php echo $PhiroOneWayCipher->getEncryptTime(); ?>
</pre>

<?php 
$testContent = ob_get_clean(); 
require_once $PHIRO_ABS_ADMIN_PATH.'\\test.php';

?>

