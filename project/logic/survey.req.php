<?php

    //Prevent user form accessing file directly
    require_once('security.req.php');
    checkDocument();

    /**
     * Assign survey to user group on given survey short and course short
     * @author Malik Press
     * @param $title_short
     * @param $course_short
    */
    function assignSurveyToUserGroup($title_short,$course_short) {
        $query = getDbConnection()->prepare(
            "INSERT INTO survey_site.assigned($title_short,$course_short) VALUES (?,?);"
        );
        $query->bind_param("ss",§title_short, §course_short);
        $query->execute();
        $query->close();
    };

    /**
     * Un assign survey from user group on given survey short and course short
     * @author Malik Press
     * @param $title_short
     * @param $course_short
     */
    function unAssignSurveyFromUserGroup($title_short,$course_short) {
        $query = getDbConnection()->prepare(
            "DELETE from survey_site.assigned a where a.title_short = ? AND a.course_short = ?;"
        );
        $query->bind_param("ss",$title_short, $course_short);
        $query->execute();
        $query->close();
    }

/**
 * Get all survey records of a user
 * @author Malik Press
 * @param $username identifier of user
 * @return array
 */
    function getSurveyRecords($username) {
        $query = getDbConnection()->prepare(
            "SELECT title_short FROM survey_site.survey s WHERE s.username = ? "
        );
        $query->bind_param("s",$username);
        $query->execute();
        $query->bind_result($title_short);
        $result = array();
        while ($query->fetch()) {
            $result[] = $title_short;
        };
        $query->close();
        return $result;
    }
?>