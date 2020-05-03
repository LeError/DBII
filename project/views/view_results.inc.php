<?php
/**
 * view_results.inc.php
 *
 * View results of a assigned survey for a course
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

require('logic/evaluation.php');
$assignedSurveys=getSurveys($_SESSION[SESSION_USER]);
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
    <?php
    if(isset($_POST['createSelectCourse'])){


        $assignedSurveyName = $_POST['selectedAssignedSurvey'];
        $_SESSION["assignedSurveyName"] = $assignedSurveyName;

        $assignedSurveyCourses= getAssignedSurveyCourses($assignedSurveyName);
        createSelectCourse($assignedSurveyCourses);
    }
    function createSelectCourse($assignedSurveyCourses){

        echo "
        <form method=\"post\" action=\"index.php?view=results\">
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
        $selectedCourse = $_POST['selectedCourse'];
        showResults($_SESSION["assignedSurveyName"],$selectedCourse);
    }
    function showResults($assignedSurveyName,$selectedCourse){
        $evaluationInstance = new evaluation(getTitleShort($assignedSurveyName),$selectedCourse);
        $evaluationInstance->createResultsArray();
        $results = $evaluationInstance->getResults();
        $evaluationInstance->createCommentsInArray();
        $comments = $evaluationInstance->getComments();

        echo "
        <table width=\"100%\" border=\"0\"  cellspacing=\"10px\">
        <tr>
            <th align=\"left\" colspan=\"2\">Presentation of results</th>
        </tr>
        <tr>
            <td style=\"font-weight:bold\">Question</td>
            <td style=\"font-weight:bold\">Average</td>
            <td style=\"font-weight:bold\">Minimum</td>
            <td style=\"font-weight:bold\">Maximum</td>
            <td style=\"font-weight:bold\">Standard deviation</td>
        </tr>";

        for ($i=0; $i<count($results); $i++){
                echo "
         <tr>
            <td>".
            $results[$i][0]."</td>
            <td>".$results[$i][1]."</td>
            <td>".$results[$i][2]."</td>
            <td>".$results[$i][3]."</td>
            <td>".$results[$i][4]."</td>
        </tr>";
        }
        echo "
        <table width=\"100%\" border=\"0\"  cellspacing=\"10px\">
         <tr>
            <th align=\"left\" colspan=\"2\">Comments</th>
        <tr>";
        for ($j=0; $j<count($comments); $j++) {
            echo "<tr><td>$comments[$j]</td></tr>";
        }
        echo "
        </table>";
    }
    ?>
</div>