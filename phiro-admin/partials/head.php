<?php 

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

global $PHIRO_REL_ADMIN_URL;

?>

<!DOCTYPE html>
<head>
    <title><?php echo (!empty($PARTIAL_HEAD_TITLE)) ? sanitize_string($PARTIAL_HEAD_TITLE) : ''; ?></title>
    <meta author="Pietro Terracciano" />
    <meta charset="UTF-8" />
    <link rel='stylesheet' href='<?php echo get_relative_admin_path(); ?>/assets/css/style.css' />
    <link rel='stylesheet' href='<?php echo get_relative_admin_path(); ?>/assets/css/font-awesome-minified.css?ver=4.7.0' />
    <link rel='stylesheet' href='<?php echo get_relative_admin_path(); ?>/assets/css/animate.css?ver=3.5.2' />

    <script src='<?php echo $PHIRO_REL_ADMIN_URL; ?>/assets/js/jquery-1.12.4-minified.js?ver=1.12.4'></script>
    <script src='<?php echo $PHIRO_REL_ADMIN_URL; ?>/assets/js/functions/jquery/toBoolean.js'></script>
</head>