<?php
    /**
     * requestHandler.req.php
     *
     * File required by the Index.php which process POST requests and calls according functions
     *
     * @author     Robin Herder
     */

    //Login / Register User
    if(isset($_POST['ul_user']) && isset($_POST['ul_pass']) && isset($_POST['ul_register']) && $_POST['ul_register'] == true) {
        registerUser($_POST['ul_user'], $_POST['ul_pass']);
    } else if(isset($_POST['ul_user']) && isset($_POST['ul_pass'])) {
        loginUser($_POST['ul_user'], $_POST['ul_pass']);
    }

    //Login Survey User
    if(isset($_POST['sul_identifier'])) {
        loginSurveyUser($_POST['sul_identifier']);
    }

    if(isset($_POST['c_course_short']) && isset($_POST['c_course'])) {
        registerCourse($_POST['c_course_short'], $_POST['c_course']);
    }

    //Logout / end Sessions  (for all user types)
    if(isset($_GET['logout'])) {
        logout();
    }

?>