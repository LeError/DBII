<?php
    /**
     * usermgm.req.php
     *
     * Stores the logic for the user management (user & survey user)
     *
     * @author     Robin Herder
     */

    define('SESSION_ROLE', 'role');
    define('SESSION_USER', 'user');
    define('ROLE_ADMIN', 'admin');
    define('ROLE_USER', 'survey_user');

    /**
     * Register function for users
     * @author Robin Herder
     * @param $user username that the user wants to register
     * @param $pass password that the user wants to register
     */
    function registerUser($user, $pass) {
        $query = getDbConnection()->prepare(
            "SELECT * FROM survey_site.user u 
            WHERE u.username = ?;
        ");
        $query->bind_param('s', $user);
        $query->execute();
        $result = $query->get_result();
        if($result->num_rows != 0) {
            publishErrorNotification('Registrierung Gescheitert! Nutzername Bereits vergeben!');
            return;
        }
        $query->close();
        unset($result);
        $hashedPass = password_hash($pass, PASSWORD_DEFAULT);
        $query = getDbConnection()->prepare(
            "INSERT INTO survey_site.user (username, password) 
            VALUES (?, ?);"
        );
        $query->bind_param("ss", $user, $hashedPass);
        if($query->execute()) {
            publishInfoNotification('Neuen Account "'.$user.'" erfolgreich Registriert!');
        } else {
            publishErrorNotification('Bei der Account Registrierung ist ein Fehler aufgetreten!');
        }
        $query->close();
    }

    /**
     * Login function for the normal users.
     * Performs password check and rehashes if needed
     * @author Robin Herder
     * @param $user username of the user who wants to log in
     * @param $pass password of the user who wants to log in
     */
    function loginUser($user, $pass) {
        $query = getDbConnection()->prepare(
            "SELECT u.password FROM survey_site.user u
            WHERE u.username = ?;"
        );
        $query->bind_param('s', $user);
        $query->execute();
        $result = $query->get_result();
        if($result->num_rows != 1) {
            session_unset();
            publishErrorNotification('Account '.$user.' wurde nicht gefunden!');
            return;
        }
        $hashedPass = $result->fetch_assoc()['password'];
        $query->close();
        if(password_verify($pass, $hashedPass)) {
            if(password_needs_rehash($hashedPass, PASSWORD_DEFAULT)) {
                $query = getDbConnection()->prepare(
                    "UPDATE survey_site.user u 
                    SET u.password = ?
                    WHERE u.username = ?;"
                );
                $query->bind_param('ss', $pass, $user);
                $query->execute();
                $query->close();
            }
            $_SESSION[SESSION_USER] = $user;
            $_SESSION[SESSION_ROLE] = ROLE_ADMIN;
        } else {
            session_unset();
            publishErrorNotification('Die Kombination aus User und Passwort ist Falsch!');
        }
    }

    /**
     * Function for registering a new course
     * @author Robin Herder
     * @param $course_short
     * @param $course
     */
    function registerCourse($course_short, $course) {
        $query = getDbConnection()->prepare(
            "INSERT INTO survey_user_group (course, course_short) 
            VALUES (?, ?);"
        );
        $query->bind_param('ss', $matricule_number, $username);
        $query->execute();
        $query->close();
    }

    /**
     * Function for generating the Course Entities in the Course View
     * @author Robin Herder
     */
    function displayCourses() {
        $query = getDbConnection()->prepare('
            SELECT * FROM survey_site.survey_user_group;
        ');
        if(!$query->execute()) {
            publishErrorNotification("Kurse konnten nicht geladen werden!");
            return;
        }
        $result = $query->get_result();
        for ($i = 0; $i < count($data);$i++) {
            echo '<div class="bd-survey-list-item" style="padding-bottom: 0.75vh;">
                <button class="ui button" name="action" type="submit" value="survey'. $i .'" style="width: 50vw;">' . $data[$i] . '</button>
                <button class="ui inverted secondary icon button" name="action" type="submit" value="edit'. $i .'"><i class="edit icon"></i></button>
                <button class="ui inverted red icon button" name="action" type="submit" value="delete'. $i .'"><i class="trash icon"></i></button>
            </div>';
        };
        $query->close();
    }

    /**
     * Function for registering a new SurveyUser
     * @author Robin Herder
     * @param $matricule_number
     * @param $username
     * @param $course_short
     */
    function registerSurveyUser($matricule_number, $username, $course_short) {
        $query = getDbConnection()->prepare(
            "INSERT INTO survey_user (matricule_number, username, course_short) 
            VALUES (?, ?, ?);"
        );
        $query->bind_param('sss', $matricule_number, $username, $course_short);
        $query->execute();
        $query->close();
    }

    /**
     * Login function for the survey_users
     * @author Robin Herder
     * @param $matricule_number identifier of the survey_user
     */
    function loginSurveyUser($matricule_number) {
        $query = getDbConnection()->prepare(
            "SELECT * FROM survey_site.survey_user u 
            WHERE matricule_number = ?;"
        );
        $query->bind_param('s', $matricule_number);
        $query->execute();
        $result = $query->get_result();
        if($result->num_rows == 1) {
            $_SESSION[SESSION_USER] = $matricule_number;
            $_SESSION[SESSION_ROLE] = ROLE_USER;
        } else {
            session_unset();
            publishErrorNotification("Kein Nutzer mit dieser Matricel Nummer wurde Gefunden!");
        }
        $query->close();
    }

    /**
     * Function to return name of survey_user
     * @param $matricule_number identifier of survey_user
     * @return username
     */
    function getSurveyUsername($matricule_number) {
        $query = getDbConnection()->prepare(
            "SELECT u.username FROM survey_user u 
            WHERE u.matricule_number = ?;"
        );
        $query->bind_param('s', $matricule_number);
        $query->execute();
        if($query->get_result()->num_rows != 1) {
            return;
        }
        $username = $query->get_result()->fetch_array()['username'];
        $query->close();
        return $username;
    }

    /**
     * Function to log out. It ends the session and forwards the user to the default page
     * @author Robin Herder
     */
    function logout() {
        session_destroy();
        header('Location: index.php');
    }

?>