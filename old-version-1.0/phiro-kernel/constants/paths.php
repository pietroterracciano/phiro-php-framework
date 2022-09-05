<?php

namespace Phiro\Constants\Paths;

if(!defined('Phiro\Constants\KERNEL_DIR')) exit;

use Phiro\Constants;
use Phiro\Lang;

$exceptionTag = 'KER_CON_PATH';

$absFilePath = str_replace(Constants\KERNEL_DIR.'/constants', '', str_replace('\\', '/', __DIR__) ); 

if(empty($absFilePath)) new Lang\Exception('Impossible to define "Phiro\Constants\Paths\ABS_FILE"', null, $exceptionTag, Lang\Exception::FAST_LAUNCH, Lang\Exception::LAUNCH_AS_HTML);
define('Phiro\Constants\Paths\ABS_FILE', $absFilePath);
if(!defined('Phiro\Constants\Paths\ABS_FILE')) new Lang\Exception('Impossible to define "Phiro\Constants\Paths\ABS_FILE"', null, $exceptionTag, Lang\Exception::FAST_LAUNCH, Lang\Exception::LAUNCH_AS_HTML);
define('Phiro\Constants\Paths\RELATIVE', str_replace($_SERVER['DOCUMENT_ROOT'], '', Constants\Paths\ABS_FILE)); 
if(!defined('Phiro\Constants\Paths\RELATIVE')) new Lang\Exception('Impossible to define "Phiro\Constants\Paths\RELATIVE"', null, $exceptionTag, Lang\Exception::FAST_LAUNCH, Lang\Exception::LAUNCH_AS_HTML);
define('Phiro\Constants\Paths\ABS_HTTP', 'http://'.$_SERVER['SERVER_NAME'].Constants\Paths\RELATIVE);
if(!defined('Phiro\Constants\Paths\ABS_HTTP')) new Lang\Exception('Impossible to define "Phiro\Constants\Paths\ABS_HTTP"', null, $exceptionTag, Lang\Exception::FAST_LAUNCH, Lang\Exception::LAUNCH_AS_HTML);

?>