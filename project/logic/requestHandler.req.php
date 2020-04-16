<?php
    if(isset($_POST['ul_user']) && isset($_POST['ul_pass']) && isset($_POST['ul_register']) && $_POST['ul_register'] == true) {
        registerUser($_POST['ul_user'], $_POST['ul_pass']);
        loginUser($_POST['ul_user'], $_POST['ul_pass']);
    } else if(isset($_POST['ul_user']) && isset($_POST['ul_pass'])) {
        loginUser($_POST['ul_user'], $_POST['ul_pass']);
    }
    if(isset($_GET['logout'])) {
        logout();
    }

?>