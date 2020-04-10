<?php

    /**
     * view.req.php
     *
     * Stores logic for view System
     *
     * @author     Robin Herder
     */

    define("VIEWS_PATH", "views/");

    $nav_survey = false;
    $nav_user_mgm = false;
    $nav_results = false;

    /**
     * determines the view to show from _GET or 404 view
     * @author Robin Herder
     * @return mixed|string|string[]|null path to view
     */
    function loadViews() {
        $view = "survey";
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