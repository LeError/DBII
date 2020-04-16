<?php
    if(isset($_POST['ul_user']) && isset($_POST['ul_pass'])) {
        loginUser($_POST['ul_user'], $_POST['ul_pass']);
    }
    if(isset($_GET['logout'])) {
        logout();
    }

?>