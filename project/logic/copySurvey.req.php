<?php


/**
 * @param $titleShort
 * @param $title
 * @param $username
 * @author Leonie Rauch
 */
function deleteSurvey($titleShort, $title, $username)
{
    $query = getDbConnection()->prepare(
        "DELETE FROM survey_site.survey where title_short =? AND title=? AND username=?");
    $query->bind_param('sss', $titleShort, $title, $username);
    $query->execute();
    $query->close();
}

/**
 * @param $titleShortOld
 * @param $titleShort
 * @author Leonie Rauch
 */
function copyQuestion($titleShortOld, $titleShort)
{
    $query = getDbConnection()->prepare(
        "SELECT question FROM survey_site.question WHERE title_short = ?;");
    $query->bind_param('s', $titleShortOld);
    $query->execute();
    $query->bind_result($question);
    $result = array();
    while ($query->fetch()) {
        $result[] = $question;
    }

    $er_question = true;
    for ($i = 0; $i < count($result); $i++) {
        $query = getDbConnection()->prepare("INSERT INTO survey_site.question (question, title_short) VALUES (?,?)");
        $query->bind_param("ss", $result[$i], $titleShort);
        if (!$query->execute()) {
            publishErrorNotification("Kopieren gescheitert!");
            $er_question = false;
        }
    }
    {
        if ($er_question) {
            publishInfoNotification("Der kopierte Fragebogen wurde erfolgreich gespeichert!");
        }
        $query->close();
    }
}

/**
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
    $query->bind_param('sss', $titleShort, $title, $username);
    if (!$query->execute()) {
        deleteSurvey($titleShort, $title, $username);
        publishErrorNotification("Kopieren gescheitert!");

    } else {
        copyQuestion($titleShortOld, $titleShort);
    }
    $query->close();
}

