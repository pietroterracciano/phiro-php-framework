<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @author Pietro Terracciano
* @since  0.170707
* 
* @param $path                         : Path in cui effettuare la lettura
* @param $extensions                   : Estensioni dei Files
* @return Array
*
* Restituisce tutti i Paths e i Files presenti in @param $path
* Se @param $extensions è considerato, vengono restituiti solo i Files compatibili con le estensioni dichiarate
**/
function read_path($path = '', $extensions = '') {
    if(empty($path) || is_file($path)) return array();
    
    if(strpos($path, '\\') !== false) $delimiter = '\\';
    else $delimiter = '/';

    $resources = array();

    if(!empty($extensions)) {
        if(is_object($extensions)) $extensions = (array) $extensions;
        else if(!is_array($extensions)) $extensions = explode('|', str_replace(array(',','-','+'),'|', trim($extensions)));
    }

    foreach( scandir($path) as $resource) {
        if(!empty($resource) && $resource != '.' && $resource != '..') {
            $resource = ((!empty($path)) ? $path.$delimiter : '').$resource;
            if( !is_file($resource) ) {
                if(empty($extensions))
                    $resources[] = $resource;
                $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 3);
                if(!empty($backtrace[2]['function']) && $backtrace[2]['function'] === 'get_phiro_component_files') 
                    $resources = array_merge( recursive_read_path($resource, $extensions), $resources);
                else if(!empty($backtrace[1]['function']) && $backtrace[1]['function'] === 'recursive_read_path') 
                    $resources = array_merge($resources, recursive_read_path($resource, $extensions));
            } else {
                $resourceInfo = pathinfo($resource);
                if( empty($extensions) || in_array($resourceInfo['extension'], $extensions))
                    $resources[] = $resource;
            }
        }
    }

    return $resources;
}

?>