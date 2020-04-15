<?php

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
?>