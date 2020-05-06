<?php
/**
 * @author Leonie Rauch
 */
//Prevent user form accessing file directly
if(defined('REQ')) {
    securityCheck(ROLE_USER);
} else {
    require_once('../logic/security.req.php');
    checkDocument();
}

$title = getSurveyTitle($_SESSION["titleShort"]);
$valueComment= getComment($_SESSION["titleShort"], $_SESSION[SESSION_USER])?>

    <div class="ui one column grid center aligned" style="margin-top: 30px">
        <div class="column">
            <div class="ui raised segment left aligned">
                <div class="column"><h3 class="ui dividing header">Fragebogen <?php echo $title;?> beantworten</h3></div>
                <div class="ui grid">
                    <div class="ui sixteen wide column"></div>
                    <div class="row"><h5 class="ui header"> Es können Werte von 1 (gut) bis 5 (schlecht) vergeben werden!</h5>
                    </div>
                </div>
                <form action="" method="post">
                <table class="ui striped collapsing celled table">
                    <thead>
                    <tr>
                        <th>Frage </th>
                        <th>Bisheriger Wert</th>
                        <th>Zu vergebener Wert</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php

    $sql ="SELECT id, question  FROM survey_site.question WHERE title_short = ?;";
    if ($query = getDbConnection()->prepare($sql)) {
        $query->bind_param('s', $_SESSION["titleShort"]);
        $query->execute();
        $query->bind_result($id, $question);
        $result = $query->get_result();

        $e = function ($value) {
            return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
        };
        if(isset($_POST["range"]))
        {
            $test = $_POST["range"];
        }else{
            $test="";
        }
        foreach ($result as $row):
            $id = $e($row['id']);
            $question = $e($row['question']);
            $valueDb = getAnswerValue($id, $_SESSION[SESSION_USER]);

echo "                            <tr>
                                <td> $question </td>
                                <td> $valueDb</td>
                                <td>
                                    <div class=\"ui input\">
                                    <input type=\"number\" name=\"range\" min=\"1\" max=\"5\" step=\"1\">
                                     </div>
                                </td>
                                <td> <button class=\"ui button\"  value= " . $id." name=\"saveQuestionx\" type=\"submit\" style=\"width: 10vw;\">Frage speichern</button></td>
                                </td>
                            </tr>";
                endforeach;;
            $query->close();} ?>

                    </tbody>
                </table>
                <div class="ui grid">
                    <div class="ui sixteen wide column"></div>
                    <div class="ui sixteen wide column">
                        <h4 class="ui header">Einen Kommentar hinzufügen</h4>
                    </div>
                    <div class="field">
                        <div class="ui labeled input">
                            <div class="ui label">
                                Kommentar:
                            </div>
                            <div class="ui input">
                            <input type="text" name="comment" value =<?php if($valueComment) echo $valueComment?>>
                        </div>
                        </div>
                    </div>
                    <button class="ui teal button submit" name="saveComment" type="submit">Kommentar speichern</button>

                    <div class="row">
                        <div class="column"><button class="ui teal right floated button" type="submit" name="saveSurvey">Fragebogen absenden</button></div>
                    </div>
                </div>
                </form>
            </div>

        </div>
    </div>

<?php


if(isset($_POST["saveComment"])){
    if(($_POST["comment"])==""){
        publishWarningNotification("Um Kommentar zu speichern muss Feld befüllt werden!");
    }elseif (getComment($_SESSION["titleShort"], $_SESSION[SESSION_USER])){
        publishWarningNotification("Es wurde bereits ein Kommentar gespeichert");
    } else{
        insertSurveyComment($_SESSION[SESSION_USER],$_SESSION["titleShort"], $_POST["comment"]);
    }}

    if(isset($_POST["saveSurvey"])){

        testAllQuestionsAreAnswered($_SESSION["titleShort"],$_SESSION[SESSION_USER] );
    }


    if(isset($_POST["saveQuestionx"])){
        if(($_POST["range"])==""){
            publishWarningNotification("Um Frage zu speichern muss Wert eingegeben werden!".$_POST["range"]);
        }else{
                saveScoringSystem($_POST["saveQuestionx"], $_SESSION[SESSION_USER],$_POST["range"]);
            }}





