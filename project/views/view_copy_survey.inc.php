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
                <td><input maxlength="10" name="title_short" type="text" value= <?php $tit=(isset($_POST['title_short'])    ? $_POST['title_short']    : '');  print ($tit) ?> ></td>
            </tr>
            <tr>
                <td> Name neuer Fragebogen:</td>
                <td><input maxlength="100" name="title" type="text" value= <?php $t=(isset($_POST['title'])    ? $_POST['title']    : '');  print ($t) ?> ></td>
            </tr>
            <tr>
                <td align="left" colspan="2"><input type="submit" value="Copy Survey" name="copySurvey"></td>
            </tr>
        </table>
    </form>

</div>

<?php
if(isset($_POST["copySurvey"])){
    if ((($_POST['title_short']) == ""&& ($_POST['title']) == "")||(($_POST['title_short']) == ""&& ($_POST['title']) <> "")||
        (($_POST['title_short']) <> ""&& ($_POST['title']) == "")) {
        publishWarningNotification("Bitte alle Felder befüllen!");
    }else{
        copySurvey($_POST["title_short"], $_POST["title"], $_SESSION[SESSION_USER], $oldSurvey);
        }

}
?>
