<?php

//Prevent user form accessing file directly
require_once('security.req.php');
checkDocument();


/**
 * delete the survey for errorhandling copy survey
 * @param $titleShort
 * @param $title
 * @param $username
 * @author Leonie Rauch
 */
function deleteSurvey($titleShort, $title, $username)
{
    $query = getDbConnection()->prepare(
        "DELETE FROM survey_site.survey where title_short =? AND title=? AND username=?");
    $titleShort=htmlspecialchars($titleShort);
    $title=htmlspecialchars($title);
    $username=htmlspecialchars($username);
    $query->bind_param('sss', $titleShort, $title, $username);
    if ($query->execute()){
        $query->close();
        return true;
    };

}

/**
 * function copy all questions from one Survey
 * @param $titleShortOld
 * @param $titleShort
 * @author Leonie Rauch
 */
function copyQuestion($titleShortOld, $titleShort)
{
    $query = getDbConnection()->prepare(
        "SELECT question FROM survey_site.question WHERE title_short = ?;");
    $titleShortOld=htmlspecialchars($titleShortOld);
    $query->bind_param('s', $titleShortOld);
    $query->execute();
    $query->bind_result($question);
    $result = array();
    while ($query->fetch()) {
        $result[] = $question;
    }
    for ($i = 0; $i < count($result); $i++) {
        $query = getDbConnection()->prepare("INSERT INTO survey_site.question (question, title_short) VALUES (?,?)");
        $query->bind_param("ss", $result[$i], $titleShort);
        $titleShort=htmlspecialchars($titleShort);
        if ($query->execute()) {
            publishInfoNotification("Der kopierte Fragebogen wurde erfolgreich gespeichert!");
        } else {
            publishErrorNotification("Kopieren gescheitert!");
        }
        $query->close();
    }
}

/**
 * copy Survey include function call copyQuestion() and deleteQuestion, if error
 * @param $titleShort
 * @param $title
 * @param $username
 * @param $titleShortOld
 * @author Leonie Rauch
 */
function copySurvey($titleShort, $title, $username, $titleShortOld)
{
    $query = getDbConnection()->prepare(
        "INSERT INTO survey_site.survey (title_short, title, username) VALUES (?, ?, ?)");
    $titleShort=htmlspecialchars($titleShort);
    $title=htmlspecialchars($title);
    $username=htmlspecialchars($username);
    $query->bind_param('sss', $titleShort, $title, $username);
    if ($query->execute()) {
        copyQuestion($titleShortOld, $titleShort);
    }else{
        $sucessfull = deleteSurvey($titleShort, $title, $username);
        if ($sucessfull) {publishErrorNotification("Kopieren gescheitert!");}
    }
    $query->close();
}

