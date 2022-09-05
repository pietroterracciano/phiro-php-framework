<?php

/**
* @see @namespace Phiro\IO\Database\Drivers
**/
namespace Phiro\IO\Database\Drivers;

/**
* @trick SECURITY
**/
if(empty($PHIRO_KERNEL_DIR)) exit;

/**
* @see @class Phiro\IO\Database\Driver
*   @defineIn \phiro-kernel\classes\io\database\&Driver.php
**/
class MySQL extends \Phiro\IO\Database\Driver {

    /**
    * @define @params INSTANCE
    *
    * @since  0.170422
    * @define 
    *   @param Phiro\IO\Database\Driver->$DBName
    *   @param Phiro\IO\Database\Driver->$DBHost
    *   @param Phiro\IO\Database\Driver->$DBUserName
    *   @param Phiro\IO\Database\Driver->$DBUserPassword
    *   @param Phiro\IO\Database\Driver->$DBSocket
    *   @param Phiro\IO\Database\Driver->$DBQuery
    *   @param Phiro\IO\Database\Driver->$DBType
    *
    * @since 0.170523
    * @define
    *   @param Phiro\IO\Database\Driver->$DBVersion
    *   @param Phiro\IO\Database\Driver->$DBSchema
    **/

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @see
    *   @function mysql_connect()
    *   @function mysql_select_db()
    *   @function mysql_get_server_info()
    *
    * @access public
    * @return Boolean
    *
    * Restituisce "true" se la connessione al Database viene stabilita correttamente, "false" altrimenti
	**/
    public function DBConnect() {
        if(!$this->beforeDBConnect()) return false;      
        $this->DBSocket->resource = @mysql_connect(
            $this->DBHost, 
            $this->DBUserName, 
            $this->DBUserPassword
        ); 
        if( !empty($this->DBSocket->resource) ) {
            if(!empty($this->DBName)) @mysql_select_db($this->DBName, $resource);
            $this->DBVersion = @mysql_get_server_info($this->DBSocket->resource);
        }
        return $this->afterDBConnect();
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170422
    *
    * @see
    *   @function mysql_close()
    *
    * @access public
    * @return Boolean            
    *
    * Restituisce "true" se la connessione al Database viene chiusa correttamente, "false" altrimenti
	**/
    public function DBClose() {
        if(!$this->beforeDBClose()) return false;
        return $this->afterDBClose( @mysql_close($this->DBSocket->resource) );
    }
    
    /**
    * @author Pietro Terracciano
    * @since  0.170514
    *
    * @see 
    *   @function mysql_query()
    *
    * Restituisce "true" se la Transizione al Database viene inizializzata correttamente, "false" altrimenti
	**/
    public function beginDBTransaction() {
        return mysql_query('START TRANSACTION', $this->DBSocket->resource );
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170422  
    *
    * @see
    *   @function mysql_query()
    *   @function mysql_errno()
    *   @function mysql_num_fields()
    *   @function mysql_num_rows()
    *   @function mysql_error()
    *
    * @access public
    * @param $SQL                           : SQL
    * @return Boolean         
    * 
    * Effettua una Query descritta dal @param $SQL. Restituisce "true" se la Query è stata portata a termine, "false" altrimenti
	**/
    public function DBQuery($SQL = '') {
        if( !$this->beforeDBQuery($SQL) ) return false;

        $this->DBQuery->resource = mysql_query( $SQL, $this->DBSocket->resource );
        
        $errorID = mysql_errno($this->DBSocket->resource);

        if( empty($errorID) ) {
            /**
            * Utilizzando dei Tipi di Dato Enumerativi avremo maggiori prestazioni durante l'esecuzione dello Switch
            *
            * @trick PERFORMANCE
            **/
            switch($this->DBQuery->type) {
                case self::SELECT__QUERY:
                    $this->DBQuery->fetchedFieldsNumber = mysql_num_fields($this->DBQuery->resource);
                    $this->DBQuery->fetchedRowsNumber = mysql_num_rows($this->DBQuery->resource);
                    break;
            }
        } else {
            /**
            * Utilizzando una funzione al posto di una Eccezione (Exception Object) avremo un minore consumo di risorse e overhead
            *
            * @trick PERFORMANCE
            **/
            $this->setError(
                $errorID,
                mysql_error($this->DBSocket->resource)
            );
        }

        return $this->afterDBQuery();
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170427
    *
    * @see 
    *   @function mysql_fetch_assoc()
    *   @function mysql_fetch_row()
    *   @function mysql_fetch_array()
    *
    * @access public
    * @return Boolean          
    *
    * Restituisce "true" se è possibile leggere una "Row" dai risultati dell'ultima Query effettuata, "false" altrimenti
	**/
    public function hasDBQueryFetchedRow() {
        if( !$this->beforeHasDBQueryFetchedRow() ) return false;
        switch( (empty($this->DBQuery->options->fetchAs)) ? 0 : $this->DBQuery->options->fetchAs ) {
            default:
                $this->DBQuery->fetchedRow = @mysql_fetch_assoc($this->DBQuery->resource);
                break;
            case self::FETCH_AS__NUMERIC__QUERY_OPTION:
                $this->DBQuery->fetchedRow = @mysql_fetch_row($this->DBQuery->resource);
                break;
            case self::FETCH__BOTH__QUERY_OPTION:
                $this->DBQuery->fetchedRow = @mysql_fetch_array($this->DBQuery->resource, MYSQL_BOTH);
                break;
        }
        return $this->afterHasDBQueryFetchedRow();
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170428
    *
    * @see 
    *   @function mysql_fetch_field()
    *
    * @access public
    * @return Boolean          
    *
    * Restituisce "true" se è possibile leggere un "Field" dai risultati dell'ultima Query effettuata, "false" altrimenti
	**/
    public function hasDBQueryFetchedField() {
        if( !$this->beforeHasDBQueryFetchedField() ) return false;
        $this->DBQuery->fetchedField = @mysql_fetch_field($this->DBQuery->resource);
        return $this->afterHasDBQueryFetchedField();
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170514 
    *
    * @see
    *   @function mysql_query()
    *
    * Restituisce "true" se la Transizione al Database viene fatta correttamente, "false" altrimenti
	**/
    public function DBCommit() {
        return mysql_query('COMMIT', $this->DBSocket->resource );
    }

    /**
    * @author Pietro Terracciano
    * @since  0.170514
    *
    * @see
    *   @function mysql_query()
    *
    * Restituisce "true" se la Transizione al Database viene annullata correttamente, "false" altrimenti
	**/
    public function DBRollback() {
        return mysql_query('ROLLBACK', $this->DBSocket->resource );
    }
    
} 

?>