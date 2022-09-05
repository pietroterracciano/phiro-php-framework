<?php

namespace Phiro\Lang;

if(!defined('Phiro\Constants\KERNEL_DIR')) exit;

use Phiro\Constants;
use Phiro\Filters;
use Phiro\IO;
use Phiro\Utils;
use StdClass;

class Rewrite {

    const FAST_REQUEST = true;
    const SMART_REQUEST = false;

    private $absoluteURI;
    private $relativeURI;
    private $options;
    private $pseudoRegExp;
    private $to;
    private $resource;
    private $queryString;

    /**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @access public
    * @param $relativeURI                           : URI da analizzare per il Rewrite
    * @param (bool) $fastRequest                    : Se "true" include automaticamente la Risorsa WWW, altrimenti attende la chiamata di $this->requestWww()
	**/
    public function __construct($relativeURI = null, $fastRequest = false) {
        if(empty($relativeURI)) return null;
        $relativeURI = str_replace(Constants\Paths\ABS_FILE, '', $relativeURI);
        $phiroRelativePath = strlen(Constants\Paths\RELATIVE);
        if($phiroRelativePath > 0) $relativeURI = substr($relativeURI, -strlen($relativeURI)+$phiroRelativePath);
        $relativeParsedURI = parse_url($relativeURI);
        if(empty($relativeParsedURI['path'])) return null;
        $this->relativeURI = $relativeParsedURI['path'];
        if(!empty($relativeParsedURI['query'])) $this->queryString = $relativeParsedURI['query'];
        else $this->queryString = null;
        $this->absoluteURI = Constants\Paths\ABS_HTTP.$this->relativeURI;
        $this->options = new StdClass();
        $this->options->fastRequest = (bool) $fastRequest;;
        $this->options->disablePHPErrorOnWww = false;
        $this->options->isFile = false;
        $this->pseudoRegExp = $this->to = $this->resource = null;
        
        $queryArray = array();

        $rewriteRulesFiles = array(
            Constants\Files\KERNEL_REWRITE_RULES,
            Constants\Files\REWRITE_RULES
        );

        foreach($rewriteRulesFiles as $rewriteRulesFile) {
            $file = new IO\File($rewriteRulesFile, IO\File::ENTRY_MODE_R_PLUS);
            if($file->open()) {
                $startRewriteRules = false;
                while($file->hasNextLine()) {
                    if($startRewriteRules) {

                        $pregSplit = new Filters\PregSplit(
                                            Utils\String::_toRegularExpression('\s+'), 
                                            $file->getNextLine()
                                        );

                        if($pregSplit->hasValues()) {
                            $pregMatchOptions = array();
                            /* $pregSplit->getValue(2) like as Rewrite Options */
                            if(!empty($pregSplit->getValue(2))) {
                                $options = explode('|', $pregSplit->getValue(2));
                                foreach($options as $option) {
                                    switch($option) {
                                        case 'DPEOO':
                                            $this->options->disablePHPErrorOnWww = true;
                                            break;
                                        case 'DCSORE':
                                            $pregMatchOptions[] = Filters\PregMatch::PATTERN_OPTION_INSENSITIVE;
                                            break;
                                        case 'R301':
                                            $this->options->isARedirect = true;
                                            break;
                                    }
                                }
                            }

                            /* $pregSplit->getValue(0) like as Rewrite Pseudo Regular Expression is Rewrite FROM */
                            if(!empty($pregSplit->getValue(0))) {
                                $pregMatch = new Filters\PregMatch(
                                                    Utils\String::_toRegularExpression($pregSplit->getValue(0)), 
                                                    $this->relativeURI, 
                                                    $pregMatchOptions
                                                );
                                if($pregMatch->hasMatches()) {
                                    $index = 0;
                                    foreach($pregMatch->getMatches() as $match) {
                                        if($index > 0) $queryArray[$index] = (!empty($match)) ? $match : null;
                                        $index++;
                                    }
                                    $this->pseudoRegExp = $pregSplit->getValue(0);
                                    /* $pregSplit->getValue(1) is Rewrite TO */
                                    if(!empty($pregSplit->getValue(1)))
                                        $this->to = $pregSplit->getValue(1);
                                    break;
                                }
                            }
                        }
                    } else if( $file->getNextLine() == '#START_REWRITE_RULES#' || $file->getNextLine() == '#START_PHIRO_REWRITE_RULES#' ) 
                        $startRewriteRules = true;
                }
                if(!empty($this->to)) break;
            }
        }

        if(!empty($this->to)) {
            $toParsedURI = parse_url($this->to);
            $queryArray = array();
            if(!empty($toParsedURI['path'])) {
                $resource = explode('.', $toParsedURI['path']);
                if(!empty($resource[1])) $this->options->isFile = true;
                $this->resource = $toParsedURI['path'];
            }
            if(!empty($toParsedURI['query']) && is_array($queryArray) ) {
                foreach($queryArray as $index => $key) {
                    $toParsedURI['query'] = str_replace(
                            array('$'.$index, '%'.$index, '$'.$index.'$', '%'.$index.'%'),
                            $key,
                            $toParsedURI['query']
                    );
                }
                $this->queryString = $toParsedURI['query'];
                parse_str($toParsedURI['query'], $GETs);
                if(is_array($GETs)) {
                    foreach($GETs as $key => $value) 
                        $_GET[$key] = $value;
                }
            }
        }

        if(  !$this->options->isFile || ( !IO\File::_exists($this->resource) && $this->options->isFile ) ) {
            $resourceFileExists = false;
            $checkIfPhiroConfigExists = true;
        } else {
            $resourceFileExists= true;
            $checkIfPhiroConfigExists = false;
        }

        $notFound = false;
        if($checkIfPhiroConfigExists && !IO\File::_exists('phiro-config.php') ) {
            $this->options->isFile = false;
            $this->resource = '/phiro/setup';
        } else if( empty($this->resource) || !$resourceFileExists ) $notFound = true; 

        if($notFound) {
            if(IO\File::_exists($resource = Constants\THEME_DIR.'/404.php')) $this->resource = $resource;
            else if(IO\File::_exists($resource = Constants\THEME_DIR.'/www/404.php')) $this->resource = $resource;
            else if(IO\File::_exists($resource = Constants\KERNEL_DIR.'/www/404.php')) $this->resource = $resource;
            else new Exception('File "404.php" not found', 'Create "404.php" file in '.Constants\THEME_DIR.' or in '.Constants\THEME_DIR.'/www for custom 404 error', null, Exception::FAST_LAUNCH, Exception::LAUNCH_AS_HTML);
        }

        if($fastRequest) $this->request();
    }

    /**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @see PhiroIo
    * @see PhiroFile
    * @see PhiroIoDatabase
    *
    * @access public
    * @return String $this->www
	**/
    public function getWww() {
        return $this->www;
    }

    /**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @see PhiroIo
    * @see PhiroIoFile
    * @see PhiroIoDatabase
    *
    * @access public
    * @return String $this->www
	**/
    public function request() {
        if($this->options->isFile) {
            if($this->options->disablePHPErrorOnWww) {
                ini_set('display_errors', 0);
                ini_set('display_startup_errors', 0);
            }
            global $PhiroFilters, $PhiroIO, $PhiroUI, $PhiroUtils;
            require_once(Utils\String::_addAbsoluteFilePath($this->resource));
        } else header('location: '.Utils\String::_addAbsoluteHttpPath($this->resource));
    }

}

?>