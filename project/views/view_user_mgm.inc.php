<?php
/**
 * view_user_mgm.inc.php
 *
 * lists surveys and actions
 *
 * @author Malik Press
 */
require ('./logic/survey.req.php');
?>
<div class="ui grid">
    <div class="ui sixteen wide column right aligned">
        <a href="index.php?view=create_survey">
            <form method="post">
                <button class="ui positive labeled icon button" name="action" type="submit" value="new" style="margin-top: 3vh"><i class="plus icon"></i>Neuen Kurs Anlegen</button>
            </form>
        </a>
    </div>
    <div class="ui sixteen wide column">
        <h3 class="ui header">Kurs Übersicht</h3>
    </div>
    <div class="ui sixteen wide column">
        <form method="post">
            <?php
                displayCourses();
            ?>
        </form>
    </div>
    <br>
</div>