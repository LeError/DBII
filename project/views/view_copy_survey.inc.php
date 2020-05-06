<?php

/**
 * view for set title and shorttitle to copy the selected survey
 * @author Leonie Rauch
 */

//Prevent user form accessing file directly
if(defined('REQ')) {
    securityCheck(ROLE_ADMIN);
} else {
    require_once('../logic/security.req.php');
    checkDocument();
}


require('./logic/copySurvey.req.php');
?>

<div class="ui one column grid center aligned" style="margin-top: 30px">
    <div class="column">
        <div class="ui raised segment left aligned">
            <div class="column"><h3 class="ui dividing header">Kopieren des
                    Fragebogens <?php echo $_SESSION["titleShortOld"] ?></h3></div>

            <form action="" method="post" class="ui large form" style="margin: 25px 10px 10px;">
                <div class="field">
                    <div class="ui labeled input">
                        <div class="ui label">
                            K&uuml;rzel neuer Fragebogen
                        </div>
                        <input maxlength="10" name="title_short" type="text"
                               value= <?php $tit = (isset($_POST['title_short']) ? $_POST['title_short'] : '');
                        print ($tit) ?>>
                    </div>
                </div>
                <div class="field">
                    <div class="ui labeled input">
                        <div class="ui label">
                            Name neuer Fragebogen
                        </div>
                        <input maxlength="100" name="title" type="text"
                               value= <?php $t = (isset($_POST['title']) ? $_POST['title'] : '');
                        print ($t) ?>>
                    </div>
                </div>
                <button class="ui fluid large teal button submit" name="copySurvey" type="submit">Fragebogen kopieren
                </button>
            </form>

        </div>
    </div>
</div>
</div>

<?php
if (isset($_POST["copySurvey"])) {
    if ((($_POST['title_short']) == "" && ($_POST['title']) == "") || (($_POST['title_short']) == "" && ($_POST['title']) <> "") ||
        (($_POST['title_short']) <> "" && ($_POST['title']) == "")) {
        publishWarningNotification( "Bitte alle Felder befüllen!");
    } else {
        copySurvey($_POST["title_short"], $_POST["title"], $_SESSION[SESSION_USER], $_SESSION["titleShortOld"]);
    }

}
?>


