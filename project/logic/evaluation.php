<?php
/**
 * evaluation.php
 *
 * Evaluation class according to task description
 *
 * @author     Moritz Bürkle
 */

//Prevent user form accessing file directly
require_once('security.req.php');
checkDocument();

class evaluation
{
    private $title_short;
    private $course_short;
    private $results;
    private $comments;

    public function __construct($title_short,$course_short){
        $this->title_short = $title_short;
        $this->course_short = $course_short;
    }

    public function createResultsArray(){

        $query = getDbConnection()->prepare(
            "SELECT q.question FROM survey_site.question q
                WHERE q.title_short = ?  "
        );
        $query->bind_param('s', $this->title_short);
        $query->execute();
        //$questions = $query->get_result();
        $query->bind_result($question);
        $questions= array();
        while($query->fetch()){
            $questions[] = $question;
        }
        $row = 0;
        $results=array();
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
            $query->bind_result($value);
            $values= array();
            while($query->fetch()){
                $values[] = $value;
            }
            if(count($values)!=0) {
                $results[$row] = array();
                $results[$row][0] = $question;
                $results[$row][1] = (array_sum($values)) / count($values);
                $results[$row][2] = min($values);
                $results[$row][3] = max($values);
                $results[$row][4] = self::calculateStandardDeviation($values, $results[$row][1]);
                $row++;
            }else{
                publishErrorNotification("There happend something wrong. Seems like there aren't any result values for a question");
            }
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

    public function getCalculatedValuesForQuestion($question){
        if(count($this->results) == 0){
            self::createResultsArray();
        }
        for ($i=0; $i<count($this->results); $i++){
            if(strcmp($this->results[$i][0], $question) == 0){
                $row = $this->results[$i];
                return $row;
            }
        }
    }

    public function getCommentsWithSpace(){
        $query = getDbConnection()->prepare(
            "SELECT ac.comment FROM survey_site.assigned_comment ac, survey_site.survey_user_group sug, survey_site.survey_user su
                WHERE ac.matricule_number = su.matricule_number
                AND su.course_short = sug.course_short               
                AND ac.title_short = ?
                AND sug.course_short = ?                 
                "
        );
        $query->bind_param('ss', $this->title_short, $this->course_short);
        $query->execute();
        $query->bind_result($comment);
        $comments= array();
        while($query->fetch()){
            $comments[] = $comment;
        }
        $commentsWithSpace="";
        foreach ($comments as $comment){
            $commentsWithSpace= $commentsWithSpace.$comment.' ';
        }
        return $commentsWithSpace;
    }
    public function createCommentsInArray(){
        $query = getDbConnection()->prepare(
            "SELECT ac.comment FROM survey_site.assigned_comment ac, survey_site.survey_user_group sug, survey_site.survey_user su
                WHERE ac.matricule_number = su.matricule_number
                AND su.course_short = sug.course_short               
                AND ac.title_short = ?
                AND sug.course_short = ?                 
                "
        );
        $query->bind_param('ss', $this->title_short, $this->course_short);
        $query->execute();

        $query->bind_result($comment);
        $comments= array();
        while($query->fetch()){
            $comments[] = $comment;
        }
        $this->comments = $comments;
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

    /**
     * @return mixed
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * @param mixed $results
     */
    public function setResults($results)
    {
        $this->results = $results;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
    }

}