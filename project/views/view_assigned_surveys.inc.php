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
        header('location: index.php?view_use');
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
                    $surveys = getAssignedSurveys(getCourseShort($_SESSION[SESSION_USER]));
                    $finishedSurveys = getFinishedSurveys($_SESSION[SESSION_USER]);
                    $unfinishedSurveys = array();
                    if (count($finishedSurveys) == 0) {
                        $unfinishedSurveys = $surveys;
                    } else {
                        foreach ($finishedSurveys as $title_finished) {
                            foreach ($surveys as $title_survey) {
                                if (!($title_finished == $title_survey)) {
                                    array_push($unfinishedSurveys, $title_survey);
                                }
                            }
                        }
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


?>