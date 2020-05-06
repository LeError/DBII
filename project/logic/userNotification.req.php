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

    /**
     * Triggers displaying of all found notifications
     * @author Robin Herder
     */
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

    /**
     * Prints given notifications on the given level
     * @author Robin Herder
     * @param $lvl notification level
     * @param $entries notification level entries
     */
    function echoNotificationEntries($lvl, $entries) {
        $entries = array_unique($entries);
        echo '
            <div class="ui '.$lvl.' message"><div class="header">';
        switch ($lvl) {
            case MSG_LVL_ERROR:
                $msg = 'Es sind Probleme aufgetreten:';
                break;
            case MSG_LVL_WARNING:
                $msg = 'Eine Warnung wurde empfangen:';
                break;
            default: $msg = 'Es wurden Benachrichtigungen empfangen:';
        }
        echo $msg.'</div><ul class="list">';
        foreach ($entries as $entry) {
            echo '<li>' . $entry . '</li>';
        }
        unset($entry);
        echo '</ul></div>';
    }

    /**
     * Raises a Error Notification
     * @author RObin Herder
     * @param $msg Error to publish
     */
    function publishErrorNotification($msg) {
        if(isset($_SESSION[MSG_LVL_ERROR]) && is_array($_SESSION[MSG_LVL_ERROR])) {
            array_push($_SESSION[MSG_LVL_ERROR], $msg);
        } else {
            $_SESSION[MSG_LVL_ERROR] = array();
            publishErrorNotification($msg);
        }
    }

    /**
     * Raises a Warning Notification
     * @author RObin Herder
     * @param $msg Warning to publish
     */
    function publishWarningNotification($msg) {
        if(isset($_SESSION[MSG_LVL_WARNING]) && is_array($_SESSION[MSG_LVL_WARNING])) {
            array_push($_SESSION[MSG_LVL_WARNING], $msg);
        } else {
            $_SESSION[MSG_LVL_WARNING] = array();
            publishWarningNotification($msg);
        }
    }

    /**
     * Raises a Info Notification
     * @author RObin Herder
     * @param $msg Info to publish
     */
    function publishInfoNotification($msg) {
        if(isset($_SESSION[MSG_LVL_INFO]) && is_array($_SESSION[MSG_LVL_INFO])) {
            array_push($_SESSION[MSG_LVL_INFO], $msg);
        } else {
            $_SESSION[MSG_LVL_INFO] = array();
            publishInfoNotification($msg);
        }
    }

    /**
     * Returns Notifications for suiting level
     * @author Robin Herder
     * @param $level notification level
     * @return array|mixed notifications or empty array
     */
    function getNotifications($level) {
        if(isset($_SESSION[$level])) {
            return $_SESSION[$level];
        } else {
            return Array();
        }
    }

    /**
     * Checks if new Notification was raised
     * @author Robin Herder
     * @param $notificationsArray current notifications array
     * @param $newNotifications newly raised notification array
     * @return bool state if new notification was raised
     */
    function checkIfNotificationAlreadyExists($notificationsArray, $newNotifications) {
        $size = count(array_unique($notificationsArray));
        $notificationsArray = array_merge($notificationsArray, $newNotifications);
        $notificationsArray = array_unique($notificationsArray);
        if($size < count($notificationsArray)) {
            return true;
        }
        return false;
    }