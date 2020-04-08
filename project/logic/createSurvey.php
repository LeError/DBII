
<?php
/**
 * createSurvey.php
 *
 * createQuestionsHTML, send data to database
 *
 * @author     Moritz Bürkle
 */
if(isset($_POST['submit'])){
    createQuestionsHTML();
}

function createQuestionsHTML(){
    $x = $_POST['numberOfQuestions'];
    for($y = 0; $y = $x; $y++){
        echo '<input type="text" value="' . $x . '" />'."\n";
    }

}


?>