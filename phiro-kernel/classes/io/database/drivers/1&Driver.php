<?php

/**
* @see @namespace Phiro\IO\Database
**/
namespace Phiro\IO\Database;

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
*   @definedIn \phiro-kernel\classes\lang\Object.php
**/
abstract class Driver extends \Phiro\Lang\Object {

    /**
    * @since  0.170422
    **/
    const DATABASE_NAME_IS_EMPTY__ERROR_ID = -1;
    const DATABASE_NAME_IS_EMPTY__ERROR_MESSAGE = 'DB Name is empty';
    const DATABASE_HOST_IS_EMPTY__ERROR_ID = -2;
    const DATABASE_HOST_IS_EMPTY__ERROR_MESSAGE = 'DB Host is empty';
    const DATABASE_USER_NAME_IS_EMPTY__ERROR_ID = -3;
    const DATABASE_USER_NAME_IS_EMPTY__ERROR_MESSAGE = 'DB User Name is empty';
    const DATABASE_USER_PASSWORD_IS_EMPTY__ERROR_ID = -4;
    const DATABASE_USER_PASSWORD_IS_EMPTY__ERROR_MESSAGE = 'DB User Password is empty';
    const IMPOSSIBLE_TO_ESTABLISH_DATABASE_CONNECTION__ERROR_ID = -5;
    const IMPOSSIBLE_TO_ESTABLISH_DATABASE_CONNECTION__ERROR_MESSAGE = 'Impossible to establish DB connection';
    const IMPOSSIBLE_TO_CLOSE_DATABASE_CONNECTION__ERROR_ID = -6;
    const IMPOSSIBLE_TO_CLOSE_DATABASE_CONNECTION__ERROR_MESSAGE = 'Impossible to close DB connection';
    const DATABASE_QUERY_PARAMS_ARE_EMPTY__ERROR_ID = -7;
    const DATABASE_QUERY_PARAMS_ARE_EMPTY__ERROR_MESSAGE = 'DB Query Params are empty';
    const DATABASE_QUERY_PARAMS_IS_NOT_AN_ARRAY__ERROR_ID = -8;
    const DATABASE_QUERY_PARAMS_IS_NOT_AN_ARRAY__ERROR_MESSAGE = 'DB Query Params is not an Array';
    const DATABASE_QUERY_PARAM_TABLEs_IS_EMPTY__ERROR_ID = -9;
    const DATABASE_QUERY_PARAM_TABLEs_IS_EMPTY__ERROR_MESSAGE = 'DB Query Param Table/Tables is empty';
    const IMPOSSIBLE_TO_CONVERT_TABLEs_DESCRIPTOR_IN_SQL_SYNTAX__ERROR_ID = -10;
    const IMPOSSIBLE_TO_CONVERT_TABLEs_DESCRIPTOR_IN_SQL_SYNTAX__ERROR_MESSAGE = 'Impossible to convert Table/Tables Descriptor in SQL syntax. Please check Descriptor\'s Structure';
    const DATABASE_QUERY_PARAM_VALUEs_IS_EMPTY__ERROR_ID = -11;
    const DATABASE_QUERY_PARAM_VALUEs_IS_EMPTY__ERROR_MESSAGE = 'DB Query Param Value/Values is empty';
    const IMPOSSIBLE_TO_CONVERT_VALUEs_DESCRIPTOR_IN_SQL_SYNTAX__ERROR_ID = -12;
    const IMPOSSIBLE_TO_CONVERT_VALUEs_DESCRIPTOR_IN_SQL_SYNTAX__ERROR_MESSAGE = 'Impossible to convert Value/Values Descriptor in SQL syntax. Please check Descriptor\'s Structure';
    const DATABASE_QUERY_SQL_IS_EMPTY__ERROR_ID = -13;
    const DATABASE_QUERY_SQL_IS_EMPTY__ERROR_MESSAGE = 'DB Query SQL is empty';
    const DATABASE_QUERY_PARAM_SET_IS_EMPTY__ERROR_ID = -14;
    const DATABASE_QUERY_PARAM_SET_IS_EMPTY__ERROR_MESSAGE = 'DB Query Param Set is empty';
    const IMPOSSIBLE_TO_CONVERT_SET_DESCRIPTOR_IN_SQL_SYNTAX__ERROR_ID = -15;
    const IMPOSSIBLE_TO_CONVERT_SET_DESCRIPTOR_IN_SQL_SYNTAX__ERROR_MESSAGE = 'Impossible to convert Set Descriptor in SQL syntax. Please check Descriptor\'s Structure';

    const FETCH_AS__ASSOCIATIVE__QUERY_OPTION = 1;
    const FETCH_AS__NUMERIC__QUERY_OPTION = 2;
    const FETCH__BOTH__QUERY_OPTION = 3;

    /**
    * @since  0.170428
    **/
    const INNER__JOIN_TYPE = 1;
    const LEFT_OUTER__JOIN_TYPE = 2;
    const RIGHT_OUTER__JOIN_TYPE = 3;
    const OUTER__JOIN_TYPE = 4;

    /**
    * @since  0.170515
    **/
    const SELECT__QUERY = 1;
    const INSERT__QUERY = 2;
    const UPDATE__QUERY = 3;
    const DELETE__QUERY = 4;

