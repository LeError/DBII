<?php

/**
 * view to insert new Question to Survey or delete Survey
 * @author Leonie Rauch
 */

/**
 * feature to assign and unassign courses to the survey
 * @author Malik Press
 */

//Prevent user form accessing file directly
if(defined('REQ')) {
    securityCheck(ROLE_ADMIN);
} else {
    require_once('../logic/security.req.php');
    checkDocument();
}

require('./logic/editSurvey.req.php');
require ('./logic/survey.req.php');

checkWhetherInUse($_SESSION["titleShort"]);
$title = getTitle($_SESSION["titleShort"]);
?>
    <div class="ui one column grid center aligned" style="margin-top: 30px">
        <div class="column">
            <div class="ui raised segment left aligned">
                <div class="column"><h3 class="ui dividing header">Anpassen des Fragebogens: <?php echo $title ?></h3></div>
                <form action="" method="post" class="ui  form" style="margin: 25px 10px 10px;">
                    <div class="field">
                        <div class="ui labeled input">
                            <div class="ui label">
                               Frage hinzufügen
                            </div>
                                <input max="100" name="question" type="text">
                        </div>
                    </div>
                        <button class="ui  teal button submit" name="insertQuestion" type="submit">Frage speichern</button>
                </form>

                <div class="ui grid">
                    <div class="ui sixteen wide column"></div>
                    <div class="ui sixteen wide column">
                        <h4 class="ui header">Kurse zuordnen</h4>
                        <form class="ui form" method="post">
                            <div class="field">
                                <div class="ui multiple dropdown">
                                    <?php
                                        $assignedGroups = getAssignedGroups($_SESSION["titleShort"]);
                                        if (count($assignedGroups) == 0) {
                                            echo "<input type='hidden' name='userGroup[]'>";
                                        } else {
                                            echo "<input type='hidden' name='userGroup[]' value='" . implode(',',$assignedGroups) . "'>";
                                        }
                                    ?>
                                    <i class="users icon"></i>
                                    <?php
                                        if (count($assignedGroups) != 0) {
                                            foreach ($assignedGroups as $value) {
                                                echo "
                                                    <a class='ui label transition visible' data-value='" . $value . "' style='display: inline-block !important;'>
                                                        <div class='ui black empty circular label'></div>
                                                        " . $value . "
                                                        <i class='delete icon'></i>
                                                    </a>
                                                ";
                                            }
                                        }
                                    ?>
                                    <span class="text">Assign Groups</span>
                                    <div class="menu">
                                        <div class="ui icon search input">
                                            <i class="search icon"></i>
                                            <input type="text" placeholder="Search user groups...">
                                        </div>
                                        <div class="divider"></div>
                                        <div class="header">
                                            <i class="tags icon"></i>
                                            Tag Label
                                        </div>
                                        <div class="scrolling menu">
                                            <?php
                                                if(count($assignedGroups) != 0) {
                                                    foreach ($assignedGroups as $value) {
                                                        echo "
                                                          <div class=\"item active filtered\" data-value='" . $value . "'>
                                                              <div class=\"ui black empty circular label\"></div>
                                                              " . $value . "
                                                          </div>
                                                         ";
                                                    }
                                                }
                                                $userGroups = getUserGroups();
                                                foreach ($userGroups as $value) {
                                                    if(count($assignedGroups) != 0) {
                                                        foreach ($assignedGroups as $value2) {
                                                            if (!($value == $value2)) {
                                                                echo "
                                                                <div class=\"item\" data-value='" . $value . "'>
                                                                    <div class=\"ui black empty circular label\"></div>
                                                                    " . $value . "
                                                                </div>
                                                            ";
                                                            }
                                                        }
                                                    } else {
                                                        echo "
                                                                <div class=\"item\" data-value='" . $value . "'>
                                                                    <div class=\"ui black empty circular label\"></div>
                                                                    " . $value . "
                                                                </div>
                                                            ";
                                                    }
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <button class="ui teal button submit" name="assignCourse" type="submit">Kurse speichern</button>
                        </form>
                    </div>
                    <div class="ui sixteen wide column">
                        <h4 class="ui header">Beinhaltete Fragen</h4>
                    </div>
                </div>

                <table class="ui striped collapsing celled table">
                    <thead>
                        <tr>
                            <th>Fragen-Nummer </th>
                            <th>Frage</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <form action="" method="post">
                            <?php showQuestions($title);?>
                        </form>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


<?php

/*neue Frage hinzufügen*/
if (isset($_POST["insertQuestion"])) {
    if (($_POST['question']) == "") {
        publishWarningNotification("Bitte alle Felder befüllen!");
    } else {
        insertQuestion($_POST["question"], $_SESSION["titleShort"]);
    }
}

/*Fragen löschen*/
if (isset($_POST["deleteQ"])) {
    deleteQuestion(($_POST["deleteQ"]));

}

if (isset($_POST["assignCourse"])) {
    $oldUserGroup = getAssignedGroups($_SESSION["titleShort"]);
    if(count($oldUserGroup) != 0) {
        foreach ($oldUserGroup as $value) {
            unAssignSurveyFromUserGroup($_SESSION["titleShort"], $value);
        }
    }
    $newUserGroup = $_POST['userGroup'];
    $newUserGroupArray = explode(',',$newUserGroup[0]);
    if(count($newUserGroupArray) != 0) {
        foreach ($newUserGroupArray as $value) {
            assignSurveyToUserGroup($_SESSION["titleShort"], $value);
        }
    }
    publishInfoNotification("Kurse wurden aktualisiert!");
}
?>