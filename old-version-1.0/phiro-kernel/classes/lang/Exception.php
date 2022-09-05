<?php

namespace Phiro\Lang;

if(!defined('Phiro\Constants\KERNEL_DIR')) exit;

use Exception as _Exception;
use StdClass;
use Phiro\Constants;
use Phiro\Utils;

class Exception extends _Exception {

    const LAUNCH_AS_JSON = 0;
    const LAUNCH_AS_HTML = 1;

    const SMART_LAUNCH = false;
    const FAST_LAUNCH = true;

    private $Ocode;
    private $Omessage;
    private $thrownBy;
    private $options;


	/**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @see Exception
    *
    * @access public                        
    * @param $message                           : Messaggio dell'Eccezione
    * @param $code                              : Identificativo dell'Eccezione
    * @param $thrownBy                          : Padre dell'Eccezione
    * @param Boolean $fastLaunch                : Se settato a "true" lancia subito l'Eccezione, altrimenti attende la chiamata del metodo $this->launch()
    * @param Integer $launchAs                  : Ritorna i parametri dell'Eccezioni secondo lo Stile di visualizzazione richiesto
    *
    * Istanzia una Eccezione
	**/
    final public function __construct($message = null, $code = null, $thrownBy = null, $fastLaunch = false, $launchAs = 0) {
        $this->Omessage = $message;
        $this->Ocode = $code;
        $this->thrownBy = $thrownBy;
        $this->options = new StdClass();
        $this->options->fastLaunch = (bool) $fastLaunch;
        $this->options->launchAs = (int) $launchAs;
        if(!empty($this->options->fastLaunch)) $this->launch();
    }

    /**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @access public
    * @return Attributo
	**/
    final public function getThrownBy() {
        return $this->thrownBy;
    }

	/**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @access public
    * @return Attributo
	**/
    final public function getOCode() {
        return $this->Ocode;
    }

	/**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @access public
    * @return Attributo
	**/
    final public function getOMessage() {
        return $this->Omessage;
    }

    /**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @see Phiro\Utils\Json
    *
    * @access public
    * @return JSON                             : Restituisce gli Attributi dell'Eccezione come array JSON
	**/
    final public function toJson() {
        $array = 
            array(
                'STATUS' => 'Exception',
                'MESSAGE' => $this->Omessage
            );
        if(!empty($this->Ocode)) $array['CODE'] = $this->Ocode;
        if(!empty($this->thrownBy)) $array['THROWN_BY'] = $this->thrownBy;
        return Utils\Json::_encode($array);
    }

    /**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @access public
    * @return HTML                             : Restituisce gli Attributi dell'Eccezione come HTML
	**/
    final public function toHtml() {
        $html = '<h1 style="color: #2f2f2f; font-size: 28px; margin: 0 0 5px 0; padding: 0;">'.$this->Omessage.'</h1>
        <p style="color: #afafaf; font-size: 14px; margin: 0; padding: 0;">';
        if(!empty($this->Ocode)) $html .= $this->Ocode.' | ';
        if(!empty($this->thrownBy)) $html .= $this->thrownBy.' | ';
        return substr($html, 0, -2).'</p>';
    }

    /**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @access public
    * 
    * Lancia e stampa l'Eccezione e termina lo script corrente
	**/
    final public function launch() {
        switch($this->options->launchAs) {
            default:
                echo $this->toJSON();
                break;
            case 1:
                echo $this->toHTML();
                break;
        }
        exit;
    }

}

?>