<?php

/**
 * @param $title
 * @author Leonie Rauch
 */

function showQuestions($title)
{
    $sql = "SELECT id, question  FROM survey_site.survey s, survey_site.question q where s.title_short = q.title_short AND s.title = ?;";
    if ($query = getDbConnection()->prepare($sql)) {
        $query->bind_param('s', $title);
        $query->execute();
        $query->bind_result($id, $question);
        $result = $query->get_result();

        $e = function ($value) {
            return htmlspecialchars($value, ENT_COMPAT, 'UTF-8');
        };
        ?>
        <table width="50%" border="0" cellspacing="10px">
            <form action="" method="post">
                <tr>
                    <th>Id</th>
                    <th>Frage</th>
                </tr>
        <?php
        foreach ($result as $row):
            $id = $e($row['id']);
            $question = $e($row['question']);

            echo "<tr> 
                   <td> $id </td> 
                   <td> $question </td>
                   <td> <button class=\"ui button\" name=\"edit\" type=\"submit\" value = $id style=\"width: 7vw;\"><i class=\"edit icon\"></i></button> </td>
                    <td> <button class=\"ui button\" name=\"delete\" type=\"submit\" value= $id style=\"width: 7vw;\"><i class=\"trash icon\"></i></button></td>
                    </tr>";
        endforeach;
        echo "</tform>";
        echo "</table>";
    }
}

/**
 * @param $question
 * @param $titleShort
 * @author Leonie Rauch
 */
function insertQuestion($question, $titleShort)
{
    $query = getDbConnection()->prepare("INSERT INTO survey_site.question (question, title_short) VALUES (?,?)");
    $query->bind_param("ss", $question, $titleShort);
    if (!$query->execute()) {
        publishErrorNotification("Einfügen der Frage (" . $question . ") gescheitert!");
    } else {
        publishInfoNotification("Die Frage (" . $question . ") wurde hinzugefügt!");
    }
    $query->close();
}

/**
 * @param $id
 * @author Leonie Rauch
 */
function deleteQuestion($id)
{
    $sql = "DELETE FROM survey_site.question where id = ?;";
    $query = getDbConnection()->prepare($sql);
    $query->bind_param('s', $id);
    if (!$query->execute()) {
        publishErrorNotification("Löschen der Frage" . $id . " ist gescheitert!");
    } else {
        publishInfoNotification("Die Frage " . $id . " wurde gelöscht!");
    }
}


