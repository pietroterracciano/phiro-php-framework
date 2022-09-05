<?php

if ( !defined('ABS_FILE_PATH') ) exit;

$PhiroDatabase = new PhiroDatabase(
    (!empty($_GET['DB_NAME'])) ? $_GET['DB_NAME'] : null,
    (!empty($_GET['DB_HOST'])) ? $_GET['DB_HOST'] : null,
    (!empty($_GET['DB_USER'])) ? $_GET['DB_USER'] : null,
    (!empty($_GET['DB_PASSWORD'])) ? $_GET['DB_PASSWORD'] : null
);

$PhiroDatabase->connect();
echo PhiroUtilJson::_encode(
    array(
        'STATUS' => 'Success'
    )
);
$PhiroDatabase->close();
exit;


?>