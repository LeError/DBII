<?php

    /**
     * security.req.php
     *
     * used to enforce security measures
     *
     * @author     Robin Herder
     */

    define('SECURITY', 'security.req.php');

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once ('userNotification.req.php');
    checkDocument();

    /**
     * makes a full security check
     * @author Robin Herder
     * @param $requiredRole user mgm role
     */
    function securityCheck($requiredRole) {
        checkRole($requiredRole);
        checkDocument();
    }

    /**
     * checks if user has required role for the file he is accessing
     * @author Robin Herder
     * @param $requiredRole
     */
    function checkRole($requiredRole) {
        if(!isset($_SESSION[SESSION_ROLE])) {
            header('location: /');
        } else if (!($_SESSION[SESSION_ROLE] == $requiredRole)) {
            publishWarningNotification('Sie wurden auf die Startseite da ihnen die rechte für die inhalte die sie aufrufen fehlen');
            header('location: /');
        }
    }

    /**
     * checks if a document is accessed directly and not via the index file. If accessed outside of index redirects user to default page.
     * @author Robin Herder
     */
    function checkDocument() {
        if(!defined("REQ")) {
            publishErrorNotification('Weiterleitung auf die Startseite da sie sich in einer unerlaubten Datei befanden!');
            header('location: /');
        }
    }