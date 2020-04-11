     <!--
     * index.php
     *
     * Survey View
     *
     * @author     Malik Press
     * -->
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

<div class="ui grid">
       <div class="ui sixteen wide column">
            <button class="ui positive labeled icon button" style="margin-top: 3vh"><i class="plus icon"></i>Neue Umfrage erstellen</button>
       </div>
       <div class="ui sixteen wide column">
            <h3 class="ui header">Meine Umfragen</h3>
       </div>
       <div class="ui sixteen wide column">
            <div class="bd-survey-list-item" style="padding-bottom: 0.75vh;">
                <button class="ui button" style="width: 50vw;">Titel</button>
                <button class="ui inverted secondary icon button"><i class="edit icon"></i></button>
                <button class="ui inverted secondary icon button"><i class="copy icon"></i></button>
                <button class="ui inverted red icon button"><i class="trash icon"></i></button>
            </div>
            <div class="bd-survey-list-item" style="padding-bottom: 0.75vh;">
                <button class="ui button" style="width: 50vw;">Titel</button>
                <button class="ui inverted secondary icon button"><i class="edit icon"></i></button>
                <button class="ui inverted secondary icon button"><i class="copy icon"></i></button>
                <button class="ui inverted red icon button"><i class="trash icon"></i></button>
            </div>
       </div>
    <br>
    <form method="get" action="index.php">
        <table width="50%" border="0"  cellspacing="10px">
            <tr>
                <th align="left" colspan="2">Create survey</th>
            </tr>

            <tr>
                <td>Number of questions:</td>
                <td><input  min="1" value="1" name="numberOfQuestions" type="number" /></td>
            </tr>
            <tr>
                <td align="left" colspan="2"><input type="submit" value="Create survey" name="createSurvey"></td>
            </tr>
        </table>
    </form>

        <?php

        if(isset($_GET['createSurvey'])){
            createQuestionsHTML();
        }
        if(isset($_GET['submitSurvey'])){
            createSurvey();
        }
        function createQuestionsHTML(){

            echo "
            <form method=\"get\" action=\"index.php\">
            <table width='50%' border='0'  cellspacing='10px'>
            <tr>
                <th align='left' colspan='2'>Set title and title short</th>
            </tr>
            <tr>
                <td>Titel:</td>
                <td><input maxlength=\"100\" name=\"title\" type=\"text\" size=\"45\"/></td>
            </tr>
            <tr>
                <td>Titel short:</td>
                <td><input maxlength=\"10\" name=\"titleShort\" type=\"text\" /></td>
            </tr>
            </table>
            <table width='50%' border='0'  cellspacing='10px'>
            <tr>
                <th align='left' colspan='2'>Create questions</th>
            </tr>
            ";
            $numberOfQuestions = $_GET['numberOfQuestions'];

            for($y = 1; $y < $numberOfQuestions+1; $y++){
                echo "
                <tr>
                <td>Quest. {$y}:</td>
                <td><input maxlength='100' name='question[]' type='text' size='60'/></td>
                </tr>
                 ";
            }
            echo "
            <tr>
                <td align='left' colspan='2'><input type='submit' value='Create survey' name='submitSurvey'></td>
            </tr>
            </table>
            </form>
            ";

        }
        function createSurvey(){

            $title= $_GET['title'];
            $titleShort= $_GET['titleShort'];
            $username = "HARDCODEUSER";
            $questions = $_GET['question'];
            //echo $title.$titleShort.$username;
            //print_r($questions);
            insertSurvey($username, $title, $titleShort, $questions);
            /*
            //Create data survey
            $sql = "INSERT INTO survey (title_short, title, username) VALUES ('$titleShort',$title,$username);";
            mysqli_query($GLOBALS['link'], $sql);

            //Create data questions
            $questionsArray = $_GET['question[]'];
            foreach ($questionsArray as $question){
                $sql = "INSERT INTO question (question, title_short) VALUES ('$question','$titleShort');";
                mysqli_query($GLOBALS['link'], $sql);
            }
            echo "Survey succesfully created";
            */
        }
        ?>
    </form>
</div>