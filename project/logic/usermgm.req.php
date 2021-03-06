<?php
    /**
     * usermgm.req.php
     *
     * Stores the logic for the user management (user & survey user)
     * From login to deleting a  user or course all functions are stored in this file
     *
     * @author     Robin Herder
     */

    //Prevent user form accessing file directly
    require_once('security.req.php');
    checkDocument();

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
        $user = htmlspecialchars($user);
        $query->bind_param('s', $user);
        if(!$query->execute()) {
            publishErrorNotification('Ein unerwarteter Fehler ist Aufgetreten');
            return;
        }
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
        $user = htmlspecialchars($user);
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
        $user = htmlspecialchars($user);
        $query->bind_param('s', $user);
        if(!$query->execute()) {
            publishErrorNotification('Ein unerwarteter Fehler ist Aufgetreten');
            return;
        }
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
                $user = htmlspecialchars($user);
                $pass = htmlspecialchars($pass);
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
            "SELECT * FROM survey_site.survey_user_group g 
            WHERE g.course_short = ?"
        );
        $course_short = htmlspecialchars($course_short);
        $query->bind_param('s', $course_short);
        if(!$query->execute()) {
            publishErrorNotification('Ein unerwarteter Fehler ist Aufgetreten');
            return;
        }
        $result = $query->get_result();
        if($result->num_rows != 0) {
            publishErrorNotification('Kurskürzel bereits vergeben. Kurs wurde nicht erstellt!');
            return;
        }
        $query->close();
        $query = getDbConnection()->prepare(
            "INSERT INTO survey_user_group (course, course_short) 
            VALUES (?, ?);"
        );
        $course = htmlspecialchars($course);
        $course_short = htmlspecialchars($course_short);
        $query->bind_param('ss', $course, $course_short);
        if(!$query->execute()) {
            publishErrorNotification("Ein unerwarteter Fehler ist Aufgetreten. Kurs wurde nicht Erstellt!");
            $query->close();
            return;
        }
        $query->close();
        publishInfoNotification('Kurs wurde erfolgreich erstelt');
    }

    /**
     * Function for generating the Course Entities in the Course View with forms and interaction buttons
     * @author Robin Herder
     */
    function displayCourses() {
        $query = getDbConnection()->prepare('
            SELECT * FROM survey_site.survey_user_group;
        ');
        if(!$query->execute()) {
            publishErrorNotification('Ein unerwarteter Fehler ist Aufgetreten');
            return;
        }
        $result = $query->get_result();
        while ($row = $result->fetch_assoc()) {
            echo '
                <form method="post" action="index.php?view=user_mgm&course='.$row['course_short'].'">
                    <div class="bd-survey-list-item" style="padding-bottom: 0.75vh; width: 100%">
                        <button class="ui button" name="course" value="course" type="submit" style="width: 80%;">'.$row['course_short'].' - '.$row['course'].'</button>
                        <button class="ui inverted secondary icon button" name="edit" type="submit" value="edit"><i class="edit icon"></i></button>
                        <button class="ui inverted red icon button" name="delete" type="submit" value="delete"><i class="trash icon"></i></button>
                    </div>
                </form>
            ';
        };
        $query->close();
    }

    /**
     * Displays Members of a Course as a list item
     * @author Robin Herder
     * @param $course
     */
    function displayCourse($course) {
        $query = getDbConnection()->prepare('
            SELECT * FROM survey_site.survey_user u 
            WHERE u.course_short = ?;
        ');
        $course = htmlspecialchars($course);
        $query->bind_param('s', $course);
        if(!$query->execute()) {
            publishErrorNotification('Ein unerwarteter Fehler ist Aufgetreten');
            return;
        }
        $result = $query->get_result();
        if($result->num_rows == 0) {
            echo '
                <div class="item">
                    <div class="content">
                         <div class="header">Leer</div>
                         <div class="description">Es wurden Keine Nutzer im Kurs gefunden oder Kurs unbekannt</div>
                    </div>
                    <br/>
                </div>
            ';
        }
        while($row = $result->fetch_assoc()) {
            echo '
                <div class="item">
                    <div class="content">
                         <div class="header">'.$row['matricule_number'].'</div>
                         <div class="description">'.$row['username'].'</div>
                    </div>
                    <hr/>
                    <br/>
                </div>
            ';
        }
        $query->close();
    }

    /**
     * deletes a course (All survey users in the course will also be deleted and the answers to the surveys they gave)
     * @author Robin Herder
     * @param $course
     * @return bool
     */
    function deleteCourse($course) {
        $query = getDbConnection()->prepare('
            DELETE FROM survey_site.survey_user_group 
            WHERE course_short = ?;
        ');
        $course = htmlspecialchars($course);
        $query->bind_param('s', $course);
        $query->execute() or publishErrorNotification('Kann Kurs nicht Löschen');
        return true;
    }

    /**
     * Function for registering a new SurveyUser
     * @author Robin Herder
     * @param $matricule_number
     * @param $username
     * @param $course_short
     */
    function registerSurveyUser($matricule_number, $username, $course_short) {
        $query = getDbConnection()->prepare('
            SELECT * FROM survey_site.survey_user u 
            WHERE u.matricule_number = ?;
        ');
        $matricule_number = htmlspecialchars($matricule_number);
        $query->bind_param('s', $matricule_number);
        if(!$query->execute()) {
            publishErrorNotification('Ein unerwarteter Fehler ist Aufgetreten');
            return;
        }
        $result = $query->get_result();
        if($result->num_rows != 0) {
            publishErrorNotification('Nutzer mit dieser Matrikelnummer existiert bereits');
            return;
        }
        $query->close();
        $query = getDbConnection()->prepare(
            "INSERT INTO survey_user (matricule_number, username, course_short) 
            VALUES (?, ?, ?);"
        );
        $matricule_number = htmlspecialchars($matricule_number);
        $username = htmlspecialchars($username);
        $course_short = htmlspecialchars($course_short);
        $query->bind_param('sss', $matricule_number, $username, $course_short);
        if($query->execute()) {
            publishInfoNotification('Nutzer wurde angelegt');
        } else {
            publishErrorNotification('Nutzer konnte nicht erstellt werden');
        }
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
        $matricule_number = htmlspecialchars($matricule_number);
        $query->bind_param('s', $matricule_number);
        if(!$query->execute()) {
            publishErrorNotification('Ein unerwarteter Fehler ist Aufgetreten');
            return;
        }
        $result = $query->get_result();
        if($result->num_rows == 1) {
            $_SESSION[SESSION_USER] = $matricule_number;
            $_SESSION[SESSION_ROLE] = ROLE_USER;
        } else {
            session_unset();
            publishErrorNotification("Kein Nutzer mit dieser Matrikel Nummer wurde Gefunden!");
        }
        $query->close();
    }

    /**
     * Delete a Survey user (All answers that that user gave to a survey will be also deleted)
     * @param $matricule_number of user you want to delete
     * @author Robin Herder
     */
    function deleteSurveyUser($matricule_number) {
        $query = getDbConnection()->prepare('
            SELECT * FROM survey_site.survey_user u 
            WHERE u.matricule_number = ?;
        ');
        $matricule_number = htmlspecialchars($matricule_number);
        $query->bind_param('s', $matricule_number);
        if(!$query->execute()) {
            publishErrorNotification('Ein unerwarteter Fehler ist Aufgetreten');
            return;
        }
        $result = $query->get_result();
        if($result->num_rows != 1) {
            publishErrorNotification('Kann Nutzer nich Löschen da er nicht existiert!');
            return;
        }
        $query->close();
        $query = getDbConnection()->prepare('
            DELETE FROM survey_site.survey_user 
            WHERE matricule_number = ?; 
        ');
        $matricule_number = htmlspecialchars($matricule_number);
        $query->bind_param('s', $matricule_number);
        if($query->execute()) {
            publishInfoNotification('Der Nutzer wurde Erfolgreich gel&ouml;scht');
        } else {
            publishErrorNotification('Der Nutzer konnte nicht angelegt werden!');
        }
    }

    /**
     * Function to return name of survey_user for example used to greet user
     * @author Robin Herder
     * @param $matricule_number identifier of survey_user
     * @return username
     */
    function getSurveyUsername($matricule_number) {
        $query = getDbConnection()->prepare(
            "SELECT u.username FROM survey_user u 
            WHERE u.matricule_number = ?;"
        );
        $matricule_number = htmlspecialchars($matricule_number);
        $query->bind_param('s', $matricule_number);
        if(!$query->execute()) {
            return '';
        }
        $result = $query->get_result();
        if($result->num_rows != 1) {
            return '';
        }
        $username = $result->fetch_array()['username'];
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

    /**
     * Checks if a course exists
     * @param $course course short that you want to delete
     * @author Robin Herder
     */
    function checkCourseExists($course) {
        $query = getDbConnection()->prepare('
            SELECT * FROM survey_site.survey_user_group g
            WHERE g.course_short = ?;
        ');
        $course = htmlspecialchars($course);
        $query->bind_param('s', $course);
        if($query->execute()) {
            $result = $query->get_result();
            if($result->num_rows != 1) {
                $msg[0] = 'Der übergebene Kurs wurde nicht gefunden! Bitte zur übersicht zurückkehren ---> <a href="index.php?view=user_mgm">Übersicht</a>';
                echoNotificationEntries(MSG_LVL_ERROR, $msg);
            }
        } else {
            $msg[0] = 'Beim abfragen des Kurses ist ein Fehler aufgetreten!';
            echoNotificationEntries(MSG_LVL_ERROR, $msg);
        }
        $query->close();
    }

?>