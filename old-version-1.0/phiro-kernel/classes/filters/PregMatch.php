<?php

namespace Phiro\Filters;

use StdClass;

class PregMatch extends Preg {

    const PATTERN_OPTION_INSENSITIVE = 'i';

    public function __construct($regularExpression = null, $input = null, $patternOptions = null) {
        if(empty($regularExpression)) return null;
        if(empty($input)) return null;
        if(is_array($patternOptions)) $patternOptions = implode(' ',$patternOptions);
        parent::__construct($regularExpression, $input, $patternOptions);
    }

    public function hasMatches() {
        return $this->hasResults();
    }

    public function getMatches() {
        return $this->getResults();
    }

    public function hasNextMatch() {
        return $this->hasNextResult();
    }

    public function getNextMatch() {
        return $this->getNextResult();
    }

    public function getMatch($index = 0) {
        return $this->getResult($index);
    }

}

?>