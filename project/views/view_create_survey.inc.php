<?php
/**
 * view_create_survey.inc.php
 *
 * View create survey
 *
 * @author     Moritz Bürkle
 */

//Prevent user form accessing file directly
if(defined('REQ')) {
    securityCheck(ROLE_ADMIN);
} else {
    require_once('../logic/security.req.php');
    checkDocument();
}

/**
 * Assign survey to user group
 * @author Malik Press
 */
require ('./logic/survey.req.php');


?>
<div class="ui container left aligned">
    <form class="ui form" method="POST" action="index.php?view=create_survey">
        <h3 class="ui dividing header">Create survey</h3>
        <h4 class="ui header">Number of questions:</h4>
        <div class="ui input">
            <input type="number" min="1" name="numberOfQuestions" placeholder="Type in the number of questions..." style="width: 650px">
        </div> <br>
        <button class="ui right labeled icon button" type="submit" value="Create survey" name="createSurvey" style="margin-top: 15px">
            <i class="right arrow icon"></i>
            Create Survey
        </button>
    </form>

    <?php

    if(isset($_POST['createSurvey'])){
        createQuestionsHTML();
    }
    if(isset($_POST['submitSurvey'])){
        createSurvey();
    }
    function createQuestionsHTML(){

        echo "
            <form class='ui form' method='POST' action='index.php?view=create_survey' style='margin-top: 20px'>
                <h4 class=\"ui header\">Title:</h4>
                <div class=\"ui input\"><input type=\"text\" maxlength=\"100\"  name=\"title\" placeholder=\"Type in the title...\" style=\"width: 650px\"></div>
                
                <h4 class=\"ui header\">Short title:</h4>
                <div class=\"ui input\"><input type=\"text\" maxlength=\"10\" name=\"titleShort\" placeholder=\"Type in the shortened title...\" style=\"width: 450px\"></div>
                
                <h4 class=\"ui header\">Assign to user groups:</h4>
                
                <div class=\"field\">
                    <div class=\"ui multiple dropdown\">
                        <input type=\"hidden\" name=\"userGroup[]\">
                        <i class=\"users icon\"></i>
                        <span class=\"text\">Assign Groups</span>
                        <div class=\"menu\">
                            <div class=\"ui icon search input\">
                                <i class=\"search icon\"></i>
                                <input type=\"text\" placeholder=\"Search user groups...\">
                            </div>
                            <div class=\"divider\"></div>
                            <div class=\"header\">
                                <i class=\"tags icon\"></i>
                                Tag Label
                            </div>
                            <div class=\"scrolling menu\">";
                                $userGroups = getUserGroups();
                                foreach ($userGroups as $value) {
                                    echo "
                                        <div class=\"item\" data-value='". $value ."'>
                                            <div class=\"ui black empty circular label\"></div>
                                            ". $value ."
                                        </div>
                                    ";
                                };
                            echo "</div>
                        </div>
                    </div>
                </div>
                
                <h4 class=\"ui header\">Questions:</h4>
             ";
        $numberOfQuestions = $_POST['numberOfQuestions'];

        for($y = 1; $y < $numberOfQuestions+1; $y++){
            echo "
                <h5 class=\"ui header\">Question {$y}:</h5>
                <div class=\"ui input\"><input type=\"text\" maxlength=\"100\" name=\"question[]\" placeholder=\"Type in the question...\" style=\"width: 650px\"></div> <br>
                 ";
        }
        echo "
            <button class=\"ui right labeled icon button\" type=\"submit\" value=\"Submit survey\" name=\"submitSurvey\" style=\"margin-top: 15px\">
                <i class=\"right arrow icon\"></i>
                Submit Survey
            </button>
            </form>
            ";

    }
    function createSurvey(){
        $title= $_POST['title'];
        // to do: check if title is already taken!
        $titleShort= $_POST['titleShort'];
        $username = $_SESSION[SESSION_USER];

        $userGroup = $_POST['userGroup'];
        $userGroupArray = explode(',',$userGroup[0]);

        $questions = $_POST['question'];
        insertSurvey($username, $title, $titleShort, $questions);

        foreach ($userGroupArray as $item) {
            assignSurveyToUserGroup($titleShort, $item);
        };
    }
    ?>
</div>