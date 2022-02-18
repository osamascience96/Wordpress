<?php

    require '../app/helper/Operations.php';
    require '../app/service/Response.php';

    if(isset($_POST['login_success_response']) || isset($_POST['login_failed_response'])){
        
        $login_success_response = isset($_POST['login_success_response']) ? $_POST['login_success_response'] : null;
        $login_failed_response = isset($_POST['login_failed_response']) ? $_POST['login_failed_response'] : null;
        
        // if the login success response
        if(!IsNullOrEmpty($login_success_response)){
            $json_arr = WriteLoginSuccessResponse($login_success_response);
            // if the json array is not empty
            echo !empty($json_arr) ? json_encode($json_arr) : [];
        }   
        
        // if the login failed response
        if(!IsNullOrEmpty($login_failed_response)){
            $json_arr = WriteLoginFailedResponse($login_failed_response);
            // if the json array is not empty
            echo !empty($json_arr) ? json_encode($json_arr) : [];
        }
    }else{
        echo json_encode("params_not_provided");
    }
?>