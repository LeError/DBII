<?php

//Prevent user form accessing file directly
require_once('security.req.php');
checkDocument();

/**
 * @param $titleShort
 * @return mixed
 * @author Leonie Rauch
 */
function getTitle($titleShort)
{
    $query = getDbConnection()->prepare("SELECT title  FROM survey_site.survey  where title_short= ?");
    $titleShort=htmlspecialchars($titleShort);
    $query->bind_param('s', $titleShort);
    $query->execute();
    $query->bind_result($title);
    $query->fetch();
    $query->close();
    return $result = $title;
}

/**
 * @param $titleShort
 * @author Leonie Rauch
 */
function checkWhetherInUse($titleShort)
{
    $query = getDbConnection()->prepare(
        "SELECT a.id FROM survey_site.answer a, 
survey_site.question q, survey_site.survey s WHERE q.title_short = ? AND q.id = a.id");
    $titleShort=htmlspecialchars($titleShort);
    $query->bind_param('s', $titleShort);
    $query->execute();
    $result = $query->get_result();
    if ($result->num_rows != 0) {
        publishErrorNotification("Fragebogen" . $titleShort . " kann nicht bearbeitet werden, da er bereits von Studenten genutzt wird!");
        echo '<script type="application/javascript">  window.location.replace("index.php?view=survey/"); </script>';
    }
    $query->close();
}

/**
 * show all Question with Id in table
 * @param $title
 * @author Leonie Rauch
 */

function showQuestions($title)
{
    $sql = "SELECT id, question  FROM survey_site.survey s, survey_site.question q where s.title_short = q.title_short AND s.title = ?;";
    if ($query = getDbConnection()->prepare($sql)) {
        $title=htmlspecialchars($title);
        $query->bind_param('s', $title);
        $query->execute();
        $query->bind_result($id, $question);
        $result = $query->get_result();

        $e = function ($value) {
            return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
        };
        foreach ($result as $row):
            $id = $e($row['id']);
            $question = $e($row['question']);

            echo "
                   <td> $id </td> 
                   <td> $question </td>
                    <td> <button class=\"ui button\" name=\"deleteQ\" type=\"submit\" value= $id style=\"width: 5vw;\"><i class=\"trash icon\"></i></button></td>
                    </tr>";
        endforeach;
        $query->close();
    }
}

/**
 * Insert a new Question to the Survey
 * @param $question
 * @param $titleShort
 * @author Leonie Rauch
 */
function insertQuestion($question, $titleShort)
{
    $query = getDbConnection()->prepare("INSERT INTO survey_site.question (question, title_short) VALUES (?,?)");
    $titleShort=htmlspecialchars($titleShort);
    $question=htmlspecialchars($question);
    $query->bind_param("ss", $question, $titleShort);
    if ($query->execute()) {
        publishInfoNotification("Die Frage (" . $question . ") wurde hinzugefügt!");
    } else {
        publishErrorNotification("Einfügen der Frage (" . $question . ") gescheitert!");
    }
    $query->close();
}

/**
 *delete a single question
 * @param $id
 * @author Leonie Rauch
 */
function deleteQuestion($id)
{
    $sql = "DELETE FROM survey_site.question where id = ?;";
    $query = getDbConnection()->prepare($sql);
    $id=htmlspecialchars($id);
    $query->bind_param('i', $id);
    if (!$query->execute()) {
        publishErrorNotification("Löschen der Frage" . $id . " ist gescheitert!");
    } else {
        publishInfoNotification("Die Frage " . $id . " wurde gelöscht!");
    }
    $query->close();
}

?>
