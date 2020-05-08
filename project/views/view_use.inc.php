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
$valueComment = getComment($_SESSION["titleShort"], $_SESSION[SESSION_USER]);

$query = getDbConnection()->prepare(
    "SELECT id, question  FROM survey_site.question WHERE title_short = ?;");
$query->bind_param('s', $_SESSION["titleShort"]);
$query->execute();
$result = $query->get_result();
$arrQuestions = array();
while ($row = $result->fetch_assoc()) {
    $arrQuestions[] = array($row["id"], $row["question"]);
}

$keys = array_keys($arrQuestions);
if (!isset($_SESSION["q"])) {
    $_SESSION["q"] = 0;

}
$r = $_SESSION["q"] + 1;
$anzahlFragen = count($keys);


if (isset($_POST["next"]) && $_SESSION["q"] < $anzahlFragen) {
    if(isset($_POST["range"])){
    saveScoringSystem($arrQuestions[$_SESSION["q"]][0], $_SESSION[SESSION_USER], $_POST["range"]);}
    $_SESSION["q"]++;
    $r++;
} else if (isset($_POST["back"]) && $_SESSION["q"] > 0) {
    if(isset($_POST["range"])){
    saveScoringSystem($arrQuestions[$_SESSION["q"]][0], $_SESSION[SESSION_USER], $_POST["range"]);}
    $_SESSION["q"]--;
    $r--;

}

if (isset($_POST["saveComment"])) {
    if (($_POST["comment"]) == "") {
        publishWarningNotification("Um Kommentar zu speichern muss Feld befüllt werden!");
    } elseif (getComment($_SESSION["titleShort"], $_SESSION[SESSION_USER])) {
        publishWarningNotification("Es wurde bereits ein Kommentar gespeichert");
    } else {
        insertSurveyComment($_SESSION[SESSION_USER], $_SESSION["titleShort"], $_POST["comment"]);
    }
}
if (isset($_POST["saveSurvey"])) {
    if(isset($_POST["range"])){
    saveScoringSystem($arrQuestions[$_SESSION["q"]][0], $_SESSION[SESSION_USER], $_POST["range"]);}
    testAllQuestionsAreAnswered($_SESSION["titleShort"], $_SESSION[SESSION_USER]);

}

echo '<div class="ui grid">';
echo '<div class="sixteen wide column">';
echo '<form method="post" action="index.php?view=use">';
echo '<h3 class="ui dividing header">Beantwortung des Fragebogens ' . $title . ' mit insgesamt ' . $anzahlFragen . ' Fragen </h3>';

if ($valueComment) {
    echo '<h4 class="ui header">Kommentar: ' . $valueComment . '</h4>';
} else {
    echo '<h4 class="ui header">Einen Kommentar hinzufügen</h4>';
    echo '<div class="field">';
    echo '<div class="ui labeled input">
        <div class="ui label"> Kommentar</div>';
    echo '<input type="text" name="comment" max="500" ></div>';
    echo '<button class="ui right floated teal button submit" name="saveComment" type="submit">Kommentar speichern </button></div>';
}


    echo '<h5 class="ui header"> Es können Werte von 1 (gut) bis 5 (schlecht) vergeben werden!</h5>';
    echo '<div class="ui raised segment">';

if ($_SESSION["q"] < $anzahlFragen) {
    echo '<div class="row"> <h4 class="ui dividing header"> Frage '. $r . ': ' . $arrQuestions[$_SESSION ["q"]][1].' </h4></div>';
    $valueDb = getAnswerValue($arrQuestions[$_SESSION["q"]][0], $_SESSION[SESSION_USER]);
    echo '<p> <div class="ui form"> <div class="inline fields">';

    for ($i = 1; $i <= 5; $i++) {
        echo '<div class="field"> <div class="ui radio checkbox"> <input type="radio"  id = '.$i.' name="range" value='.$i.'';
        if ($i == $valueDb) {
            echo ' checked >';
        } else {
            echo '>';
        }
        echo '<label for='.$i.'>'.$i.'</label><br> </div></div>';
    }
    echo '</div></div></p>';
}


$back = "";
if ($_SESSION["q"] == 0) {
    $back = "disabled";
}
$next = "";
if ($_SESSION["q"] == $anzahlFragen - 1) {
    $next = "disabled";
}
echo '</div></div>';
echo '<div class="field"><p>';
echo '<input type="submit" style="float:left" name="back" value="Vorherige Frage" ' . $back . '>';
echo '<input type="submit" style="float:left" name="next" value="Nächste Frage"' . $next . '>';
echo "</p></div></div>";

echo '<div class="field">';
echo'<button class="ui teal right floated button" type="submit" name="saveSurvey">Fragebogen absenden </button>';
echo "</form> </div></div>";