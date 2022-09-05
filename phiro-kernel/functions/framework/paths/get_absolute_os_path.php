<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @author Pietro Terracciano
* @since  0.170706
*
* @return String
*
* Restituisce il Path OS assoluto dello Script corrente
**/
function get_absolute_os_path() {
    global $PhiroServer;
    if( ($PhiroServer instanceof Phiro\Lang\Server) )
        return $PhiroServer->getAbsoluteOSPath();
    global $PHIRO_ABS_OS_PATH;
    return $PHIRO_ABS_OS_PATH;
}

function get_os_path() {
    return get_absolute_os_path();
}

?>