<?php

if ( !defined('ABS_FILE_PATH') ) exit;

$PhiroIoDatabase = new PhiroIoDatabase(
    (!empty($_GET['DB_NAME'])) ? $_GET['DB_NAME'] : null,
    (!empty($_GET['DB_HOST'])) ? $_GET['DB_HOST'] : null,
    (!empty($_GET['DB_USER'])) ? $_GET['DB_USER'] : null,
    (!empty($_GET['DB_PASSWORD'])) ? $_GET['DB_PASSWORD'] : null,
    PhiroIoDatabase::FAST_CONNECT
);

if(empty($_GET['DB_TABLE'])) new PhiroException('Database Table is empty', 'DTIE', 'API_DB_GET_TABLE_SCHEMA', PhiroException::FAST_LAUNCH);

$response = 
    array(
        'STATUS' => 'Success'
    );

$tempSchema = $PhiroIoDatabase->get('DESCRIBE '.$_GET['DB_TABLE']);
if(!empty($tempSchema) && is_array($tempSchema) && count($tempSchema) > 0) {
    $schema = null;
    foreach($tempSchema as $attribute) {
        if(!empty($attribute[1])) $dataType = explode(' ', $attribute[1]);
        if(!empty($attribute[3])) {
            switch($attribute[3]) {
                default:
                    $key = null;
                    break;
                case 'UNI':
                    $key = 'unique';
                    break;
                case 'MUL': case 'IND':
                    $key = 'index';
                    break;
                case 'PRI':
                    $key = 'primary';
                    break;
            }
        } else $key = null;

        $schema[] = array(
            'NAME' => (!empty($attribute[0])) ? $attribute[0] : null,
            'DATA_TYPE' => (!empty($dataType[0])) ? $dataType[0] : null,
            'ATTRIBUTE' => (!empty($dataType[1])) ? $dataType[1] : null,
            'NULL' => (!empty($attribute[2]) && $attribute[2] == 'YES') ? true : false,
            'KEY' => $key,
            'DEFAULT_VALUE' => (!empty($attribute[4])) ? $attribute[4] : null,
        );
    }
    $response['SCHEMA'] = $schema;
}

echo PhiroUtilJson::_encode($response);

?>