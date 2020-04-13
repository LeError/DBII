<?php
/**
 * view_results.inc.php
 *
 * View results of a assigned survey for a course
 *
 * @author     Moritz Bürkle
 */

//get assigned surveys from user
$username="Leoni";
$assignedSurveys=getAssignedSurveys($username);
?>
<div class="ui container">
    <br>
    <form method="get" action="index.php">
        <table width="50%" border="0"  cellspacing="10px">
            <tr>
                <th align="left" colspan="2">Choose assigned survey</th>
            </tr>

            <tr>
                <td>Survey title:</td>
                <td>
                    <select name="selectedAssignedSurvey">
                        <?php
                        while($rows = $assignedSurveys->fetch_assoc())
                        {
                            $assignedSurveyName = $rows['title'];
                            echo "<option value='$assignedSurveyName'>$assignedSurveyName</option>";
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td align="left" colspan="2"><input type="submit" value="Select course" name="createSelectCourse"></td>
            </tr>
        </table>
    </form>
    <?php

    if(isset($_POST['createSelectCourse'])){

        $assignedSurveyName = $_POST['selectedAssignedSurvey'];
        $assignedSurveyCourses= getAssignedSurveyCourses($assignedSurveyName);
        createSelectCourse($assignedSurveyCourses);
    }

    function createSelectCourse($assignedSurveyCourses){

        echo "
                <form method=\"get\" action=\"index.php\">
        <table width=\"50%\" border=\"0\"  cellspacing=\"10px\">
            <tr>
                <th align=\"left\" colspan=\"2\">Choose course</th>
            </tr>

            <tr>
                <td>Course:</td>
                <td>
                    <select name=\"selectedCourse\">";

                        while($rows = $assignedSurveyCourses->fetch_assoc())
                        {
                            $assignedSurveyCourse = $rows['course_short'];
                            echo "<option value='$assignedSurveyCourse'>$assignedSurveyCourse</option>";
                        }
                        echo "                    
                    </select>
                </td>
            </tr>
            <tr>
                <td align=\"left\" colspan=\"2\"><input type=\"submit\" value=\"Select course\" name=\"createSelectCourse\"></td>
            </tr>
        </table>
    </form>";
    }
    ?>


</div>