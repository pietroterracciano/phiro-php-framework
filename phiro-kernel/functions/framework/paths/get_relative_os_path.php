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
* Restituisce il Path OS relativo dello Script corrente
**/
function get_relative_os_path() {
    global $PhiroServer;
    if( ($PhiroServer instanceof Phiro\Lang\Server) )
        return $PhiroServer->getRelativeOSPath();
    global $PHIRO_REL_OS_PATH;
    return $PHIRO_REL_OS_PATH;
}

?>