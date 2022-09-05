<?php

namespace Phiro\UI;

if(!defined('Phiro\Constants\KERNEL_DIR')) exit;

use Phiro\Lang;

class Partials extends Lang\AbstractCaller { }
class Widgets extends Lang\AbstractCaller { }

namespace Phiro;

class UI extends Lang\AbstractCaller { 
    public $Partials;
    public $Partial;
    public $Widgets;
    public $Widget;

    public function __construct() {
        $className = get_class($this);
        if($className == 'Phiro\UI') {
            $this->Partials = $this->Partial = new UI\Partials();
            $this->Widgets = $this->Widget = new UI\Widgets();
        }
    }
}


global $PhiroUI;
$PhiroUI = new UI();

?>