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
        loginUser($_POST['ul_user'], $_POST['ul_pass']);
    } else if(isset($_POST['ul_user']) && isset($_POST['ul_pass'])) {
        loginUser($_POST['ul_user'], $_POST['ul_pass']);
    }

    //Login Survey User
    if(isset($_POST['sul_identifier'])) {
        loginSurveyUser($_POST['sul_identifier']);
    }

    //Logout / end Sessions  (for all user types)
    if(isset($_GET['logout'])) {
        logout();
    }

?>