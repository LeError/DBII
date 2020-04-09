<?php
/**
 * view_survey.inc.php
 *
 * Create Survey
 *
 * @author     Moritz Bürkle
 */

include_once 'logic/db.req.php';
?>

<div class="ui container">

    <br>
    <form method="get" action="index.php">
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

        global $link;

        if(isset($_GET['createQuestion'])){
            createQuestionsHTML();
        }
        if(isset($_GET['createSurvey'])){
            createSurvey();
        }


        function createQuestionsHTML(){


            $titleShort = $_GET['titleShort'];
            $title = $_GET['title'];
            $username = "HARDCODEUSER";

            global $titleShort, $title, $username;

            echo "
            <table width='50%' border='0'  cellspacing='10px'>
            <tr>
                <th align='left' colspan='2'>Create questions</th>
            </tr>
            ";
            $numberOfQuestions = $_GET['numberOfQuestions'];

            for($y = 1; $y < $numberOfQuestions+1; $y++){
                echo "
                <tr>
                <td>Question {$y}:</td>
                <td><input maxlength='100' name='question[]' type='text' size='60'/></td>
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
        function createSurvey(){
            //Übertragung der GLOBALS in Variablen, da GLOBALS nicht in INSERT INTO statement angesprochen werden können.
            $titleShort=$GLOBALS['titleShort'];
            $title=$GLOBALS['title'];
            $username=$GLOBALS['$username'];

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

        }
        ?>
    </form>
</div>