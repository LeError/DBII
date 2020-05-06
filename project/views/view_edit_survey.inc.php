<?php

/**
 * view to insert new Question to Survey or delete Survey
 * @author Leonie Rauch
 */

//Prevent user form accessing file directly
if(defined('REQ')) {
    securityCheck(ROLE_ADMIN);
} else {
    require_once('../logic/security.req.php');
    checkDocument();
}

require('./logic/editSurvey.req.php');

checkWhetherInUse($_SESSION["titleShort"]);
$title = getTitle($_SESSION["titleShort"]);
?>

    <div class="ui one column grid center aligned" style="margin-top: 30px">
        <div class="column">
            <div class="ui raised segment left aligned">
                <div class="column"><h3 class="ui dividing header">Anpassen des Fragebogens: <?php echo $title ?></h3></div>

                <form action="" method="post" class="ui  form" style="margin: 25px 10px 10px;">
                    <div class="field">
                        <div class="ui labeled input">
                            <div class="ui label">
                               Frage hinzufügen
                            </div>
                                <input max="100" name="question" type="text">
                        </div>
                    </div>
                        <button class="ui  teal button submit" name="insertQuestion" type="submit">Frage speichern</button>
                </form>




    <div class="ui grid">
        <div class="ui sixteen wide column"></div>
        <div class="ui sixteen wide column">
            <h4 class="ui header">Beinhaltete Fragen</h4>
        </div>
    </div>

        <table class="ui striped collapsing celled table">
            <thead>
            <tr>
                <th>Fragen-Nummer </th>
                <th>Frage</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <form action="" method="post">
<?php showQuestions($title);?>
            </form>
            </tbody>
        </table>
    </div>
            </div>
        </div>
    </div>


<?php

/*neue Frage hinzufügen*/
if (isset($_POST["insertQuestion"])) {
    if (($_POST['question']) == "") {
        publishWarningNotification("Bitte alle Felder befüllen!");
    } else {
        insertQuestion($_POST["question"], $_SESSION["titleShort"]);
    }
}

/*Fragen löschen*/
if (isset($_POST["deleteQ"])) {
    deleteQuestion(($_POST["deleteQ"]));

}
