<?php

namespace Phiro\Constants\Files;

if(!defined('Phiro\Constants\KERNEL_DIR')) exit;

use Phiro\Constants;

define(__NAMESPACE__.'\KERNEL_REWRITE_RULES', Constants\KERNEL_DIR.'/assets/files/rewriteRules.php');
define(__NAMESPACE__.'\REWRITE_RULES', '/phiro-rewrite-rules.php');

?>