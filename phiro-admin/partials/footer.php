<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

global $PHIRO_VERSION;

?>

<div id='footer'>
    <div class='col-6'><p><?php echo sanitize_string(PHIRO_FRAMEWORK_IS_BEEN_DEVELOPED_BY); ?> <a href="https://www.linkedin.com/in/pterracciano95">Pietro Terracciano</a></p></div>
    <div class='col-6 text-align-right'><p><?php echo sanitize_string(VERSION.' '.$PHIRO_VERSION); ?></p></div>
</div>

<script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>