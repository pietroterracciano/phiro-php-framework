<?php

namespace Phiro\IO;

if(!defined('Phiro\Constants\KERNEL_DIR')) exit;

use Phiro\Constants;

class Database extends \Phiro\IO {

    const EXCEPTION_TAG = 'IO_DB_CLASS';

    const SKIP_EXCEPTION = true;

    const SMART_CONNECT = false;
    const FAST_CONNECT = true;

    const RETURN_AS_ARRAY = 0;
    const RETURN_AS_STRING = 1;

    const EMPTY_SOCKET_ERROR_ID = -1;
    const NO_ERROR_ID = 0; /* Nessun errore */
    const TABLE_NOT_EXISTS_ERROR_ID = 1146;
    
    private $host;
    private $name;
    private $user;
    private $password;
    private $socket;
    private $lastErrorID;
    private $skipException;

	/**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @see PhiroException
    * @see $this->connect()
    *
    * @access public
    * @param $host                          : Indirizzo dell'Host
    * @param $name                          : Nome del Database
    * @param $user                          : Utente del Database
    * @param $password                      : Password associata all'Utente del Database
    * @param $fastConnect                   : Se settato a "true" effettua subito una connessione al Database, viceversa attende l'esecuzione del metodo $this->connect()
    *
    * Istanzia un oggetto Database su cui effettuare operazioni query, get, ...
	**/
    public function __construct($name = null, $host = null, $user = null, $password = null, $fastConnect = false, $skipException = false) {
        if(!$this->skipException && empty($name)) new PhiroException('Database Name is empty', 'DBNIE', self::CLASS_TAG, PhiroException::FAST_LAUNCH);
        if(!$this->skipException && empty($host)) new PhiroException('Database Host is empty', 'DBHIE', self::CLASS_TAG, PhiroException::FAST_LAUNCH);
        if(!$this->skipException && empty($user)) new PhiroException('Database User is empty', 'DBUIE', self::CLASS_TAG, PhiroException::FAST_LAUNCH);
        //if(empty($password)) throw new PhiroException('Database Password is empty', 'DBPIE', 'DB_CLASS');

        $this->host = $host;
        $this->user = $user;
        $this->password = $password;
        $this->name = $name;

        $this->lastErrorID = self::EMPTY_SOCKET_ERROR_ID;

        if(empty($skipException)) $this->skipException = false;
        else $this->skipException = true;

        if(!empty($fastConnect)) $this->connect();
    }

	/**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @see mysqli_connect()
    * @see PhiroException
    *
    * @access public
    *
    * Effettua la connessione al Database
	**/
    public function connect() {
        $this->socket = mysqli_connect(
            $this->host, 
            $this->user, 
            $this->password, 
            $this->name
        );

        if(empty($this->socket)) {
            if(!$this->skipException) new PhiroException('Impossible to connect to Database', 'ITCTD', self::CLASS_TAG, PhiroException::FAST_LAUNCH);
            else $this->lastErrorID = self::EMPTY_SOCKET_ERROR_ID;
        }
    }

    /**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @see mysqli_close()
    *
    * @access public
	**/
    public function close() {
        if(!empty($this->socket)) {
            $this->socket->close();
            if(empty($this->socket->stat)) {
                $this->socket = null;
                $this->lastErrorID = self::EMPTY_SOCKET_ERROR_ID;
            }
        }
    }

    /**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @access public
    * @param $query                : Query da effettuare sul Database
    * @param $returnAs             : Modalità di ritorno (es. array, stringa, ..)
    * @return $result              : Restituisce il Risultato della Query secondo la Modalità di ritorno richiesta
	**/
    public function get($query = null, $returnAs = null) {
        if(empty($query)) return null;
        $result = null;
        if(!empty($this->socket)) {
            $queryResult = $this->socket->query(
                $query
            );
            if(empty($queryResult)) {
                $this->lastErrorID = $this->socket->errno; 
                return $result;
            }
            while($resultRow = $queryResult->fetch_row()) {
                switch($returnAs) {
                    default:
                        $result[] = (is_array($resultRow) && !empty($resultRow[1])) ? $resultRow : $resultRow[0];
                        break;
                    case 1:
                        $result .= $resultRow[0].SEPARATOR;
                        break;
                }
            }
        }
        if(empty($result)) $this->lastErrorID = $this->socket->errno; 
        return $result;
    }

    /**
    * @author Pietro Terracciano
    * @since  1.0
    *
    * @access public
    * @param $query              : Query da effettuare sul Database
    * @return $result            : Restituisce "true" se la Query è stata portata a termine, "false" altrimenti
	**/
    public function query($query = null) {
        if(empty($query)) return null;
        $result = false;
        if(!empty($this->socket)) {
            $result = $this->socket->query(
                $query
            );
            if($result === true || mysqli_error($this->socket) == 'Multiple primary key defined') $result = true;
            else $this->lastErrorID = $this->socket->errno;
        }
        return $result;
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
	**/
    public function getClientVersion() {
        if(!empty($this->socket)) 
            return $this->socket->client_version;
    }

} 

?>