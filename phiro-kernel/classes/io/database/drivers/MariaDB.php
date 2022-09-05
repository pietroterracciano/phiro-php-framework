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
* @see @class Phiro\IO\Database\Driver\MySQL
*   @defineIn \phiro-kernel\classes\io\database\drivers\MySQL.php
**/
class MariaDB extends \Phiro\IO\Database\Drivers\MySQL { }

?>