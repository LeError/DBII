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
            "SELECT q.question FROM survey_site.survey s, survey_site.question q
                WHERE q.title_short = s.title_short 
                AND q.title_short = ?"
        );
        $query->bind_param('s', $this->title_short);
        $query->execute();
        $questions = $query->get_result();

        foreach ($questions as $question){
            $query = getDbConnection()->prepare(
                "SELECT a.value FROM survey_site.survey s, survey_site.question q, survey_site.answer a, survey_user su, survey_user_group sug
                WHERE q.id = a.id 
                AND q.title_short = s.title_short                
                AND a.matricule_number = su.matricule_number
                AND sug.course_short = su.course_short
                AND s.title_short = ?
                AND sug.course_short = ?                 
                AND q.question = ?
                "
            );
            $query->bind_param('sss', $this->title_short, $this->course_short, $question);
            $query->execute();
            $values = $query->get_result();

            $row = 0;
            $results=array();
            $results[$row][0] = $question;
            $results[$row][1] = (array_sum($values))/count($values);
            $results[$row][2] = min($values);
            $results[$row][3] = max($values);
            $results[$row][4] = calculateStandardDeviation($values, $results[$row][1]);
        }
        $this->results = $results;
    }

    public static function calculateStandardDeviation($values, $avg){
        $sum = 0;
        foreach ($values as $value){
            $sum+=pow(($value - $avg), 2);
        }
        return sqrt($sum/count($values));
    }

    public function getCalculatedValuesQuestion($question){
        for ($i=0; i<$this->results.length; $i++){
            if(strcmp($this->results[$i][0], $question) == 0){
                $row = array($this->results[$i]);
                return $row;
            }
        }
    }
    public function getAllComments(){
        $query = getDbConnection()->prepare(
            "SELECT ac.comment FROM survey_site.survey s, survey_site.assigned_comment ac, survey_user_group sug
                WHERE ac.title_short = s.title_short
                AND s.title_short = sug.title_short               
                AND s.title_short = ?
                AND sug.course_short = ?                 
                "
        );
        $query->bind_param('ss', $this->title_short, $this->course_short);
        $query->execute();
        $comments = $query->get_result();

        $commentsWithSpace="";
        foreach ($comments as $comment){
            $commentsWithSpace+=$comment+" ";
        }
        return $commentsWithSpace;
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