<?php

namespace Phiro\IO\Database\Drivers;

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @see @class Phiro\IO\Database\Driver
*   @defineIn \phiro-kernel\classes\io\database\&Driver.php
**/
class Unrecognized extends \Phiro\IO\Database\Driver {

    public function DBConnect() { return false; }
    public function DBClose() { return false; }
    public function beginDBTransaction() { return null; }
    public function DBQuery() { return false; }
    public function hasDBQueryFetchedRow() { return false; }
    public function hasDBQueryFetchedField() { return false; }
    public function DBCommit() { return null; }
    public function DBRollback() { return null; }

} 

?>