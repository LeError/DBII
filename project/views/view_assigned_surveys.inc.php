<?php

    /**
     * view_assigned_surveys.inc.php
     *
     *
     *
     * @author Malik Press
     */

    //Prevent user form accessing file directly
    if(defined('REQ')) {
        securityCheck(ROLE_USER);
    } else {
        require_once('../logic/security.req.php');
        checkDocument();
    }

    if(isset($_POST['survey'])) {
        header('location: index.php?view=use');
        $_SESSION["titleShort"] = $_POST["survey"];
    }
if(isset($_SESSION["q"])) {
    unset($_SESSION["q"]);
}
?>
<div class="ui grid">
    <div class="sixteen wide column">
        <div class="ui raised segment">
            <a class="ui red ribbon label">Overview</a>
            <form class="ui form" method="post" style="margin-top: 15px">
                <div class="ui grid">
                    <div class="row">
                        <div class="column"><h3 class="ui dividing header">My surveys</h3></div>
                    </div>
                    <?php
                    $unfinishedSurveys = getUnFinishedSurveys($_SESSION[SESSION_USER], getCourseShort($_SESSION[SESSION_USER]));
                    if (count($unfinishedSurveys) == 0) {
                        publishInfoNotification("Keine Umfragen verfügbar!");
                    }
                    for ($i = 0; $i < count($unfinishedSurveys);$i++) {
                        echo '
                <div class="row">
                    <div class="sixteen wide column">
                        <button class="ui fluid button" name="survey" type="submit" value="' . $unfinishedSurveys[$i] . '">' . getSurveyTitle($unfinishedSurveys[$i]) . '</button>
                    </div>
                </div>';
                    };
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>