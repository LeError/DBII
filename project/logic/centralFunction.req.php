<?php

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
        $query->bind_param('ss', $title_short, $matricule_number);
        $query->execute();
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
        $query->bind_param('sss', $title_short, $matricule_number, $comment);
        $query->execute();
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

        $query = getDbConnection()->prepare(
            "INSERT INTO survey_site.survey (title_short, title, username) 
            VALUES (?, ?, ?);"
        );
        $query->bind_param('sss', $title_short, $title, $username);
        $query->execute();

        foreach ($questions as $question) {
            $query = getDbConnection()->prepare(
                "INSERT INTO survey_site.question (question, title_short) 
            VALUES (?, ?);"
            );
            $query->bind_param('ss',$question, $title_short);
            $query->execute();
            $query->close();
        }

    }


    /**
    * Procedure to enter the points awarded for a matriculation number.
    * @author Leonie Rauch
    * @param $matricule_number
    * @param $id
    * @param $value
    */
    function saveScoringSystem($id,$matricule_number, $value){
       $test = getDbConnection()->prepare(
            "SELECT * FROM survey_site.answer a WHERE a.id = ? AND a.matricule_number = ?;");
        $test->bind_param('is', $id, $matricule_number);
        $test->execute();
        $rows = mysqli_num_rows($test->get_result());
        if($rows > 0) {
            $query = getDbConnection()->prepare(
                "UPDATE survey_site.answer SET value = ? WHERE id = ? AND matricule_number = ?");
            $query->bind_param('iis', $value, $id, $matricule_number);
            $query->execute();
            $query->close();
        } else {
            $stmt = getDbConnection()->prepare(
                "INSERT INTO survey_site.answer(id, matricule_number, value) VALUES (?, ?, ?);");
            $stmt->bind_param('isi', $id, $matricule_number, $value);
            $stmt->execute();
            $stmt->close();
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
            "INSERT INTO survey_site.assigned_status($title_short,$matricule_number)VALUES (?, ?); ");
        $query->bind_param('ss', $title_short, $matricule_number);
        $query->execute();
        $query->close();
    }
?>