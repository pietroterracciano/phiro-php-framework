<?php

namespace Phiro\IO;

if(!defined('Phiro\Constants\KERNEL_DIR')) exit;

use StdClass;
use Phiro\Constants;
use Phiro\Utils;

class File extends \Phiro\IO {
	const EXCEPTION_TAG = 'IO_FILE_CLASS';

	const RETURN_AS_ARRAY = 0;
    const RETURN_AS_STRING = 1;

	const ENTRY_MODE_A_PLUS = 'a+';
	const ENTRY_MODE_R = 'r';
	const ENTRY_MODE_R_PLUS = 'r+';
	const ENTRY_MODE_W = 'w';
	const ENTRY_MODE_W_PLUS = 'w+';

	const FAST_OPEN = true;
	const SMART_OPEN = false;

    const NO_ERROR_ID = 0; /* Nessun errore */
	const IMP_TO_OPEN_HANDLE_ERROR_ID = 1;
	const IMP_TO_CLOSE_HANDLE_ERROR_ID = 2;

	private $file;
	private $handle;
	private $read;
	private $options;
	private $lastErrorID;

	/**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @see StdClass()
    *
    * @access public
	* @param $file                          : File su cui operare
	* @param $entryMode                     : Modalità di apertura del File
	* @param $fastOpen                      : Se "true" apre direttamente il File, altrimenti attende la chiamata del metodo $this->open()
	*
	* Istanzia un File
	**/
	public function __construct($file = null, $entryMode = null, $fastOpen = false) {
		if(empty($file)) return null;

		$this->file = Utils\String::_addAbsoluteFilePath($file);
		$this->read = new StdClass();
		$this->read->nextLine = null;
		$this->handle = null;
		$this->lastErrorID = self::NO_ERROR_ID;

		$this->options = new StdClass();
		if(empty($entryMode)) $this->options->entryMode = self::ENTRY_MODE_R_PLUS;
		$this->options->entryMode = $entryMode;

		if(!empty( (bool) $fastOpen )) $this->open();
	}

	/**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @see fopen()
    *
    * @access public
	*
	* Apre il File contenuto in $this->file con modalità descritta in $this->options->entryMode. Restituisce "true" se è andato tutto a buon fine, "false" altrimenti
	**/
	public function open() {
		$this->handle = fopen($this->file, $this->options->entryMode);
		if(!empty($this->handle)) {
			$this->lastErrorID = self::NO_ERROR_ID;
			return true;
		}
		$this->lastErrorID = self::IMP_TO_OPEN_HANDLE_ERROR_ID;
		return false;
	}

	/**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @see fclose()
    *
    * @access public
	*
	* Chiude l'Handle del File. Restituisce "true" se è andato tutto a buon fine, "false" altrimenti
	**/
	public function close() {
		if( fclose($this->handle) ) {
			$this->handle = null;
			$this->lastErrorID = self::NO_ERROR_ID;
			return true;
		}
		$this->lastErrorID = self::IMP_TO_CLOSE_HANDLE_ERROR_ID;
		return false;
	}

	/**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @access public
    * @return Integer                      : Restituisce l'ultimo Codice di Errore
	**/
    public function getLastErrorID() {
        return $this->lastErrorID;
    }

	/**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @access public
	* @return Boolean                       : Restituisce "true" se il File è aperto, "false" altrimenti
	**/
	public function isOpened() {
		if(!empty($this->handle)) return true;
		return false;
	}

	/**
    * @author Pietro Terracciano
    * @since  1.0
	*
	* @see fgets()
    *
    * @access public
	* @return Boolean                       : Restituisce "true" se è possibile leggere la riga successiva contenuta nel File, "false" altrimenti
	*
	* Salva la riga successiva nella variabile $this->read->nextLine e ritorna il valore boolean se non è nulla (pertanto è possibile continuare la lettura, viceversa è EOF)
	**/
	public function hasNextLine() {
		$this->read->nextLine = fgets($this->handle);
		if($this->read->nextLine === false || empty($this->read->nextLine)) return false;
		$this->read->nextLine = trim($this->read->nextLine);
		return true;
	}

	/**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @access public
	* @return Content                       : Restituisce l'ultima riga letta dal File
	**/
	public function getNextLine() {
		return $this->read->nextLine;
	}

	/**
    * @author Pietro Terracciano
    * @since  1.0
    *
	* @see fwrite()
	* 
    * @access public
	* @param $content                       : Contenuto da scrivere nel File
	**/
	public function write($content = null) {
		if(empty($content)) return null;
		fwrite($this->handle, $content);
	}

	/**
    * @author Pietro Terracciano
    * @since  1.0
	*
	* @see $this->write()
    *
    * @access public
	* @param $content                       : Contenuto da scrivere nel File
	**/
	public function writeLine($content = null) {
		if(empty($content)) return null;
		$this->write($content."\r");
	}

	/**
    * @author Pietro Terracciano
    * @since  1.0
	*
	* @see self::_exists()
    *
    * @access public
	* @return Boolean                            : Se il File esiste restituisce "true", "false" altrimenti
	**/
	public function exists() {
		return self::_exists($this->file);
	}

    /**
    * @author Pietro Terracciano
    * @since  1.0
	*
	* @see glob()
    *
    * @access public
	* @param $pattern                       : Path con indicazioni sui Files da leggere (es. C:\...\*Class, tutti i file contenuti in C:\...\ con prefisso * e suffisso Class)
    * @param $extensions                    : Estensioni dei Files da cercare (es. php, txt, ...)
	* @param $returnAs                      : Modalità di ritorno (es. array, stringa, ...)
	* @return $files                        : Restituisce la lista dei Files trovati secondo la Modalità di ritorno richiesta
	**/
    public static function _getFromDirectories($pattern = null, $extensions = "*", $returnAs = null) {
        if(empty($pattern)) return null;
		$pattern = Utils\String::_addAbsoluteFilePath($pattern);
        if(empty($extensions)) $extensions = "*";
        if(!is_array($extensions)) $extensions = explode(',', $extensions);
		$returnAs = (int) $returnAs;

        $files = null;
		foreach($extensions as $extension) {
			$foundFiles = glob($pattern.'.'.$extension, GLOB_NOSORT);
			if(!is_array($foundFiles) || empty($foundFiles)) return null;
			foreach($foundFiles as $foundFile) {
				switch($returnAs) {
					default:
						$files[] = $foundFile;
						break;
					case 1:
						$files .= $foundFile.SEPARATOR;
						break;
				}
			}
		}
		return $files;
    }

	/**
    * @author Pietro Terracciano
    * @since  1.0
	*
	* @see unlink()
    *
    * @access public
	* @param $file 						        : File su cui viene eseguita l'azione
	* @return Boolean 							: Restituisce "true" se il File viene cancellato, "false" altrimenti
	**/
	public static function _delete($file = null) {
		if(empty($file)) return null;
		$file = Utils\String::_addAbsoluteFilePath($file);
		if(file_exists($file)) return unlink($file);
		return false;
	}

    /**
    * @author Pietro Terracciano
    * @since  1.0
	*
	* @see self::_addAbsoluteFilePath()
	* @see file_exists()
    *
    * @access public
	* @param $file                        		: File su cui viene eseguita l'azione
	* @return Boolean                           : Restituisce "true" se il File esiste, "false" altrimenti
	**/
	public static function _exists($file = null) {
		if(empty($file)) return null;
		$file = Utils\String::_addAbsoluteFilePath($file);
		if(file_exists($file)) return true;
		return false;
	}

}

?>