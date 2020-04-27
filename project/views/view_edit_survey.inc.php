<?php

/**
 * @author Leonie Rauch
 */

$titleShort = "test0";
$title = "Test 0";
require('./logic/editSurvey.req.php');
?>

    <div class="ui grid">
        <div class="ui sixteen wide column"></div>
        <div class="ui sixteen wide column">
            <h3 class="ui header">Edit survey: <?php print($_SESSION['title']) ?></h3>
        </div>

        <table width="50%" border="0" cellspacing="10px">
            <form action="" method="post">
                <tr>
                    <td align="left" colspan="2">Frage hinzufügen:</td>
                    <td><input max="100" name="question" type="text"/></td>
                </tr>
                <tr>
                    <td>
                        <button class="ui button" name="insertQuestion" type="submit" style="width: 7vw;">Save</button>
                    </td>
                </tr>
            </form>
            <table>
    </div>


<?php

/*neue Frage hinzufügen*/
if (isset($_POST["insertQuestion"])) {
    if (($_POST['question']) == "") {
        publishWarningNotification("Bitte alle Felder befüllen!");
    } else {
        insertQuestion($_POST["question"], $titleShort);
    }
}


/*Fragen anzeigen*/
showQuestions($title);

/*Fragen löschen*/
if (isset($_POST["delete"])) {
    $id = ($_POST["delete"]);
    deleteQuestion($id);
}




