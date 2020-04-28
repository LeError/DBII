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
?>
<div class="ui grid">
       <div class="ui sixteen wide column right aligned">
           <a href="index.php?view=create_survey">
                <form method="post">
                     <button class="ui positive labeled icon button" name="action" type="submit" value="new" style="margin-top: 3vh"><i class="plus icon"></i>Neue Umfrage erstellen</button>
                </form>
           </a>
       </div>
       <div class="ui sixteen wide column">
            <h3 class="ui header">Meine Umfragen</h3>
       </div>
       <div class="ui sixteen wide column">
           <form method="post">
           <?php
                $name  = 'Malik';
                $data = getSurveyRecords($name);
                for ($i = 0; $i < count($data);$i++) {
                    echo '<div class="bd-survey-list-item" style="padding-bottom: 0.75vh;">
                <button class="ui button" name="action" type="submit" value="survey'. $i .'" style="width: 50vw;">' . $data[$i] . '</button>
                <button class="ui inverted secondary icon button" name="action" type="submit" value="edit'. $i .'"><i class="edit icon"></i></button>
                <button class="ui inverted secondary icon button" name="action" type="submit" value="copy'. $i .'"><i class="copy icon"></i></button>
                <button class="ui inverted red icon button" name="action" type="submit" value="delete'. $i .'"><i class="trash icon"></i></button>
            </div>';
                };
           ?>
           </form>
       </div>
    <br>
</div>