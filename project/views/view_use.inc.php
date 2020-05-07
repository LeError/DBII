<?php
/**
 * @author Leonie Rauch
 */

$title = getSurveyTitle($_SESSION["titleShort"]);
$valueComment = getComment($_SESSION["titleShort"], $_SESSION[SESSION_USER]);

$query = getDbConnection()->prepare(
    "SELECT id, question  FROM survey_site.question WHERE title_short = ?;");
$query->bind_param('s', $_SESSION["titleShort"]);
$query->execute();
$result = $query->get_result();
$arrQuestions = array();
while ($row = $result->fetch_assoc()) {
    $arrQuestions[] = array($row["id"], $row["question"]);
}

$keys = array_keys($arrQuestions);
$_SESSION["q"]= $keys[0];
$r= $keys[count($keys)-1];
$anzahlFragen =count($keys);

if (isset($_POST["next"])){
    $_SESSION["q"]++;
}
?>
    <h3 class="ui dividing header">Beantwortung des Fragebogens <?php echo $title; ?>
                        mit insgesamt <?php echo $anzahlFragen ?> Fragen </h3>
                    <h5 class="ui header"> Es können Werte von 1 (gut) bis 5 (schlecht) vergeben
                            werden!</h5>

                            <form method="post" action="">
                                <?php
                                if ($_SESSION["q"] < $r) {
                                    echo var_export($arrQuestions[$_SESSION["q"]][0]);
                                    echo var_export($arrQuestions[$_SESSION["q"]][1]);}
                                    echo '<input type="submit" name="next" value="Nächste Frage">';
                                echo"</form>";





