<?php
/**
 * view_survey.inc.php
 *
 * Create Survey
 *
 * @author     Moritz Bürkle
 */
?>

<div class="ui container">

    <br>
    <form method="post" action="index.php">
        <table width="50%" border="0"  cellspacing="10px">
            <tr>
                <th align="left" colspan="2">Create survey</th>
            </tr>
            <tr>
                <td>Titel:</td>
                <td><input maxlength="100" name="title" type="text" size="45"/></td>
            </tr>
            <tr>
                <td>Titel short:</td>
                <td><input maxlength="10" name="titleShort" type="text"     /></td>
            </tr>
            <tr>
                <td>Number of questions:</td>
                <td><input  min="1" value="1" name="numberOfQuestions" type="number" /></td>
            </tr>
            <tr>
                <td align="left" colspan="2"><input type="submit" value="Create questions" name="createQuestion"></td>
            </tr>
        </table>

        <?php
        if(isset($_POST['createQuestion'])){
            createQuestionsHTML();

        }

        function createQuestionsHTML(){
            echo "
            <table width='50%' border='0'  cellspacing='10px'>
            <tr>
                <th align='left' colspan='2'>Create questions</th>
            </tr>
            ";
            $numberOfQuestions = $_POST['numberOfQuestions'];

            for($y = 1; $y < $numberOfQuestions+1; $y++){
                echo "
                <tr>
                <td>Frage {$y}:</td>
                <td><input maxlength='100' name='frage{$y}' type='text' size='45'/></td>
                </tr>
                 ";
            }
            echo "
            <tr>
                <td align='left' colspan='2'><input type='submit' value='Create survey' name='createSurvey'></td>
            </tr>
            </table>
            ";

        }
        ?>
    </form>
</div>