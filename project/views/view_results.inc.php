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
                    <select name="assignedSurvey">
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
                <td align="left" colspan="2"><input type="submit" value="Select course" name="createSurvey"></td>
            </tr>
        </table>
    </form>


</div>