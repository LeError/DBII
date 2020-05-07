<?php

    //Prevent user form accessing file directly
    require_once('security.req.php');
    checkDocument();

    /**
     * Checks if a user is assigned to a survey / is allowed to access
     * @author Robin Herder
     * @param $matricule_number identifier of student
     * @param $title_short identifier of survey
     * @return bool
     */
    function isUserAssigned($matricule_number, $title_short) {
        $query = getDbConnection()->prepare(
            "SELECT * FROM survey_site.survey_user u, survey_site.survey_user_group g, survey_site.assigned a
            WHERE u.course_short = g.course_short
            AND g.course_short = a.course_short
            AND a.title_short = ?
            AND u.matricule_number = ?;"
        );
        $title_short = htmlspecialchars($title_short);
        $matricule_number = htmlspecialchars($title_short);
        $query->bind_param('ss', $title_short, $matricule_number);
        if(!$query->execute()) {
            publishErrorNotification('Ein unerwarteter Fehler ist aufgetreten!');
            return false;
        }
        $rows = mysqli_num_rows($query->get_result());
        $query->close();
        if($rows > 0) {
            return true;
        }
        return false;
    }

    /**
     * Persists a comment of a user given on a survey
     * @author Robin Herder
     * @param $matricule_number identifier of student
     * @param $title_short identifier of survey
     * @param $comment comment text
     */
    function insertSurveyComment($matricule_number, $title_short, $comment) {
        $query = getDbConnection()->prepare(
            "INSERT INTO survey_site.assigned_comment (title_short, matricule_number, comment) 
            VALUES (?, ?, ?);"
        );
        $title_short = htmlspecialchars($title_short);
        $matricule_number = htmlspecialchars($matricule_number);
        $comment = htmlspecialchars($comment);
        $query->bind_param('sss', $title_short, $matricule_number, $comment);
        if($query->execute()) {
            publishInfoNotification('Kommentar wurde gespeichert');
        } else {
            publishErrorNotification('Kommentar konnte nicht gespeichert werden');
        }
        $query->close();
    }


    /**
    * Insert survey and questions
    * @author Moritz Bürkle
    * @param $username
    * @param $title
    * @param $title_short
    * @param $questions (Array)
    */
    function insertSurvey($username, $title, $title_short, $questions){

        if ($title == '' OR $title_short == ''){
            publishErrorNotification('Title short or title is empty.');
            return;
        }
        if(ctype_space($title) OR ctype_space($title)){
            publishErrorNotification('Your short title or your title is whitespace only!!');
            return;
        }
        if (strpos($title, ' ') !== false OR strpos($title_short, ' ') !== false) {
            publishErrorNotification('There are no whitespaces allowed in title and title short!');
            return;
        }
        foreach($questions as $question){
            if($question == '' OR ctype_space($question)){
                publishErrorNotification('Your question is empty or contains whitespace only.');
                return;
            }
        }
        $query = getDbConnection()->prepare(
            "INSERT INTO survey_site.survey (title_short, title, username) 
            VALUES (?, ?, ?);"
        );
        $title_short = htmlspecialchars($title_short);
        $title = htmlspecialchars($title);
        $username = htmlspecialchars($username);
        $query->bind_param('sss', $title_short, $title, $username);
        if (!$query->execute()) {
            publishErrorNotification("Failed to create survey!");
            return;
        }

        foreach ($questions as $question) {
            $query = getDbConnection()->prepare(
                "INSERT INTO survey_site.question (question, title_short) 
            VALUES (?, ?);"
            );
            $question = htmlspecialchars($question);
            $query->bind_param('ss',$question, $title_short);
            if (!$query->execute()) {
                publishErrorNotification("Survey creation failed. Failed to create Question:".$question);
                $query = getDbConnection()->prepare(
                    "DELETE FROM survey_site.survey where title_short =?"); //Question delete not needed cause of cascade table def
                $query->bind_param('s', $title_short);
                $query->execute();
                return;
            }
            $query->close();
        }
        publishInfoNotification("Survey successful created!");
    }


    /**
    * Procedure to enter the points awarded for a matriculation number.
    * @author Leonie Rauch
    * @param $matricule_number
    * @param $id
    * @param $value
    */
    function saveScoringSystem($id,$matricule_number, $value){
       $query = getDbConnection()->prepare(
            "SELECT * FROM survey_site.answer a WHERE a.id = ? AND a.matricule_number = ?;");
        $id=htmlspecialchars($id);
        $matricule_number=htmlspecialchars($matricule_number);
       $query->bind_param('is', $id, $matricule_number);
        $query->execute();
        $rows = mysqli_num_rows($query->get_result());
        if($rows > 0) {
            $query = getDbConnection()->prepare(
                "UPDATE survey_site.answer SET value = ? WHERE id = ? AND matricule_number = ?");
            $id=htmlspecialchars($id);
            $matricule_number=htmlspecialchars($matricule_number);
            $value=htmlspecialchars($value);
            $query->bind_param('iis', $value, $id, $matricule_number);
            if ($query->execute()){
              //  publishInfoNotification("Ihre Bewertung wurde angepasst!");
            }else{
               // publishErrorNotification("Ihre Bewertung konnte nicht angepasst werden!");
            }
            $query->close();
        } else {
            $query = getDbConnection()->prepare(
                "INSERT INTO survey_site.answer(id, matricule_number, value) VALUES (?, ?, ?);");
            $id=htmlspecialchars($id);
            $matricule_number=htmlspecialchars($matricule_number);
            $value=htmlspecialchars($value);
            $query->bind_param('isi', $id, $matricule_number, $value);
            if ($query->execute()){
                publishInfoNotification("Die Bewertung wurde gespeichert!");
            }else{
                publishErrorNotification("Die Bewertung konnte nicht gespeichert werden!");
            };
            $query->close();
        }
    }

    /**
     * Set status of assigned survey on given matricule number and short title of a survey
     * @author Malik Press
     * @param $matricule_number identifier of student
     * @param $title_short identifier of survey
     */
    function setAssignedStatus($matricule_number, $title_short) {
        $query = getDbConnection() -> prepare(
            "INSERT INTO survey_site.assigned_status(title_short, matricule_number)VALUES (?, ?); ");
        $title_short = htmlspecialchars($title_short);
        $matricule_number = htmlspecialchars($matricule_number);
        $query->bind_param('ss', $title_short, $matricule_number);
        if ($query->execute()){
            publishInfoNotification("Der Fragebogen wurde abgeschickt!");
        }else{
            publishErrorNotification("Der Fragebogen konnte nicht abgeschickt werden!");
        };
        $query->close();
    }

    /**
     * Get assigned surveys of user
     * DISTINCT not needed! Somehow doubled survey title entries in database -> set title to unique in table definition
     * @author Moritz Bürkle
     * @param $username
     */
    function getSurveys($username) {
        $query = getDbConnection()->prepare(
            "SELECT s.title FROM survey_site.survey s, survey_site.assigned a
                   WHERE s.title_short = a.title_short
                   AND s.username = ?"
        );
        $username = htmlspecialchars($username);
        $query->bind_param('s', $username);
        $query->execute();
        $results = $query->get_result();

        if(mysqli_num_rows($results) == 0){

            $query = getDbConnection()->prepare(
                "SELECT distinct s.username,'You have not assigned a survey yet.' AS title FROM survey_site.assigned a, survey_site.survey s 
                        WHERE s.title_short NOT IN (SELECT title_short FROM survey_site.assigned)
                        AND s.username = ?"
            );
            $query->bind_param('s', $username);
            $query->execute();
            $results = $query->get_result();
            if(mysqli_num_rows($results) == 0){

                $query = getDbConnection()->prepare(
                    "SELECT distinct u.username,'You have not created a survey with this user!' AS title FROM survey_site.user u, survey_site.survey s 
                            WHERE u.username NOT IN (SELECT username FROM survey_site.survey)
                            AND u.username = ?"
                );
                $query->bind_param('s', $username);
                $query->execute();
                $results = $query->get_result();
                return $results;
            }
            return $results;
        }
        return $results;
    }

    /**
     * Get course_short on given matricule number
     * @author Malik Press
     * @param $matriculeNumber
     * @return String
     */
    function getCourseShort($matriculeNumber) {
        $query = getDbConnection()->prepare("SELECT course_short FROM survey_site.survey_user WHERE matricule_number = ?");
        $matriculeNumber = htmlspecialchars($matriculeNumber);
        $query->bind_param('s',$matriculeNumber);
        $query->execute();
        $result = $query->get_result();
        $course_short = $result->fetch_assoc()['course_short'];
        $query->close();
        return $course_short;
    }

    /**
     * Get assigned surveys of a course
     * @author Malik Press
     * @param $course_short
     * @return array
     */
    function getAssignedSurveys($course_short) {
        $query = getDbConnection()->prepare(
            "SELECT title_short FROM survey_site.assigned
               WHERE course_short = ?"
        );
        $course_short = htmlspecialchars($course_short);
        $query->bind_param('s', $course_short);
        $query->execute();
        $query->bind_result($title_short);
        $result = array();
        while ($query->fetch()) {
            $result[] = $title_short;
        };
        $query->close();
        return $result;
    }


    /**
     * Get finished surveys (title_short) of a user on given matricule_number
     * @author Malik Press
     * @param $matricule_number
     * @return array
     */
    function getFinishedSurveys($matricule_number) {
        $query = getDbConnection()->prepare("SELECT title_short FROM survey_site.assigned_status WHERE matricule_number = ?");
        $matricule_number = htmlspecialchars($matricule_number);
        $query->bind_param('s', $matricule_number);
        $query->execute();
        $query->bind_result($title_short);
        $result = array();
        while ($query->fetch()) {
            $result[] = $title_short;
        }
        $query->close();
        return $result;
    }

    /**
     * Get survey title on given title_short
     * @author Malik Press
     * @param $title_short
     * @return array
     */
    function getSurveyTitle($title_short) {
        $query = getDbConnection()->prepare("SELECT title FROM  survey_site.survey WHERE title_short = ?");
        $title_short = htmlspecialchars($title_short);
        $query->bind_param('s', $title_short);
        $query->execute();
        $result = $query->get_result();
        $survey_title = $result->fetch_assoc()['title'];
        $query->close();
        return $survey_title;
    }

    /**
     * Get assigned survey course depending on assigned survey name
     * only used if assignedSurveyName is already proofen assigned
     * @author Moritz Bürkle
     * @param $assignedSurveyName
     */
    function getAssignedSurveyCourses($assignedSurveyName){


        $query = getDbConnection()->prepare(
            "SELECT a.course_short FROM survey_site.assigned a
                WHERE a.title_short = 
                (SELECT s.title_short FROM survey_site.survey s 
                WHERE s.title = ?)"
        );
        $assignedSurveyName = htmlspecialchars($assignedSurveyName);
        $query->bind_param('s', $assignedSurveyName);
        $query->execute();
        return $query->get_result();
    }

    /**
     * Get title_short for title
     * @author Moritz Bürkle
     * @param $title
     */
    function getTitleShort($title){
        $query = getDbConnection()->prepare(
            "SELECT s.title_short FROM survey_site.survey s
                WHERE s.title = ? "
        );
        $title = htmlspecialchars($title);
        $query->bind_param('s', $title);
        $query->execute();
        $result = $query->get_result();
        return $result->fetch_assoc()['title_short'];
    }