    /**
    * @since  0.170422
    * @define 
    *   @param $DBName                            : Nome del Database
    *   @param $DBHost                            : Host del Database
    *   @param $DBUserName                        : UserName del Database
    *   @param $DBUserPassword                    : UserPassword del Database
    *   @param $DBSocket                          : Database Socket (Se è stato effettuato un collegamento)
    *   @param $DBQuery                           : Database Query (Se è stata lanciata una query)
    *   @param $DBType                            : Tipologia di Database ( Driver )
    *
    * @since 0.170523
    * @define
    *   @param $DBVersion                         : Versione software del Database
    *   @param $DBSchema                          : Tabelle (Schema) presenti nel Database @param $DBName
    **/
    protected $DBName;
    protected $DBHost;
    protected $DBUserName;
    protected $DBUserPassword;
    protected $DBType;
    protected $DBVersion;
    protected $DBSocket;
    protected $DBQuery;
    protected $DBSchema;

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @see 
    *   @function strings_compare_insensitive()
    *       @definedIn \phiro-kernel\functions\...\strings_compare_insensitive.php
    *
    * @access public
    * @param $paramsOrName                    : Array di Parametri OPPURE Nome del Database
    * @param $DBHost                          : Indirizzo dell'Host del Database
    * @param $DBUserName                      : Nome utente del Database
    * @param $DBUserPassword                  : Password utente del Database      
    *
    * Istanzia un oggetto Driver di Database
	**/
    final public function __construct($paramsOrDBName = null, $DBHost = '', $DBUserName = '', $DBUserPassword = '') {
        parent::__construct();

        if(is_array($paramsOrDBName)) {
            $paramsOrDBName = recursive_array_map('trim', $paramsOrDBName);
            $this->DBName = ( !empty($paramsOrDBName['DBName'])) ? $paramsOrDBName['DBName'] : ( (!empty($paramsOrDBName['name'])) ? $paramsOrDBName['name'] : '');
            $this->DBHost = ( !empty($paramsOrDBName['DBHost'])) ? $paramsOrDBName['DBHost'] : ( (!empty($paramsOrDBName['host'])) ? $paramsOrDBName['host'] : '');
            $this->DBUserName = ( !empty($paramsOrDBName['DBUserName'])) ? $paramsOrDBName['DBUserName'] : ( (!empty($paramsOrDBName['userName'])) ? $paramsOrDBName['userName'] : '');
            $this->DBUserPassword = ( !empty($paramsOrDBName['DBUserPassword'])) ? $paramsOrDBName['DBUserPassword'] : ( (!empty($paramsOrDBName['userPassword'])) ? $paramsOrDBName['userPassword'] : '');
        } else {
            $this->DBName = trim($paramsOrDBName);
            $this->DBHost = trim($DBHost);
            $this->DBUserName = trim($DBUserName);
            $this->DBUserPassword = trim($DBUserPassword);
        }

        /**
        * Converte "localhost" in "127.0.0.1" PRIMA di effettuare la connessione al Database
        * Questo trick consente in alcuni casi di ottenere un buon aumento delle prestazioni e un tempo di connessione al DB minore
        *
        * @trick PERFORMANCE
        **/
        if( strings_compare_insensitive($this->DBHost, 'localhost') ) $this->DBHost = '127.0.0.1';
        
        $classExploded = explode('\\', $this->getClass());
        if(!empty($classExploded) && is_array($classExploded))
            $this->DBType = $classExploded[count($classExploded)-1];
        else
            $this->DBType = 'Unrecognized';

        /**
        * Utilizzando una funzione al posto di una Eccezione (Exception Object) avremo un minore consumo di risorse e overhead
        *
        * @trick PERFORMANCE
        **/
        if( !strings_compare_insensitive($this->DBType, 'Unrecognized') ) {
            if( empty($this->DBName) ) 
                $this->setError(
                    self::DATABASE_NAME_IS_EMPTY__ERROR_ID, 
                    self::DATABASE_NAME_IS_EMPTY__ERROR_MESSAGE
                );
            else if( empty($this->DBHost) ) 
                $this->setError(
                    self::DATABASE_HOST_IS_EMPTY__ERROR_ID, 
                    self::DATABASE_HOST_IS_EMPTY__ERROR_MESSAGE
                );
            else if( empty($this->DBUserName) ) 
                $this->setError(
                    self::DATABASE_USER_NAME_IS_EMPTY__ERROR_ID, 
                    self::DATABASE_USER_NAME_IS_EMPTY__ERROR_MESSAGE
                );
        } else {
            $this->DBVersion = 'Unrecognized';
            unset($this->DBSocket);
            unset($this->DBQuery);
            unset($this->DBSchema);
        }
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170514
    *
    * @access protected
    * @return Boolean
    *
    * Funzione da richiamare PRIMA della Connessione al Database. Restituisce "true" se la Connessione può continuare, "false" altrimenti
	**/
    final protected function beforeDBConnect() {
        $this->DBSocket = new \StdClass();
        if(!$this->isOnError()) $this->DBSocket->connectionTime = microtime(true);
        else {
            unset($this->DBSocket);
            unset($this->DBQuery);
        }
        return !$this->isOnError();
    }

    public abstract function DBConnect();

    /**
    * @author Pietro Terracciano
    * @since  0.170514
    *
    * @see
    *   @function number_module() OPPURE numberModule()
    *       @definedIn \phiro-kernel\functions\number\module.php
    *
    * @access protected
    *
    * Funzione da richiamare DOPO la Connessione al Database. Restituisce "true" se la Connessione può continuare, "false" altrimenti
	**/
    final protected function afterDBConnect() {
        if( !$this->isOnError() && $this->isDBConnected() ) {
            $this->DBSocket->connectionTime = number_module( microtime(true) - $this->DBSocket->connectionTime );
            $this->DBSchema = $this->getDBSchema();
        } else {
            unset($this->DBSocket);
            unset($this->DBQuery);
            unset($this->DBVersion);
            unset($this->DBSchema);
            /**
            * Utilizzando una funzione al posto di una Eccezione (Exception Object) avremo un minore consumo di risorse e overhead
            *
            * @trick PERFORMANCE
            **/
            $this->setError(
                self::IMPOSSIBLE_TO_ESTABLISH_DATABASE_CONNECTION__ERROR_ID,
                self::IMPOSSIBLE_TO_ESTABLISH_DATABASE_CONNECTION__ERROR_MESSAGE
            );
        }
        return !$this->isOnError();
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170512
    *
    * @access public
    * @return Boolean
    *
    * Restituisce "true" se è stato aperto correttamente un Socket al DB, "false" altrimenti
	**/
    final public function isDBConnected() {
        return ( !empty($this->DBSocket->resource)) ? true : false;
    }
    
    /**
    * @author Pietro Terracciano
    * @since  0.170514
    *
    * @access protected
    *
    * Funzione da richiamare PRIMA la Chiusura della Connessione al Database. Restituisce "true" se la Chiusura della Connessione può continuare, "false" altrimenti
	**/
    final protected function beforeDBClose() {
        return !$this->isOnError();
    }

    public abstract function DBClose();

    /**
    * @author Pietro Terracciano
    * @since  0.170512
    *
    * @param Boolean $isClosed                : "true" se la funzione di Callback ha chiuso il DB, "false" altrimenti
    *
    * @access protected
    *
    * Funzione da richiamare DOPO la Chiusura della Connessione al Database. Restituisce "true" se la Chiusura della Connessione può continuare, "false" altrimenti
	**/
    final protected function afterDBClose($isClosed = false) {
        if( !$this->isOnError() && $isClosed ) {
            unset($this->DBSocket);
            unset($this->DBQuery);
            unset($this->DBSchema);
            unset($this->DBVersion);
            return true;
        } else {
            /**
            * Utilizzando una funzione al posto di una Eccezione (Exception Object) avremo un minore consumo di risorse e overhead
            *
            * @trick PERFORMANCE
            **/
            $this->setError(
                self::IMPOSSIBLE_TO_CLOSE_DATABASE_CONNECTION__ERROR_ID,
                self::IMPOSSIBLE_TO_CLOSE_DATABASE_CONNECTION__ERROR_MESSAGE
            );
        }
        return false;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170512
    *
    * @access public
    * @return Boolean
    *
    * Restituisce "true" se il Socket al DB è stato chiuso correttamente, "false" altrimenti
	**/
    final public function isDBClosed() {
        return ( empty($this->DBSocket->resource) ) ? true : false;
    }

    public abstract function beginDBTransaction();

    /**
    * @author Pietro Terracciano
    * @since  0.170512
    *
    * @access protected
    * @return Boolean
    *
    * Funzione da richiamare PRIMA della Query al Database. Restituisce "true" se la Query può continuare, "false" altrimenti
	**/
    final protected function beforeDBQuery($SQL = '') {
        if($this->isOnError()) return false;
        
        $SQL = trim($SQL);

        if( !empty($SQL) ) {
            unset($this->DBQuery->tables);
            $this->DBQuery->executionTime = microtime(true);
            $this->DBQuery->SQL = $SQL;
            return true;
        } 

        unset($this->DBQuery);

        /**
        * Utilizzando una funzione al posto di una Eccezione (Exception Object) avremo un minore consumo di risorse e overhead
        *
        * @trick PERFORMANCE
        **/
        $this->setError(
            self::DATABASE_QUERY_SQL_IS_EMPTY__ERROR_ID,
            self::DATABASE_QUERY_SQL_IS_EMPTY__ERROR_MESSAGE
        );
        return false;
    }

    public abstract function DBQuery();

    /**
    * @author Pietro Terracciano
    * @since  0.170512
    *
    * @see
    *   @function number_module() OPPURE numberModule()
    *       @definedIn \phiro-kernel\functions\number\module.php
    *
    * @access protected
    * @return Boolean
    *
    * Funzione da richiamare DOPO la Query al Database. Restituisce "true" se la Query può continuare, "false" altrimenti
	**/
    final protected function afterDBQuery() {
        unset($this->DBQuery->type);
        if(!$this->isOnError()) 
            $this->DBQuery->executionTime = number_module( microtime(true) - $this->DBQuery->executionTime);
        else 
            unset($this->DBQuery->executionTime);
        
        return !$this->isOnError();
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170514
    *
    * @access public
    * @return Boolean
    *
    * Funzione da richiamare PRIMA di $this->hasDBQueryFetchedRow(). Restituisce "true" se l'azione può continuare, "false" altrimenti
	**/
    final protected function beforeHasDBQueryFetchedRow() {
        return ( !$this->isOnError() && $this->getDBQueryFetchedRowsNumber() > 0 ) ? true : false;
    }

    public abstract function hasDBQueryFetchedRow();

    /**
    * @author Pietro Terracciano
    * @since  0.170514
    *
    * @access public
    * @return Boolean
    *
    * Funzione da richiamare DOPO di $this->hasDBQueryFetchedRow(). Restituisce "true" se l'azione può continuare, "false" altrimenti
	**/
    final protected function afterHasDBQueryFetchedRow() {
        if( is_object($this->DBQuery->fetchedRow) ) $this->DBQuery->fetchedRow = (array) $this->DBQuery->fetchedRow;
        if( $this->isDBQueryOptionFetchAutoTrimEnabled() ) {
            if( is_array($this->DBQuery->fetchedRow) ) $this->DBQuery->fetchedRow = recursive_array_map('trim', $this->DBQuery->fetchedRow);
            else $this->DBQuery->fetchedRow = trim($this->DBQuery->fetchedRow);
        }
        return ( !empty( $this->DBQuery->fetchedRow) ) ? true : false;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170422  
    *
    * @access public
    * @return Array          
    *
    * Restituisce un Array contenente i risultati "Rows" dell'ultima Query effettuata. Se non sono presenti risultati l'Array restituito è vuoto
	**/
    final public function getDBQueryFetchedRows() {
        $rows = array();
        while($this->hasDBQueryFetchedRow()) $rows[] = $this->getDBQueryFetchedRow();
        return $rows;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170427
    *
    * @access public
    * @return Array          
    *
    * Restituisce l'ultima "Row" letta dai risultati della Query
	**/
    final public function getDBQueryFetchedRow() {
        return $this->DBQuery->fetchedRow;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170514
    *
    * @access public
    * @return Boolean
    *
    * Funzione da richiamare PRIMA di $this->hasDBQueryFetchedField(). Restituisce "true" se l'azione può continuare, "false" altrimenti
	**/
    final protected function beforeHasDBQueryFetchedField() {
        return ( !$this->isOnError() && $this->getDBQueryFetchedFieldsNumber() > 0 ) ? true : false;
    }

    public abstract function hasDBQueryFetchedField();

    /**
    * @author Pietro Terracciano
    * @since  0.170514
    *
    * @access public
    * @return Boolean
    *
    * Funzione da richiamare DOPO di $this->hasDBQueryFetchedField(). Restituisce "true" se l'azione può continuare, "false" altrimenti
	**/
    final protected function afterHasDBQueryFetchedField() {
        if( is_object($this->DBQuery->fetchedField) ) $this->DBQuery->fetchedField = (array) $this->DBQuery->fetchedField;
        if( $this->isDBQueryOptionFetchAutoTrimEnabled() ) {
            if( is_array($this->DBQuery->fetchedField) ) $this->DBQuery->fetchedField = recursive_array_map('trim', $this->DBQuery->fetchedField);
            else $this->DBQuery->fetchedField = trim($this->DBQuery->fetchedField);
        }
        if( !empty($this->DBQuery->fetchedField) ) {
            if(is_array($this->DBQuery->fetchedField) ) {
                switch( (!empty($this->DBQuery->options->fetchAs)) ? $this->DBQuery->options->fetchAs : self::FETCH_AS__ASSOCIATIVE__QUERY_OPTION ) {
                    case self::FETCH_AS__NUMERIC__QUERY_OPTION:
                        $tFetchedField = array();
                        foreach($this->DBQuery->fetchedField as $key => $value) $tFetchedField[] = $value;
                        $this->DBQuery->fetchedField = $tFetchedField;
                        break;
                    case self::FETCH__BOTH__QUERY_OPTION:
                        $tFetchedField = array();
                        foreach($this->DBQuery->fetchedField as $key => $value) {
                            $tFetchedField[] = $value;
                            $tFetchedField[$key] = $value;
                        }
                        $this->DBQuery->fetchedField = $tFetchedField;
                        break;
                    default:
                        break;
                }
            }
            return true;
        }
        return false;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170428
    *
    * @access public
    * @return Array          
    *
    * Restituisce un Array contenente i risultati "Fields" dell'ultima Query effettuata. Se non sono presenti risultati l'Array restituito è vuoto
	**/
    final public function getDBQueryFetchedFields() {
        $fields = array();
        while($this->hasQueryField()) $fields[] = $this->getDBQueryFetchedField();
        return $fields;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170428
    *
    * @access public
    * @return Array          
    *
    * Restituisce l'ultimo "Field" letta dai risultati della Query
	**/
    final public function getDBQueryFetchedField() {
        return $this->DBQuery->fetchedField;
    }

    public abstract function DBCommit();

    public abstract function DBRollback();

    /**
    * @author Pietro Terracciano
    * @since  0.170523
    *
    * @access protected
    * @return Array          
    *
    * Esegue una Select Query per ottenere le Tabelle (Schema) presenti nel Database selezionato
	**/
    final protected function getDBSchema() {
        $this->DBQuery = new \StdClass();
        $schema = array();
        
        if (
            $this->DBSelect(
                [
                    'tables' => 'INFORMATION_SCHEMA.TABLES, INFORMATION_SCHEMA.COLUMNS',
                    'field' => '*',
                    'where' => [
                        [
                            [
                                'field' => 'TABLE_SCHEMA',
                                'value' => $this->DBName,
                            ]
                        ]
                    ]
                ]
            )
        ) {
            while($this->hasDBQueryFetchedRow()) {
                
                $table = $this->getDBQueryFetchedRow();
                print_R($table);
                $schema[$table['TABLE_NAME']] = array(
                    'type' => $table['TABLE_TYPE'],
                    'engine' => $table['ENGINE'],
                    'rowsNumber' => $table['TABLE_ROWS'],
                    'collation' => $table['TABLE_COLLATION']
                );

            }
        }
        return $schema;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170509
    *
    * @access public
    * @param $params                        : Array di Parametri
    * @return Boolean
    *
    * Effettua una Select Query. Restituisce "true" se la Query viene portata a termine, "false" altrimenti
	**/
    final public function DBSelect($params = null) {
        if( !$this->checkQueryDescriptor($params) ) return false;

        $this->DBQuery->type = self::SELECT__QUERY;

        $tablesSQL = $fieldsSQL = $whereSQL = $joinsSQL = $limitSQL = $lockSQL = '';

        /**
        * Genera l'SQL delle Tabelle a partire da @param $params['tables'] OPPURE $params['table']
        **/
        $isNecessary = true;
        if( !empty($params['tables']) ) {
            $singularParam = false;
            $paramsTables = $params['tables'];
        } else if ( !empty($params['table']) ) {
            $singularParam = true;
            $paramsTables = $params['table'];
        } else {
            $singularParam = false;
            $paramsTables = '';
        }
        $tablesSQL .= $this->buildTablesSQL( $paramsTables, $singularParam, $isNecessary );
        if( $isNecessary && empty($tablesSQL) ) return false;

        /**
        * Genera l'SQL dei Campi a partire da @param $params['fields'] OPPURE $params['field']
        **/
        $singularParam = false;
        $fieldsSQL .= $this->buildFieldsSQL( (!empty($params['fields'])) ? $params['fields'] : ( ( $singularParam = !empty($params['field'])) ? $params['field'] : ''), (!empty($singularParam)) ? $singularParam : false  );

        /**
        * Genera l'SQL del Where a partire da @param $params['where']
        **/
        $whereSQL .= $this->buildWhereSQL( (!empty($params['where'])) ? $params['where'] : '' );

        /**
        * Genera l'SQL delle Joins a partire da @param $params['innerJoins'], @param $params['leftOuterJoins'], @param $params['rightOuterJoins'], @param $params['outerJoins']
        **/
        $joinsSQL .= $this->buildJoinSQL( (!empty($params['innerJoins'])) ? $params['innerJoins'] : '', self::INNER__JOIN_TYPE);
        $joinsSQL .= $this->buildJoinSQL( (!empty($params['leftOuterJoins'])) ? $params['leftOuterJoins'] : '', self::LEFT_OUTER__JOIN_TYPE);
        $joinsSQL .= $this->buildJoinSQL( (!empty($params['rightOuterJoins'])) ? $params['rightOuterJoins'] : '', self::RIGHT_OUTER__JOIN_TYPE);
        $joinsSQL .= $this->buildJoinSQL( (!empty($params['outerJoins'])) ? $params['outerJoins'] : '', self::OUTER__JOIN_TYPE);

        /**
        * Genera l'SQL del Limit a partire da @param $params['limit']
        **/
        $limitSQL .= $this->buildLimitSQL( ( isset($params['limit']) ) ? $params['limit'] : '');

        /**
        * Genera l'SQL del Lock a partire da @param $params['lock']
        **/
        $lockSQL .= $this->buildLockSQL( ( !empty($params['lock']) ) ? $params['lock'] : '');

        return $this->DBQuery(
            'SELECT '.$fieldsSQL.' FROM '.$tablesSQL.
            ( (!empty($joinsSQL)) ? ' '.$joinsSQL : '').
            ( (!empty($whereSQL)) ? ' WHERE '.$whereSQL : '').
            ( (!empty($limitSQL) || (isset($limitSQL) && is_positive_number($limitSQL) ) ) ? ' LIMIT '.$limitSQL : '').
            ( (!empty($lockSQL)) ? ' '.$lockSQL : ''));
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170509
    *
    * @access public
    * @param $params                        : Array di Parametri
    * @return Boolean
    *
    * Effettua una Insert Query. Restituisce "true" se la Query viene portata a termine, "false" altrimenti
	**/
    final public function DBInsert($params = null) {
        if( !$this->checkQueryDescriptor($params) ) return false;

        $this->DBQuery->type = self::INSERT__QUERY;

        $tablesSQL = $fieldsSQL = $valuesSQL = '';

        $isNecessary = true;
        $singularParam = true;

        /**
        * Genera l'SQL delle Tabelle a partire da @param $params['tables'] OPPURE @param $params['table']
        * Viene considerata SOLO la prima tabella contenuta nei parametri
        **/
        if( !empty($params['table']) ) 
            $paramsTables = $params['table'];
        else if ( !empty($params['tables']) ) 
            $paramsTables = $params['tables'];
        else
            $paramsTables = '';
        $tablesSQL .= $this->buildTablesSQL( $paramsTables, $singularParam, $isNecessary );
        if( $isNecessary && empty($tablesSQL) ) return false;

        /**
        * @see
        *   @function strings_compare_insensitive() OPPURE stringsCompareInsensitive()
        *       @definedIn \phiro-kernel\functions\strings\compareInsensitive.php
        *
        * Genera l'SQL dei Campi a partire da @param $params['fields'] OPPURE $params['field']
        **/
        if( !empty($params['fields']) ) {
            $singularParam = false;
            $paramsTables = $params['fields'];
        } else if ( !empty($params['field']) )
            $paramsTables = $params['field'];
        else
            $paramsTables = '';
        $fieldsSQL .= $this->buildFieldsSQL( $paramsTables, $singularParam );
        if( strings_compare_insensitive($fieldsSQL, '*') ) $fieldsSQL = '';

        $valuesSQL = $this->buildValuesSQL( (!empty($params['values'])) ? $params['values'] : '', $isNecessary );
        if( $isNecessary && empty($valuesSQL) ) return false;

        return $this->DBQuery('INSERT INTO `'.$tablesSQL.'`'.( (!empty($fieldsSQL)) ? ' ('.$fieldsSQL.')' : '').' VALUES '.$valuesSQL);
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170516
    *
    * @access public
    * @param $params                        : Array di Parametri
    * @return Boolean
    *
    * Effettua una Update Query. Restituisce "true" se la Query viene portata a termine, "false" altrimenti
	**/
    final public function DBUpdate($params = null) {
        if( !$this->checkQueryDescriptor($params) ) return false;

        $this->DBQuery->type = self::UPDATE__QUERY;

        $tablesSQL = $setSQL = $whereSQL = '';

        $isNecessary = true;
        $singularParam = true;

        /**
        * Genera l'SQL delle Tabelle a partire da @param $params['tables'] OPPURE @param $params['table']
        * Viene considerata SOLO la prima tabella contenuta nei parametri
        **/
        if( !empty($params['table']) ) 
            $paramsTables = $params['table'];
        else if ( !empty($params['tables']) ) 
            $paramsTables = $params['tables'];
        else
            $paramsTables = '';
        $tablesSQL .= $this->buildTablesSQL( $paramsTables, $singularParam, $isNecessary );
        if( $isNecessary && empty($tablesSQL) ) return false;

        /**
        * Genera l'SQL del Set a partire da @param $params['set']
        **/
        $setSQL .= $this->buildSetSQL( (!empty($params['set'])) ? $params['set'] : '', $isNecessary);
        if( $isNecessary && empty($setSQL)) return false;

        /**
        * Genera l'SQL del Where a partire da @param $params['where']
        **/
        $whereSQL .= $this->buildWhereSQL( (!empty($params['where'])) ? $params['where'] : '' );

        return $this->DBQuery('UPDATE `'.$tablesSQL.'` SET '.$setSQL.( (!empty($whereSQL)) ? ' WHERE '.$whereSQL : '') );
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170512
    *
    * @access public
    * @param $descriptor                        : Descrittore della Query
    *
    * Se il Descrittore della Query ha una sintassi corretta vengono create le Strutture dati della Query e viene restituito "true", "false" altrimenti
	**/
    final private function checkQueryDescriptor($descriptor = null) {
        /**
        * Utilizzando una funzione al posto di una Eccezione (Exception Object) avremo un minore consumo di risorse e overhead
        *
        * @trick PERFORMANCE
        **/
        if(empty($descriptor))
            $this->setError(self::DATABASE_QUERY_PARAMS_ARE_EMPTY__ERROR_ID, self::DATABASE_QUERY_PARAMS_ARE_EMPTY__ERROR_MESSAGE);
        else if( !is_array($descriptor) )
            $this->setError(self::DATABASE_QUERY_PARAMS_IS_NOT_AN_ARRAY__ERROR_ID, self::DATABASE_QUERY_PARAMS_IS_NOT_AN_ARRAY__ERROR_MESSAGE);
        
        if($this->isOnError()) 
            return false;

        $this->DBQuery = new \StdClass();
        $this->checkQueryOptions( (!empty($descriptor['options']) ) ? $descriptor['options'] : '');
        $this->DBQuery->tables = new \StdClass();

        return true;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170512
    *
    * @access public
    * @param $descriptor                        : Descrittore delle Opzioni
    *
    * Imposta le Opzioni della Query
	**/
    final private function checkQueryOptions($descriptor = null) {
        $this->DBQuery->options = new \StdClass();
        
        if( is_array($descriptor) ) $descriptor = recursive_array_map('trim', $descriptor);

        /**
        * Utilizzando un Tipo di Dato Enumerativo si ottengono maggiori prestazioni
        *
        * @trick PERFORMANCE
        **/
        switch( (!empty($descriptor['fetchAs'])) ? strtolower($descriptor['fetchAs']) : self::FETCH_AS__ASSOCIATIVE__QUERY_OPTION ) {
            case self::FETCH_AS__NUMERIC__QUERY_OPTION: case 'index': case 'numeric': case 'indexes':
                $this->DBQuery->options->fetchAs = self::FETCH_AS__NUMERIC__QUERY_OPTION;
                break;
            case self::FETCH__BOTH__QUERY_OPTION: case 'both':
                $this->DBQuery->options->fetchAs = self::FETCH__BOTH__QUERY_OPTION;
                break;
            default:
                $this->DBQuery->options->fetchAs = self::FETCH_AS__ASSOCIATIVE__QUERY_OPTION;
                break;
        }

        $this->DBQuery->options->SQLAutoTrim = ( (!empty($descriptor['SQLAutoTrim'])) ? (bool) $descriptor['SQLAutoTrim'] : false);

        $this->DBQuery->options->fetchAutoTrim = ( (!empty($descriptor['fetchAutoTrim'])) ? (bool) $descriptor['fetchAutoTrim'] : false);
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170503
    *
    * @access public
    * @param $descriptor                                : Descrittore delle Tabelle
    * @param Boolean $singular                          : Se "true" restituisce l'SQL della prima Tabella
    * @param Boolean $isNecessary                       : Se "true" lo script genera errori in quanto la Risorsa è obbligatoria
    * @return String
    *
    * Genera e restituisce l'SQL a partire dal @param $descriptor 
    * (Solitamente contenuto in $params['tables'] OPPURE $params['table'])
	**/
    final private function buildTablesSQL($descriptor = null, $singular = false, $isNecessary = false) {
        $SQL = '';
        $singular = (bool) $singular;
        $isNecessary = (bool) $isNecessary;

        if(empty($descriptor)) {
            if($isNecessary) {
                /**
                * Utilizzando una funzione al posto di una Eccezione (Exception Object) avremo un minore consumo di risorse e overhead
                *
                * @trick PERFORMANCE
                **/
                $this->setError(self::DATABASE_QUERY_PARAM_TABLEs_IS_EMPTY__ERROR_ID, self::DATABASE_QUERY_PARAM_TABLEs_IS_EMPTY__ERROR_MESSAGE);
            }
            return $SQL;
        }

        if(!is_array($descriptor)) $descriptor = preg_split('/\||\,/', $descriptor );

        $descriptor = recursive_array_map('trim', $descriptor);
        foreach($descriptor as $key => $value) {
            $tSQL = '';
            if( !is_numeric($key) && !empty($key = trim($key)) ) {
                $table = '';
                $tSQL .= $key.' AS ';
                if( !is_array($value) )
                    $tSQL .= $table = $value;
                else if ( !empty($value['as']) )
                    $tSQL .= $table = $value['as'];
                else
                    $tSQL = '';
            } else {
                if(is_array($value)) $value = $value[0];
                $tSQL .= $value;
            }
            
            if(!empty($tSQL = trim($tSQL)) && $this->addQueryTable($tSQL) )
                $SQL .= $tSQL.', ';
        }

        if( !empty($SQL) ) {
            if(strlen($SQL) > 2) 
                $SQL = trim( substr($SQL, 0, -2) );
            if($singular) {
                $SQL = explode(',', $SQL);
                $SQL = $SQL[0]; 
            }
        } else if($isNecessary) {
            /**
            * Utilizzando una funzione al posto di una Eccezione (Exception Object) avremo un minore consumo di risorse e overhead
            *
            * @trick PERFORMANCE
            **/
            $this->setError(self::IMPOSSIBLE_TO_CONVERT_TABLEs_DESCRIPTOR_IN_SQL_SYNTAX__ERROR_ID, self::IMPOSSIBLE_TO_CONVERT_TABLEs_DESCRIPTOR_IN_SQL_SYNTAX__ERROR_MESSAGE);
        }

        return $SQL;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170503
    *
    * @access public
    * @param String $tableDescriptor                        : Descrittore della Tabella
    * @return Boolean
    *
    * Restituisce "true" se la Tabella contenuta nel Descrittore viene aggiunta alle Tabelle della Query, "false" altrimenti
	**/
    final private function addQueryTable($tableDescriptor = null) {
        if(empty($tableDescriptor) && !is_string($tableDescriptor) ) return false;
        $explodedTableDescriptor = recursive_array_map('trim', preg_split('/\bas\b/i', $tableDescriptor));
        if( count($explodedTableDescriptor) == 1 && !empty($explodedTableDescriptor[0]) ) {
            $this->DBQuery->tables->$explodedTableDescriptor[0] = $explodedTableDescriptor[0];
            return true;
        } else if( count($explodedTableDescriptor) >= 2 && !empty($explodedTableDescriptor[0]) && !empty($explodedTableDescriptor[1]) ) {
            $this->DBQuery->tables->$explodedTableDescriptor[0] = $explodedTableDescriptor[1]; 
            return true;
        }
        return false;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170503
    *
    * @access public
    * @param String $tableDescriptor                        : Descrittore della Tabella
    * @return Boolean
    *
    * Restituisce "true" se @param $pattern contiene una Tabella della Query, "false" altrimenti
	**/
    final private function hasQueryTable($pattern = null) {
        if(empty($pattern) || !is_string($pattern) || is_numeric($pattern) ) return false;

        $explodedPattern = explode('.', $pattern);
        if( count($explodedPattern) > 1 && ( in_array($explodedPattern[0], (array) $this->DBQuery->tables) || array_key_exists($explodedPattern[0], (array) $this->DBQuery->tables)) ) 
            return true;

        return false;

    }

    /**
    * @author Pietro Terracciano
    * @since  0.170503
    *
    * @access public
    * @param $descriptor                                : Descrittore dei Campi
    * @param Boolean $singular                          : Se "true" restituisce l'SQL del primo Campo
    * @return String
    *
    * Genera e restituisce l'SQL a partire dal @param $fields
    * (Solitamente contenuto in $params['fields'])
	**/
    final private function buildFieldsSQL($descriptor = null, $singular = false) {
        if( empty($descriptor) ) return '*';

        $singular = (bool) $singular;
        $SQL = '';
        if(!is_array($descriptor)) $descriptor = preg_split('/\||\,/', $descriptor );

        $descriptor = recursive_array_map('trim', $descriptor);
        foreach($descriptor as $key => $value) {
            $tSQL = '';
            if( !is_numeric($key) && !empty($key = trim($key)) ) {
                if( !is_array($value) )
                    $tSQL .= $key.' AS '.$value;
                else {
                    if( !empty($value['table']) ) {
                        $tableKey = $value['table'].'.';
                        $tableValue = $value['table'].'_';
                    } else $tableKey = $tableValue = '';

                    if( !empty($value['as']) )
                        $value = $value['as'];
                    else
                        $value = $key;

                    if (!empty($key) && !empty($value)) {
                        if(!strings_compare($key, $value))
                            $tSQL .= $tableKey.$key.' AS '.$tableValue.$value;
                        else
                            $tSQL .= $value;
                    } else
                        $tSQL = '';
                }
            } else {
                if(is_array($value)) $value = $value[0];
                $tSQL .= $value;
            }
            
            if( !empty($tSQL = trim($tSQL)) )
                $SQL .= $tSQL.', ';
        }

        if( !empty($SQL) ) {
            if(strlen($SQL) > 2) 
                $SQL = trim( substr($SQL, 0, -2) );
            if($singular) {
                $SQL = explode(',', $SQL);
                $SQL = $SQL[0]; 
            }
        } else $SQL = '*';
        
        return $SQL;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170508
    *
    * @access public
    * @param $descriptor                        : Descrittore del Where
    * @return String
    *
    * Genera e restituisce l'SQL a partire dal @param $descriptor 
    * (Solitamente contenuto in $params['where'])
	**/
    final private function buildWhereSQL($descriptor = null) {
        $SQL = '';
        if( empty($descriptor) || !is_array($descriptor) ) return $SQL;

        if($this->isDBQueryOptionSQLAutoTrimEnabled()) $descriptor = recursive_array_map('trim', $descriptor);

        /**
        * @param $descriptor             : Descrive Gruppi di Campi + Relazione tra i Gruppi
        *
        * @example
        *   ( 
        *       %GROUP% => (...)
        *   )
        *   %GROUP_RELATION%
        *   (
        *       %GROUP => (...)
        *   )  
        *   ...
        **/
        foreach($descriptor as $iKey => $iValue) {
            /**
            * @var $iValue                : Descrive un Gruppo di Campi + Relazione tra i Campi
            * @example
            *   %GROUP% => ( 
            *       %FIELD% => (...)
            *       %FIELD_RELATION%
            *       %FIELD% => (...)
            *       ...
            *   )
            **/
            $itSQL = '';
            $iRelation = 'AND';
            if(is_array($iValue)) {
                $jRelation = 'AND';
                foreach($iValue as $jKey => $jValue) {
                    /**
                    * @var $jValue                : Descrive un Campo + Operatore
                    **/
                    $jtSQL = '';
                    if(is_array($jValue) && !empty($jValue['field']) ) {
                        if( $this->hasQueryTable($jValue['field']) )
                            $jtSQL .= $jValue['field'];
                        else
                            $jtSQL .= '`'.$jValue['field'].'`';
                        $jtSQL .= ' ';

                        $skipjValue = false;

                        /**
                        * Non possiamo utilizzare le Enumerazioni perchè l'Operatore viene inserito nell'array Descrittore @param $descriptor
                        **/
                        switch( (!empty($jValue['operator'])) ? strtolower($jValue['operator']) : '' ) {
                            default:
                                $jOperator = '=';
                                break;
                            case '!=': case '<>': case 'not equal': case 'not': case 'is not':
                                $jOperator = '<>';
                                break;
                            case 'like': case 'as like':
                                $jOperator = 'LIKE';
                                break;
                            case 'greater than': case '>':
                                $jOperator = '>';
                                break;
                            case 'less than': case '<':
                                $jOperator = '<';
                                break;
                            case '>=':
                                $jOperator = '>=';
                                break;
                            case '<=':
                                $jOperator = '<=';
                                break;
                            case 'not null': case '!= null': case 'is not null': case '<> null':
                                $jOperator = 'IS NOT NULL';
                                $skipjValue = true;
                                break;
                            case 'null': case '= null': case 'is null': case '== null':
                                $jOperator = 'IS NULL';
                                $skipjValue = true;
                                break;
                        }         

                        if(!$skipjValue) {
                            if(empty($jValue['value'])) $jValue['value'] = '';

                            if( is_numeric($jValue['value']) || $this->hasQueryTable($jValue['value']) )
                                $jtSQL .= $jOperator.' '.$jValue['value'];
                            else 
                                $jtSQL .= $jOperator." '".$jValue['value']."'";
                        } else
                            $jtSQL .= $jOperator;
                            
                        $jtSQL .= ' ';
                    } else if( !is_array($jValue) && !empty($jValue) && strings_compare_insensitive($jKey, 'relation') ) {
                        switch(strtolower($jValue)) {
                            case 'or': case '||': case '|':
                                $jRelation = 'OR';
                                break;
                            default:
                                break;
                        }
                    }
                    
                    if( !empty($jtSQL = trim($jtSQL)) )
                        $itSQL .= $jtSQL.' %J_REL% ';
                }
            } else if( !is_array($iValue) && !empty($iValue) && strings_compare_insensitive($iKey, 'relation') ) {
                switch(strtolower($iValue)) {
                    case 'or': case '||': case '|':
                        $iRelation = 'OR';
                        break;
                    default:
                        break;
                }
            }

            if( !empty($itSQL = trim($itSQL)) )
                $SQL .= str_replace('%J_REL%', $jRelation, '( '. ( (strlen($itSQL) > 8) ? substr($itSQL, 0, -8 ) : $itSQL ).' ) %X_REL% ' );
        }

        if( !empty( $SQL = trim($SQL) ) )
            return str_replace('%X_REL%', $iRelation, ( (strlen($SQL) > 8) ? substr($SQL, 0, -8 ) : $SQL ) );
        return $SQL;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170516
    *
    * @access public
    * @param $descriptor                        : Descrittore del Set
    * @param $isNecessary                       : Se "true" lo script genera errori in quanto la Risorsa è obbligatoria
    * @return String
    *
    * Genera e restituisce l'SQL a partire dal @param $descriptor 
    * (Solitamente contenuto in $params['set'])
	**/
    final private function buildSetSQL($descriptor = null, $isNecessary = false) {
        $SQL = '';
        if( empty($descriptor) || !is_array($descriptor) ) {
            if($isNecessary) {
                /**
                * Utilizzando una funzione al posto di una Eccezione (Exception Object) avremo un minore consumo di risorse e overhead
                *
                * @trick PERFORMANCE
                **/
                $this->setError(self::DATABASE_QUERY_PARAM_SET_IS_EMPTY__ERROR_ID, self::DATABASE_QUERY_PARAM_SET_IS_EMPTY__ERROR_MESSAGE);
            }
            return $SQL;
        }

        if($this->isDBQueryOptionSQLAutoTrimEnabled()) $descriptor = recursive_array_map('trim', $descriptor);

        if(count($descriptor) > 1) $descriptor = array( $descriptor );
        
        $SQL .= str_replace(array(' OR ', ' AND '), ', ', $this->buildWhereSQL( $descriptor ) );
        if( !empty($SQL = trim($SQL)) ) 
            return trim( ( ( strlen($SQL) > 2 ) ? substr($SQL, 1, -1) : $SQL) );
        else if( $isNecessary ) {
            /**
            * Utilizzando una funzione al posto di una Eccezione (Exception Object) avremo un minore consumo di risorse e overhead
            *
            * @trick PERFORMANCE
            **/
            $this->setError(self::IMPOSSIBLE_TO_CONVERT_SET_DESCRIPTOR_IN_SQL_SYNTAX__ERROR_ID, self::IMPOSSIBLE_TO_CONVERT_SET_DESCRIPTOR_IN_SQL_SYNTAX__ERROR_MESSAGE);
        }
        return $SQL;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170516
    *
    * @access public
    * @param $descriptor                        : Descrittore del Values
    * @param Boolean $isNecessary               : Se "true" lo script genera errori in quanto la Risorsa è obbligatoria
    * @return String
    *
    * Genera e restituisce l'SQL a partire dal @param $descriptor 
    * (Solitamente contenuto in $params['values'])
	**/
    final private function buildValuesSQL($descriptor = null, $isNecessary = false) {
        $SQL = '';
        $isNecessary = (bool) $isNecessary;
        if( empty($descriptor) || !is_array($descriptor) ) {
            if($isNecessary) {
                /**
                * Utilizzando una funzione al posto di una Eccezione (Exception Object) avremo un minore consumo di risorse e overhead
                *
                * @trick PERFORMANCE
                **/
                $this->setError(self::DATABASE_QUERY_PARAM_VALUEs_IS_EMPTY__ERROR_ID, self::DATABASE_QUERY_PARAM_VALUEs_IS_EMPTY__ERROR_MESSAGE);
            }
            return $SQL;
        }

        if($this->isDBQueryOptionSQLAutoTrimEnabled()) $descriptor = recursive_array_map('trim', $descriptor);

        foreach($descriptor as $iKey => $iValue) {
            if( is_array($iValue) ) {
                $jtSQL = '';
                foreach($iValue as $jKey => $jValue)
                    $jtSQL .= "'".$jValue."', ";
                if( !empty($jtSQL = trim($jtSQL)) )
                    $SQL .= '('.( (strlen($jtSQL) > 1) ? substr($jtSQL, 0, -1) : $jtSQL ).'), ';
            }
        }
        
        if( !empty($SQL = trim($SQL)) ) 
            $SQL = (strlen($SQL) > 1) ? substr($SQL, 0, -1) : $SQL;
        else if( $isNecessary ) {
            /**
            * Utilizzando una funzione al posto di una Eccezione (Exception Object) avremo un minore consumo di risorse e overhead
            *
            * @trick PERFORMANCE
            **/
            $this->setError(self::IMPOSSIBLE_TO_CONVERT_VALUEs_DESCRIPTOR_IN_SQL_SYNTAX__ERROR_ID, self::IMPOSSIBLE_TO_CONVERT_VALUEs_DESCRIPTOR_IN_SQL_SYNTAX__ERROR_MESSAGE);
        }
        return $SQL;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170512
    *
    * @access public
    * @param $descriptor                        : Descrittore del Join
    * @param $type                              : Tipologia di Join
    * @return String
    *
    * Genera e restituisce l'SQL a partire dal @param $descriptor 
    * (Solitamente contenuto in $params['innerJoin'] OPPURE $params['leftOuterJoin'] OPPURE $params['rightOuterJoin'] OPPURE $params['outerJoin'])
	**/
    final private function buildJoinSQL($descriptor = null, $type = '') {
        $SQL = '';
        if(empty($descriptor) || !is_array($descriptor) ) return $SQL;

        if($this->isDBQueryOptionSQLAutoTrimEnabled()) $descriptor = recursive_array_map('trim', $descriptor);

        /**
        * @param $descriptor             : Descrive Gruppi di Join
        *
        * @example
        *   ( 
        *       %GROUP% => (...)
        *   )
        *   (
        *       %GROUP => (...)
        *   )  
        *   ...
        *
        * E' necessario effettuare un doppio foreach
        * Il primo loop serve a mappare le Tabelle nella Query : qualora ci sia corrispondenza tra Attributo e Campo di una Tabella, l'SQL viene tradotta correttamente
        **/
        $tSQLs = array();
        foreach($descriptor as $iKey => $iValue) {
            if( is_array($iValue) && !empty($iValue['table']) ) 
                $tSQLs[] = $this->buildTablesSQL($iValue['table'], true);
        }
        $i = 0;
        foreach($descriptor as $iKey => $iValue) {
            if( !empty($tSQLs[$i]) ) {
                $tSQL = $this->buildWhereSQL( (!empty($iValue['on'])) ? $iValue['on'] : '');
                $SQL .= '%JOI_TYP% '.$tSQLs[$i].( (!empty($tSQL)) ? ' ON '.$tSQL : '').' ';
            }
            $i++;
        }

        if( !empty( $SQL = trim($SQL) ) ) {
            /**
            * Utilizzando un Tipo di Dato Enumerativo si ottengono maggiori prestazioni
            *
            * @trick PERFORMANCE
            **/
            switch(trim($type)) {
                default: 
                    $type = 'INNER JOIN';
                    break;
                case self::LEFT_OUTER__JOIN_TYPE:
                    $type = 'LEFT JOIN';
                    break;
                case self::RIGHT_OUTER__JOIN_TYPE:
                    $type = 'RIGHT JOIN';
                    break;
                case self::OUTER__JOIN_TYPE:
                    $type = 'FULL JOIN';
                    break;
            }
            return str_replace('%JOI_TYP%', $type, $SQL);
        }
        return $SQL;
    }


    /**
    * @author Pietro Terracciano
    * @since  0.170514
    *
    * @see
    *   @function is_positive_number() OPPURE isPositiveNumber()
    *       @definedIn \phiro-kernel\functions\number\is_positive.php
    *   @function strings_compare_insensitive() OPPURE stringsCompareInsensitive()
    *       @definedIn \phiro-kernel\functions\strings\compare_insensitive.php
    *
    * @access public
    * @param $descriptor                        : Descrittore del Limit
    * @return String
    *
    * Genera e restituisce l'SQL a partire dal @param $descriptor 
    * (Solitamente contenuto in $params['limit'])
	**/
    final private function buildLimitSQL($descriptor = null) {
        $SQL = '';
        if( empty($descriptor) && !is_positive_number($descriptor) ) return $SQL;
        
        if( !is_array($descriptor) ) $descriptor = recursive_array_map('trim', preg_split('/\||\,/', $descriptor ));

        $min = $max = -1;
        foreach($descriptor as $key => $value ) {
            if(is_numeric($value)) {
                if( !is_numeric($key) && !empty($key = trim($key) ) ) {
                    if( $min < 0 && strings_compare_insensitive($key, 'min') ) $min = (int) $value;
                    else if( $max < 0 && strings_compare_insensitive($key, 'max') ) $max = (int) $value;
                } else {
                    if($key == 0) $min = (int) $value;
                    else if($key == 1) $max = (int) $value;  
                }
            }
        }

        if($min > -1) $SQL .= $min.', ';
        if($max > -1) $SQL .= $max.', ';

        if( !empty($SQL = trim($SQL) ) ) 
            return (strlen($SQL) > 1) ? substr($SQL, 0, -1 ) : $SQL;
        return $SQL;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170514
    *
    * @access public
    * @param $descriptor                        : Descrittore del Limit
    * @return String
    *
    * Genera e restituisce l'SQL a partire dal @param $descriptor 
    * (Solitamente contenuto in $params['lock'])
	**/
    final private function buildLockSQL($descriptor = null) {
        $SQL = '';
        if( empty($descriptor) || is_array($descriptor) ) return $SQL;

        switch( strtolower($descriptor) ) {
            case 'for update': case 'update':
                $SQL .= ' FOR UPDATE';
                break;
            case 'in share mode': case 'share mode': case 'share':
                $SQL .= ' LOCK IN SHARE MODE';
                break;
            default:
                break;
        }

        return trim($SQL);
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170424
    *
    * @access public
    * @return String / Param Value
    *
    * Restituisce @param $DBName
	**/
    final public function getDBName() {
        return $this->DBName;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170424
    *
    * @access public
    * @return String / Param Value
    *
    * Restituisce @param $DBHost
	**/
    final public function getDBHost() {
        return $this->DBHost;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170424
    *
    * @access public
    * @return String / Param Value
    *
    * Restituisce @param $DBUserName
	**/
    final public function getDBUserName() {
        return $this->DBUserName;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170424
    *
    * @access public
    * @return String / Param Value
    *
    * Restituisce @param $DBUserPassword
	**/
    final public function getDBUserPassword() {
        return $this->DBUserPassword;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170426
    *
    * @access public
    * @return String / Param Value
    *
    * Restituisce @param $DBType
	**/
    final public function getDBType() {
        return $this->DBType;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170427
    *
    * @access public
    * @return Number / Param Field Value
    *
    * Restituisce @param $DBSocket->connectionTime se diverso da 0, -1 altrimenti
	**/
    final public function getDBSocketConnectionTime() {
        return ( isset($this->DBSocket->connectionTime) && $this->DBSocket->connectionTime  > 0 ) ? $this->DBSocket->connectionTime : -1;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170427
    *
    * @access public
    * @return Number / Param Field Value
    *
    * Restituisce @param $DBQuery->executionTime se diverso da 0, -1 altrimenti
	**/
    final public function getDBQueryExecutionTime() {
        return ( isset($this->DBQuery->executionTime) && $this->DBQuery->executionTime  > 0 ) ? $this->DBQuery->executionTime : -1;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170427
    *
    * @access public
    * @return Number / Param Field Value
    *
    * Restituisce @param $DBQuery->fetchedFieldsNumber
	**/
    final public function getDBQueryFetchedFieldsNumber() {
        return ( !empty($this->DBQuery->fetchedFieldsNumber) ) ? number_module( (int) $this->DBQuery->fetchedFieldsNumber) : 0;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170427
    *
    * @access public
    * @return Number / Param Field Value
    *
    * Restituisce @param $DBQuery->fetchedRowsNumber
	**/
    final public function getDBQueryFetchedRowsNumber() {
        return ( !empty($this->DBQuery->fetchedRowsNumber) ) ? number_module( (int) $this->DBQuery->fetchedRowsNumber ) : 0;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170514
    *
    * @access public
    * @return Boolean / Param Field Value
    *
    * Restituisce @param $DBQuery->options->SQLAutoTrim
	**/
    final private function isDBQueryOptionSQLAutoTrimEnabled() {
        return ( isset($this->DBQuery->options->SQLAutoTrim) ) ? $this->DBQuery->options->SQLAutoTrim : false;
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170514
    *
    * @access public
    * @return Boolean / Param Field Value
    *
    * Restituisce @param $DBQuery->options->fetchAutoTrim
	**/
    final private function isDBQueryOptionFetchAutoTrimEnabled() {
        return ( isset($this->DBQuery->options->fetchAutoTrim) ) ? $this->DBQuery->options->fetchAutoTrim : false;
    }
} 

?>