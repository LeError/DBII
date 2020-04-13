<?php
/**
 * evaluation.php
 *
 * Evaluation class according to task description
 *
 * @author     Moritz Bürkle
 */

class evaluation
{
    public $title_short;
    public $course_short;
    public $results;

    public function __construct($title_short,$course_short){
        $this->title_short = $title_short;
        $this->course_short = $course_short;
    }

    public function createResultsArray(){

        $query = getDbConnection()->prepare(
            "SELECT q.question, a.value FROM survey_site.answer a, question q, survey_user su, survey_user_group sug, survey s, assigned_status ass
                WHERE q.id = a.id 
                AND a.matricule_number = su.matricule_number
                AND ass.matricule_number = su.matricule_number
                AND su.course_short = ?
                AND ass.title_short = ?"

        );
        $query->bind_param('s', $assignedSurveyName);
        $query->execute();
        return $query->get_result();

    }




    /**
     * @return mixed
     */
    public function getTitleShort()
    {
        return $this->title_short;
    }
    /**
     * @param mixed $title_short
     */
    public function setTitleShort($title_short)
    {
        $this->title_short = $title_short;
    }
    /**
     * @return mixed
     */
    public function getCourseShort()
    {
        return $this->course_short;
    }
    /**
     * @param mixed $course_short
     */
    public function setCourseShort($course_short)
    {
        $this->course_short = $course_short;
    }
}