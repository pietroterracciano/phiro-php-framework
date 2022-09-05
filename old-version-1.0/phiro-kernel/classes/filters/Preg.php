<?php

namespace Phiro\Filters;

use StdClass;

abstract class Preg {
    const MODE_MATCH = false;
    const MODE_SPLIT = true;

    private $regularExpression;
    private $input;
    private $options;

    public function __construct($regularExpression = null, $input = null, $patternOptions = null, $mode = null) {
        if(empty($regularExpression)) return null;
        if(empty($input)) return null;
        $this->regularExpression = $regularExpression;
        $this->input = $input;
        $this->options = new StdClass();
        $this->options->mode = (int) $mode;
        $this->options->pattern = $patternOptions;
        $this->output = new StdClass();
        $this->output->nextIndex = -1;
        $this->output->nextResult = null;
        switch($this->options->mode) {
            default:
                preg_match('/'.$this->regularExpression.'/'.$this->options->pattern, $this->input, $this->output->results);
                break;
            case 1:
                $this->output->results = preg_split('/'.$this->regularExpression.'/', $this->input);
                break;
        }

    }

    final protected function hasResults() {
        if(!empty($this->output->results) && is_array($this->output->results)) return true;
        return false;
    }

    final protected function getResults() {
        return $this->output->results;
    }

    final protected function hasNextResult() {
        $nextIndex = ++$this->output->nextIndex;
        $this->output->nextResult = (!empty($this->output->results[$nextIndex])) ? $this->output->results[$nextIndex] : null;
        if(!empty($this->output->nextResult)) return true;
        return false;
    }

    final protected function getNextResult() {
        return $this->output->nextResult;
    }

    final protected function getResult($index = 0) {
        $index = (int) $index;
        return (!empty($this->output->results[$index])) ? $this->output->results[$index] : null;
    }

}

?>