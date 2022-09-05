<?php

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

class Page extends \Phiro\Lang\Object {

    /**
    * @since  0.170703
    * @define
    *   @param $title               : Titolo della Pagina
    *   @param $type                : Tipologia di Pagina
    **/
    protected $title;
    protected $type;

    /**
    * @author Pietro Terracciano
    * @since  0.170703
    *
    * @access public
    * @param $params                     : Array di Parametri
    *
    * Istanzia un oggetto Page / Pagina
	**/
    public function __construct($params = null) {
        parent::__construct();

        foreach($params as $key => $value)
            $this->$key = $value;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170703
    *
    * @access public
    * @param $title                     : Titolo della Pagina
    *
    * Imposta il Titolo della Pagina
	**/
    public function setTitle($title = '') {
        $this->title = $title;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170703
    *
    * @access public
    * @param $type                     : Tipologia di Pagina
    *
    * Imposta la Tipologia di Pagina
	**/
    public function setType($type = '') {
        $this->type = $type;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170703
    *
    * @access public
    * @return String
    *
    * Restituisce il Titolo della Pagina
	**/
    public function getTitle() {
        return $this->title;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170703
    *
    * @access public
    * @return String
    *
    * Restituisce la Tipologia della Pagina
	**/
    public function getType() {
        return $this->type;
    }


}

?>