<?php

namespace Phiro;

/**
* @trick SECURITY
**/ 
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @see @class Phiro\Lang\Object
*   @defineIn \phiro-kernel\classes\lang\Object.php
**/
class Cache extends \Phiro\Lang\Object {

    /**
    * @since  0.170602
    *
    * @define 
    *   @param $Driver                            : Driver utilizzato / Puntatore ad una Istanza di Phiro\Cache\Drivers\%TIPO_DI_DRIVER%
    **/
    protected $Driver;

    /**
    * @author Pietro Terracciano
    * @since  0.170602
    *
    * @see 
    *   @class Phiro\Cache\Driver
    *       @definedIn \phiro-kernel\classes\cache\drivers\&Driver.php
    *   @class Phiro\Cache\Drivers\Memory
    *       @definedIn \phiro-kernel\classes\cache\drivers\File.php
    *   @class Phiro\Cache\Drivers\Session
    *       @definedIn \phiro-kernel\classes\cache\drivers\Session.php
    *
    * @access public
    * @param $paramsOrType                  : Array di Parametri OPPURE Tipologia di Driver / Cache da utilizzare
    * @param $poolName                      : Nome del Cache Pool
    *
    * Istanzia un oggetto Cache. Se non è stata specificata la tipologia di Cache, Phiro utilizza il File Cache
	**/
    final public function __construct($paramsOrType = null, $poolName = '') {
        parent::__construct();

        if(is_array($paramsOrType)) {
            $type = (!empty($paramsOrType['type'])) ? $paramsOrType['type'] : '';
            $poolName = $paramsOrType;
        } else
            $type = $paramsOrType;

        if(empty($type = trim($type))) $type = 'file';

        switch(strtolower($type)) {
            case 'database':
                break;
            default:
                $this->Driver = new Cache\Drivers\File($poolName);
                break;
        }
        $this->error = &$this->Driver->error;
    }

    final public function addToPool($key = '', $object = null) {
        $this->Driver->addToPool($key, $object);
    }

    final public function get() {
        $this->Driver->get();
    }

}

?>