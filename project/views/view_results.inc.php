<?php
/**
 * view_results.inc.php
 *
 * View results of a assigned survey for a course
 *
 * @author     Moritz Bürkle
 */

$username="Leoni";
$assignedSurveys=getAssignedSurveys($username);
?>
<div class="ui container">
    <br>
    <form method="post" action="index.php?view=results">
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

    <table width="100%" border="0"  cellspacing="10px">
        <tr>
            <th align="left" colspan="2">Presentation of results</th>
        </tr>
        <tr>
            <td>Question</td>
            <td>Average</td>
            <td>Minimum</td>
            <td>Maximum</td>
            <td>Standard deviation</td>
        </tr>
        <tr>
            <td>$results[i][0]</td>
            <td>$results[i][1]</td>
            <td>$results[i][2]</td>
            <td>$results[i][3]</td>
            <td>$results[i][4]</td>
        </tr>
        <tr>
            <td>$results[i][0]</td>
            <td>$results[i][1]</td>
            <td>$results[i][2]</td>
            <td>$results[i][3]</td>
            <td>$results[i][4]</td>
        </tr>
    </table>

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
                <td align=\"left\" colspan=\"2\"><input type=\"submit\" value=\"Show results\" name=\"showResults\"></td>
            </tr>
        </table>
    </form>";
    }
    if(isset($_POST['showResults'])){

        $assignedSurveyName = $_POST['selectedAssignedSurvey'];
        $selectedCourse = $_POST['selectedCourse'];

        showResults($assignedSurveyName,$selectedCourse);
    }
    function showResults($assignedSurveyName,$selectedCourse){

        $evaluationInstance = new evaluation(getTitleShort($assignedSurveyName),$selectedCourse);
        $evaluationInstance->createResultsArray();
        $results = $evaluationInstance->getResults();
        $evaluationInstance->createCommentsInArray();
        $comments = $evaluationInstance->getComments();
    }

    ?>


</div>