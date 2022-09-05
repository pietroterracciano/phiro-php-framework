<?php

namespace Phiro;

if(!defined('Phiro\Constants\KERNEL_DIR')) exit;

class IO extends Lang\AbstractCaller { }

global $PhiroIO;
$PhiroIO = new IO();

?>