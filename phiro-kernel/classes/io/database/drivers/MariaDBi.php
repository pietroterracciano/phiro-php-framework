<?php

/**
* @see @namespace Phiro\IO\Database\Drivers
**/
namespace Phiro\IO\Database\Drivers;

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @see @class Phiro\IO\Database\Driver\MySQLi
*   @defineIn \phiro-kernel\classes\io\database\drivers\MySQLi.php
**/
class MariaDBi extends \Phiro\IO\Database\Drivers\MySQLi { }

?>