﻿<?php 
/**
 * File: Schema2XML.inc.php
 *
 * PHP version 5
 *
 * @category Backend
 * @package  Schema2XML_Lib
 * @author   Pongpat Poapetch <p.poapetch@gmail.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version  GIT: master In development. Very unstable.
 * @link     http://php.net/manual/en/book.pgsql.php
 * @todo     add another Database support
 */
 
 /**
 * Class DBDetail
 *
 * @category Backend
 * @package  Schema2XML_Lib
 * @author   Pongpat Poapetch <p.poapetch@gmail.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @version  GIT: master In development. Very unstable.
 * @link     http://php.net/manual/en/book.pgsql.php
 * @todo     add another Database support
 */
 
Class DBDetail
{

    /**
    * @var string $host   contain hostname from init function.
    * @var string $user   contain username from init function.
    * @var string $passwd contain password from init function.
    * @var string $dbname contain databasename from init function.    
    * @var string $port   contain port number from init function. DEFAULT is '5432'.
    */
    protected $host;
    protected $user;
    protected $passwd;
    protected $dbname;
    protected $port;

    /**
    * Constructor to correct parameter that using in establish connection
    *
    * @param string $host   assign hostname to open connection.
    * @param string $user   username to connect database.
    * @param string $passwd password to connect database.
    * @param string $dbname database name.
    * @param string $port   port number, DEFAULT value is 5432. 
    *
    * @return void
    */
    function __construct($host, $user, $passwd, $dbname, $port=5432)
    {
        $this->host = $host;
        $this->user = $user;
        $this->passwd = $passwd;
        $this->dbname = $dbname;
        $this->port = $port;
    }

    /**
    * establish connection to dabase
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
            $con_str  = "host=$this->host user=$this->user dbname=$this->dbname ";
            $con_str .= "password=$this->passwd port=$this->port";
            $conn = pg_connect($con_str);
            // unset password variable because no need anymore. 
            unset($this->passwd);
        } Catch (Exception $e) {
            Echo $e->getMessage();
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
        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
        return $result;
    }

    /**
    * Get schemas list that owner by $user.
    *
    * @return result
    */
    function getSchemas()
    {
        $query  = 'SELECT schema_name from information_schema.schemata';
        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
        return $result;
    }

    /**
    * Get tables list from schema from passing argument.
    *
    * @param string $schema schema name, DEFAULT is 'public'
    *
    * @return result
    */
    function getTables($schema='public')
    {  
        $query  = "SELECT table_name FROM information_schema.tables ";
        $query .= "WHERE table_schema='$schema' AND table_type='BASE TABLE'";
        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
        return $result;
    }

    /**
    * Get views list from schema from passing argument.
    *
    * @param string $schema schema name, DEFAULT is 'public'
    *
    * @return result
    */
    function getViews($schema='public')
    {  
        $query  = "SELECT table_name FROM information_schema.tables ";
        $query .= "WHERE table_schema='$schema' AND table_type='VIEW'";
        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
        return $result;
    }    

    /**
    * Get columns list from table and schema by passing arguments.
    *
    * @param string $table  table name
    * @param string $schema schema name, DEFAULT is 'public'
    *
    * @return result
    */
    function getColumns($table, $schema='public')
    {
        $query  = "SELECT * FROM information_schema.columns ";
        $query .= "WHERE table_schema='$schema' AND table_name='$table'";
        $result = pg_query($query) or die('Query failed: ' . pg_last_error());
        return $result;
    }

    /**
    * Get number of schemas from query statement.
    *
    * @return integer
    */
    function getNumSchemas()
    {
        $result = $this->getSchemas();
        return pg_num_rows($result);
    }

    /**
    * Get number of tables from query statement.
    *
    * @param string $schema schema name, DEFAULT is 'public'
    *
    * @return integer
    */
    function getNumTables($schema='public')
    {
        $result = $this->getTables($schema);
        return pg_num_rows($result);
    }

    /**
    * Get number of tables from query statement.
    *
    * @param string $schema schema name, DEFAULT is 'public'
    *
    * @return integer
    */
    function getNumViews($schema='public')
    {
        $result = $this->getViews($schema);
        return pg_num_rows($result);
    }    

    /**
    * Get number of columns from query statement.
    *
    * @param string $table  table name
    * @param string $schema schema name, DEFAULT is 'public'
    *
    * @return integer
    */
    function getNumColumns($table, $schema='public')
    {
        $result = $this->getColumns($table, $schema);
        return pg_num_rows($result);
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
    * Debug result resouce from query statement.
    *
    * @param result $result result resource from query statement
    *
    * @return void
    */
    function printDebug($result)
    {
        echo '<pre>';
        print_r(pg_fetch_all($result));
        echo '</pre>';
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
        return pg_fetch_all($result);
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
                    $index = $columns[$k]['ordinal_position'];
                    $writer->startElement('column');
                    $writer->writeAttribute('index', $index);
                    $writer->writeAttribute('type', $columns[$k]['udt_name']);
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
                        $index = $columns[$k]['ordinal_position'];
                        $writer->startElement('column');
                        $writer->writeAttribute('index', $index);
                        $writer->writeAttribute('type', $columns[$k]['udt_name']);
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

        // echo $oXMLWriter->outputMemory(TRUE);
        $writer->flush(); 
    }
}

?>