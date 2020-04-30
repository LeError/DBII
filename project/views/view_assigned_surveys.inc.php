<?php

    /**
     * view_assigned_surveys.inc.php
     * @author Malik Press
     */

    //Prevent user form accessing file directly
    if(defined('REQ')) {
        securityCheck(ROLE_ADMIN);
    } else {
        require_once('../logic/security.req.php');
        checkDocument();
    }

    if(isset($_POST['survey'])) {
        header('location: index.php?view_use');
    }
?>
<div class="ui grid">
    <div class="sixteen wide column">
        <div class="ui raised segment">
            <a class="ui red ribbon label">Overview</a>
            <form class="ui form" method="post" style="margin-top: 15px">
                <div class="ui grid">
                    <div class="row">
                        <div class="column"><h3 class="ui dividing header">My surveys</h3></div>
                    </div>
                    <?php
                    $data = getAssignedSurveys($_SESSION[SESSION_USER]);
                    for ($i = 0; $i < count($data);$i++) {
                        echo '
                <div class="row">
                    <div class="sixteen wide column">
                        <button class="ui fluid button" name="survey" type="submit" value="' . $data[$i] . '">' . $data[$i] . '</button>
                    </div>
                </div>';
                    };
                    ?>
                </div>
            </form>
        </div>
    </div>
</div>

