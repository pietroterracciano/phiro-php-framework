<?php 

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit; 

global $PHIRO_ABS_ADMIN_PATH;

require_once $PHIRO_ABS_ADMIN_PATH.'\\loader.php';
$PAGE_TEMPLATE = DOCUMENTATION__TEMPLATE;

if(empty($PARTIAL_HEAD_TITLE)) $PARTIAL_HEAD_TITLE = 'Test';

$PARTIAL_HEAD_TITLE .= ' @Phiro';
require_once $PHIRO_ABS_ADMIN_PATH.'\\partials\\head.php';
require_once $PHIRO_ABS_ADMIN_PATH.'\\partials\\header.php';

?>

<div id='container'>
    <?php echo ( !empty($CONTENT) ) ? $CONTENT : ''; ?>
</div>

<?php require_once $PHIRO_ABS_ADMIN_PATH.'\\partials\\footer.php'; ?>