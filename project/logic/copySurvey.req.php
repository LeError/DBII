<?php

/**
 * @author Leonie Rauch
 * @param $titleShort
 * @param $title
 * @param $username
 * @return bool
 */
function copySurvey($titleShort, $title, $username)
{
    $error = false;
    $query = getDbConnection()->prepare(
        "INSERT INTO survey_site.survey (title_short, title, username) VALUES (?, ?, ?)");
    $query->bind_param('sss', $titleShort, $title, $username);
    $query->execute();
    if (!$query->execute()){
    return $error== true;
    }
    $query->close();
}


/**
 * @author Leonie Rauch
 * @param $titleShortOld
 * @param $titleShort
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
    for ($i = 0; $i < count($result); $i++) {
        $query = getDbConnection()->prepare("INSERT INTO survey_site.question (question, title_short) VALUES (?,?)");
        $query->bind_param("ss", $result[$i], $titleShort);
        $query->execute();
    }
    $query->close();
}

?>

