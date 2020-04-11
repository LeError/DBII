<?php

    header('Content-Type: application/json');
    $result = array();

    if(!isset($_POST['function']) ) {
        $result['error'] = 'No function name!';
    }

    if(!isset($_POST['params']) ) {
        $aResult['error'] = 'No function parameters!';
    }

    switch($_POST['function']) {
        case 'loginUser':
            loginUser($_POST['params'][0], $_POST['params'][1]);
            break;
        case 'loginSurveyUser':
            loginSurveyUser($_POST['params'][0]);
            break;
        default: $result['error'] = 'Unknown function '.$_POST['function'].' was called';
    }

?>