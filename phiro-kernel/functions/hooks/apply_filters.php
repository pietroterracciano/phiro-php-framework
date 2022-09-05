<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @author Pietro Terracciano
* @since  0.170703
* 
* @param $paramsOrPoolName             : Array di parametri (contenente gli argomenti da passare al Pool) OPPURE Nome Pool di azioni da richiamare
* @return Boolean
*
* Restituisce il risultato dell'Azione corrente
*
* @likeAs WordPress apply_filters()
**/
function apply_filters($paramsOrPoolName = '') {
    $backtrace = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2);

    if(!empty($backtrace[1]['function']) && $backtrace[1]['function'] === 'do_action') {
        global $PHIRO__ACTIONS;
        $_STRUCTURE = &$PHIRO__ACTIONS;
        $calledByAction = true;
    } else {
        global $PHIRO__FILTERS;
        $_STRUCTURE = &$PHIRO__FILTERS;
        $calledByAction = false;
    }


    if(is_array($paramsOrPoolName)) {
        foreach($paramsOrPoolName as $key => $value)
            ${$key} = $value;
    } else $poolName = $paramsOrPoolName;
    
    $poolName = trim($poolName);

    if( empty($poolName) || empty($_STRUCTURE[$poolName]) ) return false;
    
    $callbackOutput = '';
    $callbackNumbers = 0;

    foreach($_STRUCTURE[$poolName] as $pool) {
        if( is_a($pool, 'Phiro\ADT\Queue')) {
            $filling = $pool->getFilling();
            for($i=0;$i<$filling;$i++) {
                $element = $pool->peek($i);

                if($calledByAction) {
                    $params = func_get_args()[1];
                    array_shift($params);
                } else {
                    if($callbackNumbers > 0)
                        $params = array($callbackOutput);
                    else {
                        $params = func_get_args();
                        array_shift($params);
                    }
                }

                $callbackParams = array();
                for($j=0; $j<$element['callbackParamsNumber'];$j++) {
                    if(isset($params[$j])) $callbackParams[$j] = $params[$j];
                }
                if( (strpos($element['callback'], '__ANONYMOUS_CALLBACK__')) !== false )
                    $element['callback'] = $_STRUCTURE['__ANONYMOUS_CALLBACKS__'][ (int) str_replace('__ANONYMOUS_CALLBACK__', '', $element['callback']) ];
                    
                if($calledByAction) 
                    call_user_func_array($element['callback'], $callbackParams);
                else {
                    ob_start();
                    $tCallbackOutput = call_user_func_array($element['callback'], $callbackParams);
                    if(empty($tCallbackOutput)) $callbackOutput = ob_get_clean();
                    else $callbackOutput = $tCallbackOutput; 
                }

                $callbackNumbers++;
            }
        }
    }

    return $callbackOutput;
}

?>