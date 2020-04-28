<?php
/**
 * view_new_course.inc.php
 *
 * View Form for Creating a course
 *
 * @author     Robin Herder
 */

//Prevent user form accessing file directly
if(defined('REQ')) {
    securityCheck(ROLE_ADMIN);
} else {
    require_once('../logic/security.req.php');
    checkDocument();
}

?>

<div class="ui one column grid center aligned" style="margin-top: 30px">
    <div class="column">
        <div class="ui raised segment left aligned">
            <div class="ui blue ribbon label">Create</div>
            <span>Neuen Kurs anlegen</span>
            <form id="create_course" action="index.php?view=new_course" method="post" class="ui large form" style="margin: 25px 10px 10px;">
                <div class="field">
                    <div class="ui labeled input">
                        <div class="ui label">
                            K&uuml;rzel
                        </div>
                        <input maxLength="8" type="text" name="c_course_short" placeholder="WWIBE118">
                    </div>
                </div>
                <div class="field">
                    <div class="ui labeled input">
                        <div class="ui label">
                            Kurs
                        </div>
                        <input maxLength="50" type="text" name="c_course" placeholder="WWI118 Business Engineering">
                    </div>
                </div>
                <button class="ui fluid large teal button submit" type="submit">Erstellen</button>
                <div class="ui error message"></div>
            </form>
        </div>
    </div>
</div>
