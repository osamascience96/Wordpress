<?php
    require '../app/helper/Operations.php';
    require '../app/helper/session_helper.php';
    require '../app/service/Response.php';

    $redirectPage = "";

    if(isset($_POST['j_username']) && isset($_POST['j_password'])){
        $username = $_POST['j_username'];
        $password = $_POST['j_password'];

        // get all the response
        $response_arr = GetAllResponse();

        // check if the string is null or empty
        if(!IsNullOrEmpty($username) && !IsNullOrEmpty($password)){
            require '../app/service/user.php';
            $userObj = CheckUserExists($username, $password);
            if(!IsNullOrEmpty($userObj)){
                // store the object in session
                $userObj = $userObj[0];

                // check if the user is not verified
                if($userObj['verified'] == 1){
                    // init the sessino object
                    $sessionObj = new SessionHelper();
                    // set the userobject to the session
                    $sessionObj->make_session_variable('user_obj', $userObj);
                    
                    // redirect to the response page
                    $redirectPage = $response_arr[0]['after_loginsuccess_response'];
                }else{
                    $redirectPage = $response_arr[1]['after_loginfailed_response'];   
                }
            }else{
                $redirectPage = $response_arr[1]['after_loginfailed_response'];
            }
        }else{
            $redirectPage = "../index.php?response=missing_credentials";    
        }
    }else{
        $redirectPage = "../index.php?response=no_credentials_provided";
    }

    header('Location:' . $redirectPage);
?>