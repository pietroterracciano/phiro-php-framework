<?php

namespace Phiro\Filters;

use StdClass;

class PregSplit extends Preg {

    public function __construct($regularExpression = null, $input = null) {
        if(empty($regularExpression)) return null;
        if(empty($input)) return null;
        parent::__construct($regularExpression, $input, null, Preg::MODE_SPLIT);
    }

    public function hasValues() {
        return $this->hasResults();
    }

    public function getValues() {
        return $this->getResults();
    }

    public function hasNextValue() {
        return $this->hasNextResult();
    }

    public function getNextValue() {
        return $this->getNextResult();
    }

    public function getValue($index = 0) {
        return $this->getResult($index);
    }

}

?>