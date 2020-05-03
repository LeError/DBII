<?php
/**
 * view_survey.inc.php
 *
 * lists surveys and actions
 *
 * @author Malik Press
 */

//Prevent user form accessing file directly
if(defined('REQ')) {
    securityCheck(ROLE_ADMIN);
} else {
    require_once('../logic/security.req.php');
    checkDocument();
}

require ('./logic/survey.req.php');

if(isset($_POST["action"])) {
    header("location: index.php?view=create_survey");
} elseif (isset($_POST['delete'])) {
    deleteSurvey($_POST['delete']);
} elseif (isset($_POST['copy'])) {
    header("location: index.php?view=copy_survey");
} elseif (isset($_POST['edit'])) {
    header("location: index.php?view=edit_survey");
}
?>
<div class="ui grid">
    <div class="sixteen wide column">
    <div class="ui raised segment">
        <a class="ui red ribbon label">Overview</a>
        <form class="ui form" method="post" style="margin-top: 15px">
            <div class="ui grid">
                <div class="row">
                    <div class="column"><button class="ui right floated positive labeled icon button" type="submit" name="action" value="new"><i class="plus icon"></i>New survey</button></div>
                </div>
                <div class="row">
                    <div class="column"><h3 class="ui dividing header">My surveys</h3></div>
                </div>
            <?php
            $data = getSurveyRecords($_SESSION[SESSION_USER]);
            for ($i = 0; $i < count($data);$i++) {
                echo '
                <div class="row">
                    <div class="thirteen wide column large screen only">
                        <button class="ui fluid button" name="survey" type="submit" value="' . $data[$i] . '">' . getSurveyTitle($data[$i]) . '</button>
                    </div>
                    <div class="thirteen wide column mobile only">
                        <button class="ui fluid button" name="survey" type="submit" value="' . $data[$i] . '">' . getSurveyTitle($data[$i]) . '</button>
                    </div>
                    <div class="three wide column large screen only">
                        <div class="ui basic fluid icon buttons">
                            <button class="ui  button" name="edit" type="submit" value="' . $data[$i] . '"><i class="edit icon"></i></button>
                            <button class="ui  button" name="copy" type="submit" value="' . $data[$i] . '"><i class="copy icon"></i></button>
                            <button class="ui  button" name="delete" type="submit" value="' . $data[$i] . '"><i class="trash icon"></i></button>
                        </div>
                    </div>
                    <div class="three wide column mobile only">
                        <div class="ui right floated basic icon top right pointing dropdown button">
                            <i class="ellipsis horizontal icon"></i>
                            <div class="menu">
                                <div class="item"><button class="ui fluid basic button" name="edit" type="submit" value="' . $data[$i] . '"><i class="edit icon"></i>Edit</button></div>
                                <div class="item"><button class="ui fluid basic button" name="copy" type="submit" value="' . $data[$i] . '"><i class="copy icon"></i>Copy</button></div>
                                <div class="item"><button class="ui fluid basic button" name="delete" type="submit" value="' . $data[$i] . '"><i class="trash icon"></i>Delete</button></div>
                            </div>
                        </div>
                    </div>
                </div>';
            };
            ?>
            </div>
        </form>
    </div>
    </div>
</div>
