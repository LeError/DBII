<?php

/**
 * @author Leonie Rauch
 */

$oldSurvey = "test0";
require ('./logic/copySurvey.req.php');
?>


<div class="ui container center aligned">
    <form method="post" action="">
        <table width="50%" border="0"  cellspacing="10px">
            <tr>
                <th align="left" colspan="2">Copy survey <?php echo $oldSurvey?> </th>
            </tr>

            <tr>
                <td>Kürzel neuer Fragebogen:</td>
                <td><input maxlength="10" name="title_short" type="text" /></td>
            </tr>
            <tr>
                <td> Name neuer Fragebogen:</td>
                <td><input maxlength="100" name="title" type="text" /></td>
            </tr>
            <tr>
                <td align="left" colspan="2"><input type="submit" value="Copy Survey" name="copySurvey"></td>
            </tr>
        </table>
    </form>

</div>

<?php
if(isset($_POST["copySurvey"])){
$error=false;
    if ((($_POST['title_short']) == ""&& ($_POST['title']) == "")||(($_POST['title_short']) == ""&& ($_POST['title']) <> "")||
    (($_POST['title_short']) <> ""&& ($_POST['title']) == ""))
    {echo "Bitte alle Felder befüllen!";
    }else{
        copySurvey($_POST["title_short"], $_POST["title"], "Leonie" );
        if ($error==true){
            echo "Es ist ein Fehler aufgetreten!";
        }else{
            copyQuestion($oldSurvey, $_POST["title_short"]);
            if ($error == true){
                echo "Es ist ein Fehler aufgetreten!";
            }else{
                echo "Der kopierte Fragebogen wurde erfolgreich gespeichert!";
            }
        }
  }

}
?>