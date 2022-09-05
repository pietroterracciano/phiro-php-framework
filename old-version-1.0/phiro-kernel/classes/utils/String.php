<?php

namespace Phiro\Utils;

if(!defined('Phiro\Constants\KERNEL_DIR')) exit;

use Phiro\Constants;

class String {

    public static function _toRegularExpression($string = null) {
        if(empty($string)) return null;
        return str_replace('/', '\/', $string);
    }

    /**
    * @author Pietro Terracciano
    * @since  1.0
    *
	* @see Phiro\Constants
	* 
    * @access public
	* @param $URI                         : Risorsa identificata tramite URI su cui viene eseguita l'azione
	* @return Pattern                     : Aggiunge il prefisso Phiro\Constants\Paths\ABS_FILE se non è contenuto già nel pattern dell'URI passato
	* 										Permette di gestire facilmente le Risorse contenute nello spazio del Framework
	**/
	public static function _addAbsoluteFilePath($URI = null) {
		if(empty($URI)) return null;
		if(strpos($URI, $absFilePath = Constants\Paths\ABS_FILE) === false) {
			$absFilePathLength = strlen($absFilePath);
			if($absFilePath[$absFilePathLength-1] != '/' && $URI[0] != '/') $URI = '/'.$URI;
			$URI = $absFilePath.$URI;
		}
		return $URI;
	}

	/**
    * @author Pietro Terracciano
    * @since  1.0
    *
	* @see Phiro\Constants
	* 
    * @access public
	* @param $URI                         : Risorsa identificata tramite URI su cui viene eseguita l'azione
	* @return Pattern                     : Aggiunge il prefisso Phiro\Constants\Paths\ABS_HTTP se non è contenuto già nel pattern dell'URI passato
	* 										Permette di gestire facilmente le Risorse contenute nello spazio del Framework
	**/
	public static function _addAbsoluteHttpPath($URI = null) {
		if(empty($URI)) return null;
		if(strpos($URI, $absHttpPath = Constants\Paths\ABS_HTTP) === false) {
			$absHttpPathLength = strlen($absHttpPath);
			if($absHttpPath[$absHttpPathLength-1] != '/' && $URI[0] != '/') $URI = '/'.$URI;
			$URI = $absHttpPath.$URI;
		}
		return $URI;
	}

}

?>