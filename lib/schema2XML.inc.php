<?php 
/**
 * File: Schema2XML.inc.php
 *
 * PHP version 5
 *
 * @category Backend
 * @package  Schema2XML_Lib
 * @author   Pongpat Poapetch <p.poapetch@gmail.com>
 * @license  The MIT License (MIT) Copyright (c) 2014 takaruz
 * @version  GIT: master In development. Very unstable.
 * @link     https://github.com/takaruz/Schema2XML
 * @todo     add another Database support
 */
 
 /**
 * Class DBDetail
 *
 * @category Backend
 * @package  Schema2XML_Lib
 * @author   Pongpat Poapetch <p.poapetch@gmail.com>
 * @license  The MIT License (MIT) Copyright (c) 2014 takaruz
 * @version  GIT: master In development. Very unstable.
 * @link     https://github.com/takaruz/Schema2XML
 * @todo     add another Database support
 */
 
Class DBDetail
{

    /**
    * @var connection $conn   contain a connection resouce.     
    * @var string     $dbms   contain DBMSs from init function.    
    * @var string     $host   contain hostname from init function.
    * @var string     $user   contain username from init function.
    * @var string     $passwd contain password from init function.
    * @var string     $dbname contain databasename from init function.    
    * @var integer    $port   contain port number from init function. DEFAULT is '0'.
    */
    protected $conn;
    protected $dbms;
    protected $host;
    protected $user;
    protected $passwd;
    protected $dbname;
    protected $port;

    /**
    * Constructor to correct parameter that using in establish connection
    *
    * @param string  $dbms   contain DBMSs from init function. DOMAIN: postgres, mysql
    * @param string  $host   assign hostname to open connection.
    * @param string  $user   username to connect database.
    * @param string  $passwd password to connect database.
    * @param string  $dbname database name.
    * @param integer $port   port number, DEFAULT value is null. 
    *
    * @return void
    */
    function __construct($dbms, $host, $user, $passwd, $dbname, $port=null)
    {
        // include_once("/driver/query_statment.php");

        $this->dbms = $dbms;
        $this->host = $host;
        $this->user = $user;
        $this->passwd = $passwd;
        $this->dbname = $dbname;
        
        if (!isset($port)) {
            $this->port = $port;
        } else {
            if (strtolower($dbms) == 'postgres') {
                $this->port = 5432;
            } elseif (strtolower($dbms) == 'mysql') {
                $this->port = 3306;
            } 
        }
    }

    /**
    * establish connection to database.
    *
    * @return void
    */
    function init()
    {
        /**
        * exceptionErrorHandler
        *
        * @param string $errno   error collection.
        * @param string $errstr  error collection.
        * @param string $errfile error collection.
        * @param string $errline error collection.
        *
        * @return void
        */

        function exceptionErrorHandler($errno, $errstr, $errfile, $errline )
        {
            throw new ErrorException($errstr, $errno, 0, $errfile, $errline);
        }
        set_error_handler("exceptionErrorHandler");

        try {
            $con_str  = "host=$this->host user=$this->user dbname=$this->dbname password=$this->passwd port=$this->port";

            if ($this->dbms == 'postgres') {
                $this->conn = pg_connect($con_str);
                require_once("driver/postgres.php");
                putenv("DEFAULT_SCHEMA=public");
            } elseif ($this->dbms == 'mysql') {
                $this->conn = mysqli_connect($this->host, $this->user, $this->passwd, $this->dbname, $this->port);
                require_once("driver/mysqli.php");
                putenv("DEFAULT_SCHEMA=$this->user");
            }
            // unset password variable because no need anymore. 
            unset($this->passwd);
            return 0;
        } Catch (Exception $e) {
            Echo $e->getMessage();
            return -1;
        }
    }

    /**
    * Get result from query statement from passing argument.
    *
    * @param string $query query statement.
    *
    * @return result
    */
    function get($query)
    {
        $result = Driver::get($this->conn, $query);
        return $result;
    }

    /**
    * Get schemas list that owner by $user except .
    *
    * @return result
    */
    function getSchemas()
    {
        $result = Driver::getSchemas($this->conn);
        return $result;
    }

    /**
    * Get tables list from schema from passing argument.
    *
    * @param string $schema schema name, DEFAULT is 'null'
    *
    * @return result
    */
    function getTables($schema=null)
    {  
        $schema = isset($schema) ? $schema : getenv("DEFAULT_SCHEMA");
        $result = Driver::getTables($this->conn, $schema);
        return $result;
    }

    /**
    * Get views list from schema from passing argument.
    *
    * @param string $schema schema name, DEFAULT is 'null'
    *
    * @return result
    */
    function getViews($schema=null)
    {  
        $schema = isset($schema) ? $schema : getenv("DEFAULT_SCHEMA");
        $result = Driver::getViews($this->conn, $schema);
        return $result;
    }

    /**
    * Get columns list from table and schema by passing arguments.
    *
    * @param string $table  table name
    * @param string $schema schema name, DEFAULT is 'null'
    *
    * @return result
    */
    function getColumns($table, $schema=null)
    {
        $schema = isset($schema) ? $schema : getenv("DEFAULT_SCHEMA");
        $result = Driver::getColumns($this->conn, $table, $schema);
        return $result;
    }

    /**
    * Get number of schemas from query statement.
    *
    * @return integer
    */
    function getNumSchemas()
    {
        $result = Driver::getNumSchemas($this->conn);
        return $result;
    }

    /**
    * Get number of tables from query statement.
    *
    * @param string $schema schema name, DEFAULT is 'null'
    *
    * @return integer
    */
    function getNumTables($schema=null)
    {
        $schema = isset($schema) ? $schema : getenv("DEFAULT_SCHEMA");
        $result = Driver::getNumTables($this->conn, $schema);
        return $result;
    }

    /**
    * Get number of tables from query statement.
    *
    * @param string $schema schema name, DEFAULT is 'null'
    *
    * @return integer
    */
    function getNumViews($schema=null)
    {
        $schema = isset($schema) ? $schema : getenv("DEFAULT_SCHEMA");
        $result = Driver::getNumViews($this->conn, $schema);
        return $result;
    }

    /**
    * Get number of columns from query statement.
    *
    * @param string $table  table name
    * @param string $schema schema name, DEFAULT is 'null'
    *
    * @return integer
    */
    function getNumColumns($table, $schema=null)
    {
        $schema = isset($schema) ? $schema : getenv("DEFAULT_SCHEMA");
        $result = Driver::getNumColumns($this->conn, $table, $schema);
        return $result;
    }

    /**
    * Return validation massage that check status of database.
    *
    * @return string
    */
    function validate() 
    {
        if ($this->getNumSchemas() == 0) {
            $msg  = "Warning: number of schemas for user=$this->user is 0. ";
            $msg .= "Hence, schema will not show.";
            return $msg;
        }
        if ($this->getNumTables() == 0) {
            
        }
        return "all passed !!";
    }

    /**
    * print all result resouce from query statement.
    *
    * @param result $result result resource from query statement
    *
    * @return void
    */
    function printDebug($result)
    {
        Driver::printDebug($result);
    }

    /**
    * Get result from query statement to array.
    *
    * @param result $result result resource from query statement
    *
    * @return array
    */
    function getResultArray($result)
    {
        return Driver::getResultArray($result);
    }



    /**
    * Export database hierarchy to xml.
    *
    * @param string  $uri    set an output destination.
    * @param boolean $detail to enable/disable tag <detail>.
    *
    * @return void
    */
    function exportXML($uri='php://output', $detail=false)
    {
        // ==== Declare local variable ====
        $schema_num = $this->getNumSchemas();
        $schemas = $this->getResultArray($this->getSchemas());
        // ==========================================================
        $writer = new XMLWriter();  
        $writer->openURI($uri);
        // $writer->openMemory();
        $writer->startDocument('1.0', 'UTF-8');
        $writer->setIndent(true);
        $writer->setIndentString("    ");

        $writer->startElement('database');
        $writer->writeAttribute('name', $this->dbname);
        $writer->writeAttribute('schema_num', $schema_num);
        if ($detail) {
            // ==== Detail Database ====
            $writer->startElement('details');
            $writer->writeElement('host', $this->host);
            $writer->endElement();
        }
        // ==== Schema loop ====
        for ($i=0; $i < $schema_num; $i++) {
            // ==== Declare local variable ====
            $schema_name = $schemas[$i]['schema_name'];
            $table_num = $this->getNumTables($schema_name);
            $tables = $this->getResultArray($this->getTables($schema_name));
            $view_num = $this->getNumViews($schema_name);
            $views = $this->getResultArray($this->getViews($schema_name));
            // ==========================================================
            $writer->startElement('schema');
            $writer->writeAttribute('name', $schema_name);
            $writer->writeAttribute('table_num', $table_num);
            if ($detail) {
                $writer->writeAttribute('view_num', $view_num);
            }
            // ==== Table loop ====
            for ($j=0; $j < $table_num; $j++) {
                // ==== Declare local variable ====
                $table_name = $tables[$j]['table_name'];
                $column_num = $this->getNumColumns($table_name, $schema_name);
                $result = $this->getColumns($table_name, $schema_name);
                $columns = $this->getResultArray($result);
                // ==========================================================
                $writer->startElement('table');
                $writer->writeAttribute('name', $table_name);
                $writer->writeAttribute('column_num', $column_num);
                // ==== Column loop ====
                for ($k=0; $k < $column_num; $k++) {
                    $columns[$k] = array_change_key_case($columns[$k], CASE_LOWER);
                    $index = $columns[$k]['ordinal_position'];
                    $writer->startElement('column');
                    $writer->writeAttribute('index', $index);
                    $writer->writeAttribute('type', $columns[$k][Driver::COLUMN_TYPE]);
                    $writer->text($columns[$k]['column_name']);
                    $writer->endElement();  // End of Column
                }
                $writer->endElement();  // End of Table.
            }
            // ==== if detail is true.
            if ($detail) {    
                // ==== View loop ====
                for ($j=0; $j < $table_num; $j++) {
                    // ==== Declare local variable ====
                    $view_name = $views[$j]['table_name'];
                    $column_num = $this->getNumColumns($view_name, $schema_name);
                    $result = $this->getColumns($view_name, $schema_name);
                    $columns = $this->getResultArray($result);
                    // ==========================================================
                    $writer->startElement('view');
                    $writer->writeAttribute('name', $view_name);
                    $writer->writeAttribute('column_num', $column_num);
                    // ==== Column loop ====
                    for ($k=0; $k < $column_num; $k++) {
                        $columns[$k] = array_change_key_case($columns[$k], CASE_LOWER);
                        $index = $columns[$k]['ordinal_position'];
                        $writer->startElement('column');
                        $writer->writeAttribute('index', $index);
                        $writer->writeAttribute('type', $columns[$k][Driver::COLUMN_TYPE]);
                        $writer->text($columns[$k]['column_name']);
                        $writer->endElement();  // End of Column
                    }
                    $writer->endElement();  // End of View.
                }
            }
            $writer->endElement(); // End of Schema.
        }
        $writer->endElement();  // End of Database.
        $writer->endDocument();  // End of Document.
        $writer->flush(); 
    }
}

?>