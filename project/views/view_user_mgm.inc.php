<?php
/**
 * view_user_mgm.inc.php
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
            <form method="post" action="index.php?view=new_course">
                <button class="ui positive labeled icon button" type="submit" style="margin-top: 3vh"><i class="plus icon"></i>Neuen Kurs Anlegen</button>
            </form>
        </a>
    </div>
    <div class="ui sixteen wide column">
        <h3 class="ui header">Kurs Übersicht</h3>
    </div>
    <div class="ui sixteen wide column">
        <div class="ui middle aligned animated list">
        <?php
            if(!isset($_GET['course'])) {
                displayCourses();
            } else if(isset($_POST['course'])) {
                displayCourse($_GET['course']);
            } else if(isset($_POST['edit'])) {
                header('Location: index.php?view=edit_course&course='.$_GET['course']);
            } else if(isset($_POST['delete'])) {
                deleteCourse($_GET['course']) or publishErrorNotification('Unable to delete course)');
                header('location: index.php?view=user_mgm');
            }
        ?>
        </div>
    </div>
    <br>
</div>