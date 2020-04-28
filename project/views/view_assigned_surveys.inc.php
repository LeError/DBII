<?php

    /**
     * view_assigned_surveys.inc.php
     *
     *
     *
     * @author
     */

    //Prevent user form accessing file directly
    if(defined('REQ')) {
        securityCheck(ROLE_ADMIN);
    } else {
        require_once('../logic/security.req.php');
        checkDocument();
    }



?>