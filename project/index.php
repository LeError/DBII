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
define("NAV_LBL_LOGOUT", "Log Out");
//Navigation links
define("NAV_URL_TITLE", "index.php");
define("NAV_URL_SURVEY", "index.php?view=survey");
define("NAV_URL_USER_MANAGEMENT", "index.php?view=user_mgm");
define("NAV_URL_RESULTS", "index.php?view=results");
define("NAV_URL_LOGOUT", "index.php?logout");
//Check if only index is accessed
define("REQ", 'index');

//Session Management
session_start();

//Establish database connection
require("logic/db.req.php");
getDbConnection();

//Enables Notifications / Error Handling
require ('logic/userNotification.req.php');

//Access to central function
require("logic/centralFunction.req.php");

//Access to user management
require("logic/usermgm.req.php");

//Load current view
require("logic/views.req.php");

//Security logic for the page
require ('logic/security.req.php');

//Handles POST Requests send to the Index
require ('logic/requestHandler.req.php');
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
    <title><?php echo NAV_LBL_TITLE ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.css"
          type="text/css"/>
    <link rel="stylesheet" href="css/base.css" type="text/css"/>
</head>

<body id="root">

<?php
if (array_key_exists(SESSION_ROLE, $_SESSION) && $_SESSION[SESSION_ROLE] == ROLE_ADMIN) {
    ?>

    <div class="ui tablet computer only padded grid">
        <div class="ui borderless fluid huge inverted menu">
            <div class="ui container">
                <a class="header item" href="<?php echo NAV_URL_TITLE ?>"><?php echo NAV_LBL_TITLE ?></a>
                <a class="item" href="<?php echo NAV_URL_SURVEY ?>"><?php echo NAV_LBL_SURVEY ?></a>
                <a class="item" href="<?php echo NAV_URL_USER_MANAGEMENT ?>"><?php echo NAV_LBL_USER_MANAGEMENT ?></a>
                <a class="item" href="<?php echo NAV_URL_RESULTS ?>"><?php echo NAV_LBL_RESULTS ?></a>
                <a class="item right aligned" href="<?php echo NAV_URL_LOGOUT ?>"><?php echo NAV_LBL_LOGOUT ?></a>
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
                <a class="item" href="<?php echo NAV_URL_LOGOUT ?>"><?php echo NAV_LBL_LOGOUT ?></a>
            </div>
        </div>
    </div>
    <div class="container ui middle aligned center aligned grid">
        <div width="80%" class="column">
            <?php displayNotifications(); ?>
        </div>
    </div>
    <div class="ui center container">
        <?php
        //Load View from GET
        require(loadViews());
        ?>
    </div>

    <?php
} else if (array_key_exists(SESSION_ROLE, $_SESSION) && $_SESSION[SESSION_ROLE] == ROLE_USER) {
    ?>
    <div class="ui tablet computer only padded grid">
        <div class="ui borderless fluid huge inverted menu">
            <div class="ui container">
                <a class="header item" href="<?php echo NAV_URL_TITLE ?>"><?php echo NAV_LBL_TITLE ?></a>
                <div class="item center aligned"><?php if(isset($_SESSION[SESSION_USER])) { echo 'Hi '.getSurveyUsername($_SESSION[SESSION_USER]); }?></div>
                <a class="item right aligned" href="<?php echo NAV_URL_LOGOUT ?>"><?php echo NAV_LBL_LOGOUT ?></a>
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
                <a class="item" href="<?php echo NAV_URL_LOGOUT ?>"><?php echo NAV_LBL_LOGOUT ?></a>
            </div>
        </div>
    </div>
    <div class="container ui middle aligned center aligned grid">
        <div width="80%" class="column">
            <?php displayNotifications(); ?>
        </div>
    </div>
    <div class="ui center container">
        <?php
        //Load View from GET
        require(loadViews());
        ?>
    </div>
    <?php
} else {
    ?>

    <div class="container ui middle aligned center aligned grid">
        <div width="80%" class="column ui text left aligned">
            <?php displayNotifications(); ?>
        </div>
    </div>

    <div class="ui middle aligned center aligned grid">
        <div class="column" style="width: 450px; margin-top: 7%">
            <h2 class="ui image header">
                <div class="content">
                   <i><?php echo NAV_LBL_TITLE ?></i> - User
                </div>
            </h2>
            <form id="login" action="index.php" method="POST" class="ui large form">
                <div class="ui stacked secondary  segment">
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="user icon"></i>
                            <input id="loginUser" type="text" name="ul_user" placeholder="Username">
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="lock icon"></i>
                            <input id="loginUser" type="password" name="ul_pass" placeholder="Password">
                        </div>
                    </div>
                    <div class="field">
                        <div class="ui toggle checkbox">
                            <input type="checkbox" name="ul_register">
                            <label>Register new Account</label>
                        </div>
                    </div>
                    <div class="ui fluid large teal button submit">Login</div>
                </div>
                <div class="ui error message"></div>
            </form>
        </div>
    </div>
    <div class="ui middle aligned center aligned grid">
        <div class="column" style="width: 450px; margin-top: 50px">
            <h2 class="ui image header">
                <div class="content">
                    <i><?php echo NAV_LBL_TITLE ?></i> - Survey User
                </div>
            </h2>
            <form id="login_survey_user" action="" method="post" class="ui large form">
                <div class="ui stacked secondary  segment">
                    <div class="field">
                        <div class="ui left icon input">
                            <i class="user icon"></i>
                            <input type="text" name="sul_identifier" placeholder="Matricule Number">
                        </div>
                    </div>
                    <div class="ui fluid large teal submit button">Login</div>
                </div>
                <div class="ui error message"></div>
            </form>
        </div>
    </div>

    <?php
}
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/semantic-ui/2.4.1/semantic.min.js"></script>
<script src="js/login.js"></script>
<script src="js/navigation.js"></script>
<script src="js/create_course.js"></script>
<script src="js/edit_course.js"></script>
</body>
</html>
<?php
//close database connection
cleanUpDb();
?>
