<div class="ui container">
    <form method="get" action="index.php?view=create_survey">
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
            <form method=\"get\" action=\"index.php?view=create_survey\">
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
        insertSurvey($username, $title, $titleShort, $questions);
    }
    ?>
    </form>
</div>