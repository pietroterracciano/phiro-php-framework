<?php

if ( !defined('ABS_FILE_PATH') ) exit;

$PhiroIoDatabase = new PhiroIoDatabase(
    (!empty($_GET['DB_NAME'])) ? $_GET['DB_NAME'] : null,
    (!empty($_GET['DB_HOST'])) ? $_GET['DB_HOST'] : null,
    (!empty($_GET['DB_USER'])) ? $_GET['DB_USER'] : null,
    (!empty($_GET['DB_PASSWORD'])) ? $_GET['DB_PASSWORD'] : null,
    PhiroIoDatabase::FAST_CONNECT
);

$thrownBy = 'API_DB_TRUNCATE_TABLE';

if(empty($_GET['DB_TABLE'])) new PhiroException('Database Table is empty', 'DTIE', $thrownBy, PhiroException::FAST_LAUNCH);
if(!$PhiroIoDatabase->query('TRUNCATE TABLE `'.$_GET['DB_TABLE'].'`')) new PhiroException($PhiroIoDatabase->getErrorMessage(), null, $thrownBy, PhiroException::FAST_LAUNCH);

echo PhiroUtilJson::_encode(
    array(
        'STATUS' => 'Success',
    )
);

?>