/**
 * Get answer value for id and mnr
 * @param $id
 * @param $mnr
 * @return mixed
 * @author Leonie Rauch
 */
function getAnswerValue($id, $mnr){
    $query = getDbConnection()->prepare(
        "SELECT value FROM survey_site.answer WHERE id = ? AND matricule_number=?;");
    $id=htmlspecialchars($id);
    $mnr=htmlspecialchars($mnr);
    $query->bind_param('is', $id, $mnr);
    $query->execute();
    $res = $query->get_result();
    $row = $res->fetch_assoc();
    return $row["value"];}


/**
 * get Survey Comment for title_Short and mnr
 * @param $titleShort
 * @param $mnr
 * @return mixed
 * @author Leonie Rauch
 */
function getComment($titleShort, $mnr){
    $query = getDbConnection()->prepare(
        "SELECT comment FROM survey_site.assigned_comment WHERE title_short = ? AND matricule_number=?;");
    $query->bind_param('ss', $titleShort, $mnr);
    $query->execute();
    $res = $query->get_result();
    $row = $res->fetch_assoc();
    return $row["comment"];
}

/**
 * test if all Questions are answered then call function set Assigned Status
 * @param $titleShort
 * @param $user
 *
 */
function testAllQuestionsAreAnswered($titleShort, $user){
    $query = getDbConnection()-> prepare(
        "SELECT q.question from survey_site.question q where q.title_short=? and q.id not in (select a.id from survey_site.answer a)");
    $titleShort=htmlspecialchars($titleShort);
    $query->bind_param('s', $titleShort);
    $query->execute();
    $rows = mysqli_num_rows($query->get_result());
    if($rows > 0) {
        publishErrorNotification("Bitte alle Fragen beantworten, damit der Fragebogen abgesendet werden kann");
    }else{
        setAssignedStatus($user, $titleShort);
        echo '<script type="application/javascript">
         window.location.replace("index.php");
      </script>';
    }}

?>