<?php
/**
 * view_edit_course.inc.php
 *
 * View Form for Creating a course
 *
 * @author     Robin Herder
 */

?>
<div class="container ui">
    <?php
        checkCourseExists($_GET['course']);
    ?>
</div>
<div class="ui two column grid center aligned" style="margin-top: 30px">
    <div class="column">
        <div class="ui raised segment left aligned">
            <div class="ui blue ribbon label">Create</div>
            <span>Neuen Studenten Anlegen</span>
            <form id="create_course" action="index.php?view=edit_course&course=<?php if(isset($_GET['course'])) { echo $_GET['course']; }?>" method="post" class="ui large form" style="margin: 25px 10px 10px;">
                <div class="field">
                    <div class="field">
                        <div class="ui labeled input disabled">
                            <div class="ui label">
                                K&uuml;rzel
                            </div>
                            <input value="<?php echo $_GET['course']?>" maxLength="8" type="text" name="c_course_short" placeholder="WWIBE118">
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="ui labeled input">
                        <div class="ui label">
                            Matrikel Nummer
                        </div>
                        <input maxLength="7" type="text" name="c_mat_nr" placeholder="0000000">
                    </div>
                </div>
                <div class="field">
                    <div class="ui labeled input">
                        <div class="ui label">
                            Name
                        </div>
                        <input maxLength="50" type="text" name="c_name" placeholder="Steve Jobs">
                    </div>
                </div>
                <button class="ui fluid large teal button submit" type="submit">Erstellen</button>
                <div class="ui error message"></div>
            </form>
        </div>
    </div>
    <div class="column">
        <div class="ui raised segment left aligned">
            <div class="ui red ribbon label">Delete</div>
            <span>Einen Nutzer Löschen</span>
            <form id="create_course" action="index.php?view=edit_course&course=<?php if(isset($_GET['course'])) { echo $_GET['course']; }?>" method="post" class="ui large form" style="margin: 25px 10px 10px;">
                <div class="field">
                    <div class="ui labeled input">
                        <div class="ui label">
                            Student
                        </div>
                        <select name="d_student">
                            <?php
                                $query = getDbConnection()->prepare('
                                    SELECT u.matricule_number, u.username FROM survey_site.survey_user u 
                                    WHERE u.course_short = ?
                                    ORDER BY u.username ASC;
                                ');
                                $query->bind_param('s', $_GET['course']);
                                if($query->execute()) {
                                    $result = $query->get_result();
                                    while($row = $result->fetch_assoc()) {
                                        echo '<option value="'.$row['matricule_number'].'">'.$row['username'].' ('.$row['matricule_number'].')'.'</option>';
                                    }
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <button class="ui fluid large red button submit" type="submit">L&ouml;schen</button>
                <div class="ui error message"></div>
            </form>
        </div>
    </div>
</div>
