<?php

/**
* @see @namespace Phiro\Lang
**/
namespace Phiro\Lang;

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @see
*   @namespace Phiro\UI
*   @namespace Phiro\Utils
**/
use Phiro\UI;

/**
* @see @class Phiro\Lang\Object
*   @defineIn \phiro-kernel\classes\lang\Object.php
**/
class FastException extends Object {

    /**
    * @since  0.170422
    *
    * @define @consts FLAGS
    **/
    const RETURN_AS__JSON = 1;
    const RETURN_AS__HTML = 2;
    const RETURN_AS__TEMPLATE = 'TEMPLATE';

    /**
    * @since  0.170422
    *
    * @define @params INSTANCE
    * @define
    *   @param $message                           : Messaggio dell'Eccezione
    *   @param $ID                                : Identificativo dell'Eccezione
    *   @param $throwner                          : Informazioni sul Chiamante dell'Eccezione
    *   @param $trace                             : Traccia completa dell'Eccezione
    **/
    private $message;
    private $ID;
    private $throwner;
    private $trace; 

	/**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @see \Exception
    *
    * @access public                        
    * @param $message                           : Messaggio dell'Eccezione
    * @param $ID                                : Identificativo dell'Eccezione
    * @param $template                          : Template / File da richiamare per Eccezioni con UI
    * @param $returnAs                          : Ritorna i parametri dell'Eccezione secondo lo Stile di visualizzazione richiesto
    *                                              Se è impostato @param $template questa impostazione viene saltata
    *
    * Istanzia una Eccezione
	**/
    final public function __construct($arrayOrMessage = null, $ID = '', $template = '', $returnAs = 1) {
        if(!is_array($arrayOrMessage))
            $message = $arrayOrMessage;
        else {
            $arrayOrMessage = recursive_array_map('trim', $arrayOrMessage);
            $message = (!empty($arrayOrMessage['message'])) ? $arrayOrMessage['message'] : '';
            $ID = (!empty($arrayOrMessage['ID'])) ? $arrayOrMessage['ID'] : '';
            if(!empty($arrayOrMessage['template'])) {
                $template = $arrayOrMessage['template'];
                $returnAs = self::RETURN_AS__TEMPLATE;
            } else 
                $returnAs = (!empty($arrayOrMessage['returnAs'])) ? $arrayOrMessage['returnAs'] : self::RETURN_AS__JSON;
        }

        $this->message = $message;
        $this->ID = $ID;
        $this->trace = debug_backtrace( DEBUG_BACKTRACE_IGNORE_ARGS );
        if( is_array($this->trace) )
            $this->throwner = array(
                'file' => (!empty($this->trace[0]['file'])) ? $this->trace[0]['file'] : 'Unrecognized',
                'line' => (!empty($this->trace[0]['line'])) ? $this->trace[0]['line'] : 'Unrecognized',
            );

        switch(strtolower($returnAs)) {
            default:
                echo $this->toJSON();
                break;
            case self::RETURN_AS__HTML: case 'html':
                echo $this->toHTML();
                break;
            case 'template':
                echo $this->toTemplate($template);
                break;
        }
        exit;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @see @function json_secure_encode() OPPURE _json_encode()
    *   @definedIn \phiro-kernel\functions\php\json_secure_encode.php
    *
    * @access public
    * @return String JSON                     
    *
    * Restituisce i @params dell'Eccezione come una Stringa JSON
	**/
    final public function toJSON() {
        $object = 
            array(
                'STATUS' => 'FastException'
            );
        if(!empty($this->message)) $object['MESSAGE'] = $this->message;
        if(!empty($this->ID)) $object['ID'] = $this->ID;
        return json_secure_encode($object);
    }
    
    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @access public
    * @return HTML
    *
    * Restituisce i @params dell'Eccezione come HTML
	**/
    final public function toHTML() {
        global $PHIRO_KERNEL_DIR, $PHIRO_ABS_KERNEL_PATH;
        require_once $PHIRO_ABS_KERNEL_PATH.'\theme\exception.php';
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @param $template                : Template
    *
    * @access public
    * @return HTML
    *
    * Permette di gestire l'Eccezione con un Template personalizzato
	**/
    final public function toTemplate($template = '') {
        global $PHIRO_KERNEL_DIR;
        
        $fastException = $this;
        require_once $template;
    }

}

?>