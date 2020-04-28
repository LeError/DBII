<?php

    define('SECURITY', 'security.req.php');

    if(session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    require_once ('userNotification.req.php');
    checkDocument();

    function securityCheck($requiredRole) {
        checkRole($requiredRole);
        checkDocument();
    }

    function checkRole($requiredRole) {
        if(!isset($_SESSION[SESSION_ROLE])) {
            header('location: /');
        } else if (!($_SESSION[SESSION_ROLE] == $requiredRole)) {
            publishWarningNotification('Sie wurden auf die Startseite da ihnen die rechte für die inhalte die sie aufrufen fehlen');
            header('location: /');
        }
    }

    function checkDocument() {
        if(!defined("REQ")) {
            publishErrorNotification('Weiterleitung auf die Startseite da sie sich in einer unerlaubten Datei befanden!');
            header('location: /');
        }
    }