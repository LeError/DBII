<?php

    /**
     * view.req.php
     *
     * Stores logic for view System To dynamically load view files and displaying them based on a _GET navigation
     *
     * @author     Robin Herder
     */

    //Prevent user form accessing file directly
    require_once('security.req.php');
    checkDocument();

    define("VIEWS_PATH", "views/");

    /**
     * determines the view to show from _GET or 404 view
     * @author Robin Herder
     * @return mixed|string|string[]|null path to view
     */
    function loadViews() {
        if(array_key_exists(SESSION_ROLE, $_SESSION) && $_SESSION[SESSION_ROLE] == ROLE_ADMIN) {
            $view = "survey";
        } elseif (array_key_exists(SESSION_ROLE, $_SESSION) && $_SESSION[SESSION_ROLE] == ROLE_USER) {
            $view = "assigned_surveys";
        }
        if(!empty($_GET['view'])) {
            $view = $_GET['view'];
        }
        $view = preg_replace("/[^a-z0-9_]/", "", $view);
        $view = VIEWS_PATH."view_".$view.".inc.php";
        if(!file_exists($view)) {
            $view = VIEWS_PATH."view_404.inc.php";
        }
        return $view;
    }

?>