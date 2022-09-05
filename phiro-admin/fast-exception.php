<?php 

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit; 

global $PHIRO_ABS_ADMIN_PATH;

require_once $PHIRO_ABS_ADMIN_PATH.'\\loader.php';

$PARTIAL_HEAD_TITLE = EXCEPTION.' @Phiro';
require_once $PHIRO_ABS_ADMIN_PATH.'\\partials\\head.php';
require_once $PHIRO_ABS_ADMIN_PATH.'\\partials\\header.php';

?>

<div id='container'>
    <?php echo ( !empty($fastException->message) ) ? $fastException->message : ''; ?>
</div>

<?php require_once $PHIRO_ABS_ADMIN_PATH.'\\partials\\footer.php'; ?>