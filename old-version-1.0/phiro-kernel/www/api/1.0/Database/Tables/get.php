<?php

if ( !defined('ABS_FILE_PATH') ) exit;

$PhiroIoDatabase = new PhiroIoDatabase(
    (!empty($_GET['DB_NAME'])) ? $_GET['DB_NAME'] : null,
    (!empty($_GET['DB_HOST'])) ? $_GET['DB_HOST'] : null,
    (!empty($_GET['DB_USER'])) ? $_GET['DB_USER'] : null,
    (!empty($_GET['DB_PASSWORD'])) ? $_GET['DB_PASSWORD'] : null,
    PhiroIoDatabase::FAST_CONNECT
);

$response =
    array(
        'STATUS' => 'Success'
    );
$tables = $PhiroIoDatabase->get("SHOW TABLES FROM ".$_GET['DB_NAME']);
if(!empty($tables)) $response['CONTENT'] = $tables;

echo PhiroUtilJson::_encode($response);

?>