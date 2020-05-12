<?php

    /**
     * db.req.php
     *
     * stores general functions and procedures for accessing / working with the database
     *
     * @author Robin Herder
     *
     */

    //Prevent user form accessing file directly
    require_once('security.req.php');
    checkDocument();

    $link = false;
    define("MYSQL_HOST", "127.0.0.1");
    define("MYSQL_USER", "root");
    define("MYSQL_PW", "");
    define("MYSQL_DB", "survey_site");

    /**
     * Builds Database Connection
     * @author Robin Herder
     * @return bool|false|mysqli returns Database connection
     */
    function getDbConnection(){
        global $link;
        if( $link ) {
            return $link;
        }
        $link = mysqli_connect(MYSQL_HOST, MYSQL_USER, MYSQL_PW, MYSQL_DB) or die('Could not connect to server.' );
        return $link;
    }

    /**
     * closes the database connection
     * @author Robin Herder
     */
    function cleanUpDb(){
        global $link;
        if( $link != false ) {
            mysqli_close($link);
        }
        $link = false;
    }

    /**
     * Escapes user input to avoid sql injections. use is only necessary if the query is not executed as a prepared statement
     * @author Robin Herder
     * @param $text input to check
     * @return string escaped user input
     */
    function escapeSql($text){
        $text = mysqli_real_escape_string(getDbConnection(), $text);
        return "'".$text."'";
    }

?>
