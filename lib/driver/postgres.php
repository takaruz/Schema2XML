<?php
/**
 * File: postgres.php
 *
 * PHP version 5
 *
 * @category Backend
 * @package  Driver
 * @author   Pongpat Poapetch <p.poapetch@gmail.com>
 * @license  The MIT License (MIT) Copyright (c) 2014 takaruz
 * @version  GIT: master In development. Very unstable.
 * @link     https://github.com/takaruz/Schema2XML
 */
 
 /**
 * Class Driver POSTGRES
 *
 * @category Backend
 * @package  Driver
 * @author   Pongpat Poapetch <p.poapetch@gmail.com>
 * @license  The MIT License (MIT) Copyright (c) 2014 takaruz
 * @version  GIT: master In development. Very unstable.
 * @link     https://github.com/takaruz/Schema2XML
 */

class Driver
{
    /**
    * @var constant COLUMN_TYPE contain type string.
    */	
    const COLUMN_TYPE = "udt_catalog";

    /**
    * Get result from query statement from passing argument.
    *
    * @param connection $conn  connection resource
    * @param string     $query query statement.
    *
    * @return result
    */
    public static function get($conn, $query)
    {
        $result = pg_query($conn, $query) or die('Query failed: ' . pg_last_error());
        return $result;
    }

    /**
    * Get schemas list that owner by $user except .
    *
    * @param connection $conn  connection resource.
    *    
    * @return result
    */
	public static function getSchemas($conn) 
	{
        $query  = "SELECT schema_name from information_schema.schemata ";
        $query .= "WHERE schema_name <> 'test' and schema_name <> 'information_schema'";
		$result = pg_query($conn, $query) or die('Query failed: ' . pg_last_error());
		return $result;
	}

    /**
    * Get tables list from schema from passing argument.
    *
    * @param connection $conn   connection resource.
    * @param string     $schema schema name, DEFAULT is 'null'
    *
    * @return result
    */
	public static function getTables($conn, $schema)
    {  
        $query  = "SELECT table_name FROM information_schema.tables ";
        $query .= "WHERE table_schema='$schema' AND table_type='BASE TABLE'";
        $result = pg_query($conn, $query) or die('Query failed: ' . pg_last_error());
        return $result;
    }

    /**
    * Get views list from schema from passing argument.
    *
    * @param connection $conn   connection resource.    
    * @param string     $schema schema name, DEFAULT is 'null'
    *
    * @return result
    */
    public static function getViews($conn, $schema)
    {  
        $query  = "SELECT table_name FROM information_schema.tables ";
        $query .= "WHERE table_schema='$schema' AND table_type='VIEW'";
        $result = pg_query($conn, $query) or die('Query failed: ' . pg_last_error());
        return $result;
    }

    /**
    * Get columns list from table and schema by passing arguments.
    *
    * @param connection $conn   connection resource.       
    * @param string     $table  table name
    * @param string     $schema schema name, DEFAULT is 'null'
    *
    * @return result
    */
    public static function getColumns($conn, $table, $schema)
    {
        $query  = "SELECT * FROM information_schema.columns ";
        $query .= "WHERE table_schema='$schema' AND table_name='$table'";
        $result = pg_query($conn, $query) or die('Query failed: ' . pg_last_error());
        return $result;
    }    

    /**
    * Get number of schemas from query statement.
    *
    * @param connection $conn connection resource.   
    *
    * @return integer
    */
    public static function getNumSchemas($conn)
    {
        $result = Driver::getSchemas($conn);
        return pg_num_rows($result);
    }

    /**
    * Get number of tables from query statement.
    *
    * @param connection $conn   connection resource.    
    * @param string     $schema schema name, DEFAULT is 'null'
    *
    * @return integer
    */
    public static function getNumTables($conn, $schema)
    {
        $result = Driver::getTables($conn, $schema);
        return pg_num_rows($result);
    }

    /**
    * Get number of tables from query statement.
    *
    * @param connection $conn   connection resource.    
    * @param string     $schema schema name, DEFAULT is 'null'
    *
    * @return integer
    */
    public static function getNumViews($conn, $schema)
    {
        $result = Driver::getViews($conn, $schema);
        return pg_num_rows($result);
    }

    /**
    * Get number of columns from query statement.
    *
    * @param connection $conn   connection resource.    
    * @param string     $table  table name
    * @param string     $schema schema name, DEFAULT is 'null'
    *
    * @return integer
    */
    public static function getNumColumns($conn, $table, $schema)
    {
        $result = Driver::getColumns($conn, $table, $schema);
        return pg_num_rows($result);
    }

    /**
    * print all result resouce from query statement.
    *
    * @param result $result result resource from query statement
    *
    * @return void
    */
	public static function printDebug($result)
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
    public static function getResultArray($result)
    {
        return pg_fetch_all($result);
    }    

}

?>