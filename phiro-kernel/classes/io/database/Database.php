<?php

/**
* @see @namespace Phiro\IO
**/ 
namespace Phiro\IO;

/**
* @trick SECURITY
**/ 
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @see @namespace Phiro\Lang
**/
use Phiro\Lang;

/**
* @see @class Phiro\Lang\Object
*   @defineIn \phiro-kernel\classes\lang\Object.php
**/
class Database extends \Phiro\Lang\Object {

    /**
    * @since  0.170512
    **/
    const NO_DBMS_AVAILABLES__ERROR_ID = -1;
    const NO_DBMS_AVAILABLES__ERROR_MESSAGE = 'No DBMS availables';
    const DBMS_NOT_SUPPORTED__ERROR_ID = -2;
    const DBMS_NOT_SUPPORTED__ERROR_MESSAGE = 'DBMS not supported';
    
    /**
    * @since  0.170422
    *
    * @define 
    *   @param $Driver                            : Driver utilizzato / Puntatore ad una Istanza di Phiro\IO\Database\Drivers\%TIPO_DI_DRIVER%
    **/
    protected $Driver;

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @see 
    *   @class Phiro\IO\Database\Driver
    *       @definedIn \phiro-kernel\classes\io\database\drivers\&Driver.php
    *   @class Phiro\IO\Database\Drivers\MySQL
    *       @definedIn \phiro-kernel\classes\io\database\drivers\MySQL.php
    *   @class Phiro\IO\Database\Drivers\MariaDB
    *       @definedIn \phiro-kernel\classes\io\database\drivers\MariaDB.php &Phiro\IO\Database\Drivers\MySQL
    *   @class Phiro\IO\Database\Drivers\MySQLi
    *       @definedIn \phiro-kernel\classes\io\database\drivers\MySQLi.php 
    *   @class Phiro\IO\Database\Drivers\MySQLi
    *       @definedIn \phiro-kernel\classes\io\database\drivers\MariaDBi.php &Phiro\IO\Database\Drivers\MySQLi
    *
    * @see 
    *   @const PHIRO_DBMS                                 : DBMS da utilizzare se @param $type è vuoto
    *       @definedIn \phiro-config.php
    *       @copiedIn @global @var $PHIRO_DBMS
    *   @global @instance $PhiroServer                    : Informazioni del Server
    *       @definedIn \phiro-kernel\loader.php
    *       @instanceOf Phiro\Lang\Server
    *           @definedIn \phiro-kernel\classes\lang\Server.php
    *
    * @access public
    * @param $paramsOrName                  : Array di Parametri OPPURE Nome del Database
    * @param $host                          : Indirizzo dell'Host del Database
    * @param $userName                      : Nome utente del Database
    * @param $userPassword                  : Password utente del Database
    * @param $type                          : Tipo di Driver / DBMS da utilizzare       
    *
    * Istanzia un oggetto Database. Se non è stata specificata la tipologia di Database (es. MySQL, MsSQL, ...), Phiro preleva il valore da 
    * @const PHIRO_DBMS (che può essere inizializzata in phiro-config.php)
	**/
    final public function __construct($paramsOrName = null, $host = '', $userName = '', $userPassword = '', $type = '') {
        parent::__construct();

        if(is_array($paramsOrName))
            $type = (!empty($paramsOrName['type'])) ? $paramsOrName['type'] : '';

        /**
        * Se @param $type è vuoto, viene utilizzata la @global @var $PHIRO_DBMS
        *
        * @type CONFIG
        **/
        if(empty($type = trim($type))) {
            global $PHIRO_DBMS;
            $type = $PHIRO_DBMS;
        }

        global $PhiroServer;
        if(!$PhiroServer->isDBMSAvailable($type)) {
            $this->Driver = new Database\Drivers\Unrecognized($paramsOrName, $host, $userName, $userPassword);
            $this->Driver->setError(
                self::NO_DBMS_AVAILABLES__ERROR_ID, 
                self::NO_DBMS_AVAILABLES__ERROR_MESSAGE
            );
        } else {
            switch(strtolower($type)) {
                case 'mysql':
                    $this->Driver = new Database\Drivers\MySQL($paramsOrName, $host, $userName, $userPassword);
                    break;
                case 'mariadb':
                    $this->Driver = new Database\Drivers\MariaDB($paramsOrName, $host, $userName, $userPassword);
                    break;
                case 'mysqli':
                    $this->Driver = new Database\Drivers\MySQLi($paramsOrName, $host, $userName, $userPassword);
                    break;
                case 'mariadbi':
                    $this->Driver = new Database\Drivers\MariaDBi($paramsOrName, $host, $userName, $userPassword);
                    break;
                case 'sqlserver':
                    $this->Driver = new Database\Drivers\SQLServer($paramsOrName, $host, $userName, $userPassword);
                    break;
                default:
                    $this->Driver = new Database\Drivers\Unrecognized($paramsOrName, $host, $userName, $userPassword);
                    $this->Driver->setError(
                        self::DBMS_NOT_SUPPORTED__ERROR_ID,
                        self::DBMS_NOT_SUPPORTED__ERROR_MESSAGE
                    );
                    break;
            }
        }
        $this->error = &$this->Driver->error;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170424
    *
    * @access public
    * @return String
    *
    * Restituisce @param $Driver->DBName
    * Utilizza il Driver scelto
	**/
    final public function getName() {
        return $this->Driver->getDBName();
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170424
    *
    * @access public
    * @return String
    *
    * Restituisce @param $Driver->DBHost
    * Utilizza il Driver scelto
	**/
    final public function getHost() {
        return $this->Driver->getDBHost();
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170424
    *
    * @access public
    * @return String
    *
    * Restituisce @param $Driver->DBUserName
    * Utilizza il Driver scelto
	**/
    final public function getUserName() {
        return $this->Driver->getDBUserName();
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170424
    *
    * @access public
    * @return String
    *
    * Restituisce @param $Driver->DBUserPassword
    * Utilizza il Driver scelto
	**/
    final public function getUserPassword() {
        return $this->Driver->getDBUserPassword();
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @access public
    * @return String
    *
    * Restituisce @param $Driver->DBType
    * Utilizza il Driver scelto
	**/
    final public function getType() {
        return $this->Driver->getDBType();
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @access public
    * @return Boolean
    *
    * Restituisce "true" se la connessione al Database viene stabilita correttamente, "false" altrimenti
    * Utilizza il Driver scelto
	**/
    final public function connect() {
        return $this->Driver->DBConnect();
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170514
    *
    * @access public
    * @return Boolean
    *
    * Restituisce "true" se è stato aperto correttamente un Socket al DB, "false" altrimenti
    * Utilizza il Driver scelto
	**/
    final public function isConnected() {
        return $this->Driver->isDBConnected();
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170427
    *
    * @access public
    * @return Number
    *
    * Restituisce @param $Driver->DBSocket->connectionTime
    * Utilizza il Driver scelto
	**/
    final public function getSocketConnectionTime() { return $this->Driver->getDBSocketConnectionTime(); }
    final public function getConnectionTime() { return $this->getSocketConnectionTime(); }

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @access public
    * @return Boolean
    *
    * Restituisce "true" se la connessione al Database viene chiusa correttamente, "false" altrimenti
    * Utilizza il Driver scelto
	**/
    final public function close() {
        return $this->Driver->DBClose();
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170514
    *
    * @access public
    * @return Boolean
    *
    * Restituisce "true" se il Socket al DB è stato chiuso correttamente, "false" altrimenti
    * Utilizza il Driver scelto
	**/
    final public function isClosed() {
        return $this->Driver->isDBClosed();
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170514
    *
    * @access public
    *
    * Inizializza una Transizione
    * Utilizza il Driver scelto
	**/
    final public function beginTransaction() {
        return $this->Driver->beginDBTransaction();
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @access public
    * @param $SQL                   : SQL
    * @return Boolean
    *
    *  Effettua una Query descritta dal @param $SQL. Restituisce "true" se la Query è stata portata a termine, "false" altrimenti
    * Utilizza il Driver scelto
	**/
    final public function query($SQL = '') {
        return $this->Driver->DBQuery($SQL);
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170514
    *
    * @access public
    *
    * Inizializza una Transizione
    * Utilizza il Driver scelto
	**/
    final public function commit() {
        return $this->Driver->DBCommit();
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170514
    *
    * @access public
    *
    * Inizializza una Transizione
    * Utilizza il Driver scelto
	**/
    final public function rollback() {
        return $this->Driver->DBRollback();
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170427
    *
    * @access public
    * @return Number
    *
    * Restituisce @param $Driver->DBQuery->executionTime
    * Utilizza il Driver scelto
	**/
    final public function getQueryExecutionTime() { return $this->Driver->getDBQueryExecutionTime(); }
    final public function getQueryTime() { return $this->getQueryExecutionTime(); }

    /**
    * @author Pietro Terracciano
    * @since  0.170427
    *
    * @access public
    * @return Number
    *
    * Restituisce @param $Driver->DBQuery->fetchedFieldsNumber
    * Utilizza il Driver scelto
	**/
    final public function getQueryFetchedFieldsNumber() { return $this->Driver->getDBQueryFetchedFieldsNumber(); }
    final public function getQueryFieldsNumber() { return $this->getQueryFetchedFieldsNumber(); }
    final public function getFetchedFieldsNumber() { return $this->getQueryFetchedFieldsNumber(); }
    final public function getFieldsNumber() { return $this->getQueryFetchedFieldsNumber(); }

    /**
    * @author Pietro Terracciano
    * @since  0.170427
    *
    * @access public
    * @return Number
    *
    * Restituisce @param $Driver->DBQuery->fetchedRowsNumber
    * Utilizza il Driver scelto
	**/
    final public function getQueryFetchedRowsNumber() { return $this->Driver->getDBQueryFetchedRowsNumber(); }
    final public function getQueryRowsNumber() { return $this->getQueryFetchedRowsNumber(); }
    final public function getFetchedRowsNumber() { return $this->getQueryFetchedRowsNumber(); }
    final public function getRowsNumber() { return $this->getQueryFetchedRowsNumber(); }

    /**
    * @author Pietro Terracciano
    * @since  0.170514
    *
    * @access public
    * @return Array
    *
    * Restituisce un Array contenente i risultati "Rows" dell'ultima Query effettuata. Se non sono presenti risultati l'Array restituito è vuoto
    * Utilizza il Driver scelto
	**/
    final public function getQueryFetchedRows() { return $this->Driver->getDBQueryFetchedRows(); }
    final public function getQueryRows() { return $this->getQueryFetchedRows(); }
    final public function getRows() { return $this->getQueryFetchedRows(); }
    
    /**
    * @author Pietro Terracciano
    * @since  0.170514
    *
    * @access public
    * @return Array
    *
    * Restituisce "true" se è possibile leggere una "Row" dai risultati dell'ultima Query effettuata, "false" altrimenti
    * Utilizza il Driver scelto
	**/
    final public function hasQueryFetchedRow() { return $this->Driver->hasDBQueryFetchedRow(); }
    final public function hasQueryRow() { return $this->hasQueryFetchedRow(); }
    final public function hasRow() { return $this->hasQueryFetchedRow(); }

    /**
    * @author Pietro Terracciano
    * @since  0.170514
    *
    * @access public
    * @return Array
    *
    * Restituisce l'ultima "Row" letta dai risultati della Query
    * Utilizza il Driver scelto
	**/
    final public function getQueryFetchedRow() { return $this->Driver->getDBQueryFetchedRow(); }
    final public function getQueryRow() { return $this->Driver->getQueryFetchedRow(); }
    final public function getRow() { return $this->getQueryFetchedRow(); }

    /**
    * @author Pietro Terracciano
    * @since  0.170514
    *
    * @access public
    * @return Array
    *
    * Restituisce un Array contenente i risultati "Fields" dell'ultima Query effettuata. Se non sono presenti risultati l'Array restituito è vuoto
    * Utilizza il Driver scelto
	**/
    final public function getQueryFetchedFields() { return $this->Driver->getDBQueryFetchedFields(); }
    final public function getQueryFields() { return $this->getQueryFetchedFields(); }
    final public function getFields() { return $this->getQueryFetchedFields(); }
    
    /**
    * @author Pietro Terracciano
    * @since  0.170514
    *
    * @access public
    * @return Array
    *
    * Restituisce "true" se è possibile leggere un "Field" dai risultati dell'ultima Query effettuata, "false" altrimenti
    * Utilizza il Driver scelto
	**/
    final public function hasQueryFetchedField() { return $this->Driver->hasDBQueryFetchedField(); }
    final public function hasQueryField() { return $this->hasQueryFetchedField(); }
    final public function hasField() { return $this->hasQueryFetchedField(); }

    /**
    * @author Pietro Terracciano
    * @since  0.170514
    *
    * @access public
    * @return Array
    *
    * Restituisce l'ultimo "Field" letto dai risultati della Query
    * Utilizza il Driver scelto
	**/
    final public function getQueryFetchedField() { return $this->Driver->getDBQueryFetchedField(); }
    final public function getQueryField() { return $this->Driver->getQueryFetchedField(); }
    final public function getField() { return $this->getQueryFetchedField(); }

    /**
    * @author Pietro Terracciano
    * @since  0.170523
    *
    * @access public
    * @return String
    *
    * Restituisce un Array contenente le Tabelle del Database selezionato. Se non è presente alcuna Tabella restituisce un Array vuoto
    * Utilizza il Driver scelto
	**/
    final public function getTables() {
        return $this->Driver->getDBTables();
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170425
    *
    * @access public
    * @param $params                        : Array di Parametri
    * @return Boolean
    *
    * Effettua una Select Query. Restituisce "true" se la Query viene portata a termine, "false" altrimenti
    * Utilizza il Driver scelto
	**/
    final public function select($params = null) {
        return $this->Driver->DBSelect($params);
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170514
    *
    * @access public
    * @param $params                        : Array di Parametri
    * @return Boolean
    *
    * Effettua una Insert Query. Restituisce "true" se la Query viene portata a termine, "false" altrimenti
    * Utilizza il Driver scelto
	**/
    final public function insert($params = null) {
        return $this->Driver->DBInsert($params);
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170515
    *
    * @access public
    * @param $params                        : Array di Parametri
    * @return Boolean
    *
    * Effettua una Delete Query. Restituisce "true" se la Query viene portata a termine, "false" altrimenti
    * Utilizza il Driver scelto
	**/
    final public function delete($params = null) {
        return $this->Driver->DBDelete($params);
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170515
    *
    * @access public
    * @param $params                        : Array di Parametri
    * @return Boolean
    *
    * Effettua una Update Query. Restituisce "true" se la Query viene portata a termine, "false" altrimenti
    * Utilizza il Driver scelto
	**/
    final public function update($params = null) {
        return $this->Driver->DBUpdate($params);
    }


} 

?>