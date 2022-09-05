<?php

require_once '../../phiro-loader.php';
$PAGE_TITLE = ADT_QUEUE;
ob_start(); ?>

<h3><?php echo $PARTIAL_HEAD_TITLE; ?></h3>
<p></p>
<pre class="prettyprint lang-php ">
$instance = new Phiro\ADT\Queue();

<?php
$instance = new Phiro\ADT\Queue();
print_r($instance);
?>
</pre>

<?php 
$CONTENT = ob_get_clean(); 
require_once $PHIRO_ABS_ADMIN_PATH.'\\documentation.php';

?>