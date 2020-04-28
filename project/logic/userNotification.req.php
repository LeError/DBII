<?php
    /**
     * userNotification.req.php
     *
     * Holds logic for error Handling and user Notifications
     *
     * @author     Robin Herder
     */

    //Prevent user form accessing file directly
    require_once('security.req.php');
    checkDocument();

    define('MSG_LVL_ERROR', 'error');
    define('MSG_LVL_WARNING', 'warning');
    define('MSG_LVL_INFO', 'info');

    function displayNotifications() {
        if(isset($_SESSION[MSG_LVL_ERROR]) && count($_SESSION[MSG_LVL_ERROR]) > 0){
            echoNotificationEntries(MSG_LVL_ERROR, $_SESSION[MSG_LVL_ERROR]);
            unset($_SESSION[MSG_LVL_ERROR]);
        }
        if(isset($_SESSION[MSG_LVL_WARNING]) && count($_SESSION[MSG_LVL_WARNING]) > 0){
            echoNotificationEntries(MSG_LVL_WARNING, $_SESSION[MSG_LVL_WARNING]);
            unset($_SESSION[MSG_LVL_WARNING]);
        }
        if(isset($_SESSION[MSG_LVL_INFO]) && count($_SESSION[MSG_LVL_INFO]) > 0){
            echoNotificationEntries(MSG_LVL_INFO, $_SESSION[MSG_LVL_INFO]);
            unset($_SESSION[MSG_LVL_INFO]);
        }
    }

    function echoNotificationEntries($lvl, $entries) {
        $entries = array_unique($entries);
        echo '
            <div class="ui '.$lvl.' message"><div class="header">';
        switch ($lvl) {
            case MSG_LVL_ERROR:
                $msg = 'Es sind Probleme aufgetreten:';
                break;
            case MSG_LVL_WARNING:
                $msg = 'Ein Warnung wurde empfangen:';
                break;
            default: $msg = 'Es wurden Benachichtigungen empfangen:';
        }
        echo $msg.'</div><ul class="list">';
        foreach ($entries as $entry) {
            echo '<li>' . $entry . '</li>';
        }
        unset($entry);
        echo '</ul></div>';
    }

    function publishErrorNotification($msg) {
        if(isset($_SESSION[MSG_LVL_ERROR]) && is_array($_SESSION[MSG_LVL_ERROR])) {
            array_push($_SESSION[MSG_LVL_ERROR], $msg);
        } else {
            $_SESSION[MSG_LVL_ERROR] = array();
            publishErrorNotification($msg);
        }
    }

    function publishWarningNotification($msg) {
        if(isset($_SESSION[MSG_LVL_WARNING]) && is_array($_SESSION[MSG_LVL_WARNING])) {
            array_push($_SESSION[MSG_LVL_WARNING], $msg);
        } else {
            $_SESSION[MSG_LVL_WARNING] = array();
            publishWarningNotification($msg);
        }
    }

    function publishInfoNotification($msg) {
        if(isset($_SESSION[MSG_LVL_INFO]) && is_array($_SESSION[MSG_LVL_INFO])) {
            array_push($_SESSION[MSG_LVL_INFO], $msg);
        } else {
            $_SESSION[MSG_LVL_INFO] = array();
            publishInfoNotification($msg);
        }
    }