<?php

    /**
     * index.php
     *
     * Entry Point for the Website and loads (requires) the php logic files
     *
     * @author     Robin Herder
     */

    //Define constants
    //Navigation texts
    define("NAV_LBL_TITLE", "DHBW - Survey Site");
    define("NAV_LBL_SURVEY", "Surveys");
    define("NAV_LBL_USER_MANAGEMENT", "Survey User Management");
    define("NAV_LBL_RESULTS", "Results");
    //Navigation links
    define("NAV_URL_TITLE", "index.php");
    define("NAV_URL_SURVEY", "index.php?view=survey");
    define("NAV_URL_USER_MANAGEMENT", "index.php?view=user_mgm");
    define("NAV_URL_RESULTS", "index.php?view=results");

    //Session Management
    session_start();
    define("SESSION_ID", session_id());

    //Establish database connection
    require("logic/db.req.php");
    getDbConnection();

    //Load current view
    require("logic/views.req.php");

    //Access to central function
    require("logic/centralFunction.req.php");

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8"/>
        <meta content="IE=edge,chrome=1" http-equiv="X-UA-Compatible"/>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=2, user-scalable=no"/>
        <meta name="description" content="Semantic-UI-Forest, collection of design, themes and templates for Semantic-UI."/>
        <meta name="keywords" content="Semantic-UI, Theme, Design, Template"/>
        <meta name="author" content="PPType"/>
        <meta name="theme-color" content="#ffffff"/>
        <title><?php echo NAV_LBL_TITLE?></title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css" type="text/css"/>
        <link rel="stylesheet" href="css/base.css" type="text/css"/>
    </head>

<body id="root">
    <div class="ui tablet computer only padded grid">
        <div class="ui borderless fluid huge inverted menu">
            <div class="ui container">
                <a class="header item" href="<?php echo NAV_URL_TITLE ?>"><?php echo NAV_LBL_TITLE ?></a>
                <a class="item" href="<?php echo NAV_URL_SURVEY ?>"><?php echo NAV_LBL_SURVEY ?></a>
                <a class="item" href="<?php echo NAV_URL_USER_MANAGEMENT ?>"><?php echo NAV_LBL_USER_MANAGEMENT ?></a>
                <a class="item" href="<?php echo NAV_URL_RESULTS ?>"><?php echo NAV_LBL_RESULTS ?></a>
            </div>
        </div>
    </div>
    <div class="ui mobile only padded grid">
        <div class="ui borderless fluid huge inverted menu">
            <a class="header item" href="<?php echo NAV_URL_TITLE ?>"><?php echo NAV_LBL_TITLE ?></a>
            <div class="right menu">
                <div class="item">
                    <button class="ui icon toggle basic inverted button">
                        <i class="content icon"></i>
                    </button>
                </div>
            </div>
            <div class="ui vertical borderless fluid inverted menu">
                <a class="item" href="<?php echo NAV_URL_SURVEY ?>"><?php echo NAV_LBL_SURVEY ?></a>
                <a class="item" href="<?php echo NAV_URL_USER_MANAGEMENT ?>"><?php echo NAV_LBL_USER_MANAGEMENT ?></a>
                <a class="item" href="<?php echo NAV_URL_RESULTS ?>"><?php echo NAV_LBL_RESULTS ?></a>
            </div>
        </div>
    </div>
    <div class="ui center container">
        <?php
            //Load View from GET
            require (loadViews());
        ?>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            $(".ui.toggle.button").click(function () {
                $(".mobile.only.grid .ui.vertical.menu").toggle(100);
            });
        });
    </script>
    </body>
</html>
<?php
    //close database connection
    cleanUpDb();
?>
