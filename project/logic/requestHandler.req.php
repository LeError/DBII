<?php
    /**
     * requestHandler.req.php
     *
     * File required by the Index.php which process POST requests and calls according functions
     *
     * @author     Robin Herder
     */

    //Prevent user form accessing file directly
    require_once('security.req.php');
    checkDocument();

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

    //register a new course
    if(isset($_POST['c_course_short']) && isset($_POST['c_course'])) {
        registerCourse($_POST['c_course_short'], $_POST['c_course']);
    }

    //register new survey user
    if(isset($_POST['c_course_short']) && isset($_POST['c_mat_nr']) && isset($_POST['c_name'])) {
        registerSurveyUser($_POST['c_mat_nr'], $_POST['c_name'], $_POST['c_course_short']);
    }

    //delete a survey user
    if(isset($_POST['d_student'])) {
        deleteSurveyUser($_POST['d_student']);
    }

    //Logout / end Sessions  (for all user types)
    if(isset($_GET['logout'])) {
        logout();
    }

?>