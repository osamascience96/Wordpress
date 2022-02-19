<?php
    require_once '../helper/Operations.php';
    require_once '../helper/session_helper.php';
    require_once '../services/User.php';

    $redirectPage = "";

    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        if(!IsNullOrEmpty($username) && !IsNullOrEmpty($password)){
            $userObj = CheckUserLogin($username, $password);
            if(!empty($userObj)){
                $sessionObj = new SessionHelper();
                $sessionObj->make_session_variable("userObj", $userObj);
                $redirectPage = "../dashboard.php";
            }else{
                $redirectPage = "../index.php?response=invalid_credentials";    
            }
        }else{
            $redirectPage = "../index.php?response=missing_credentials";
        }
    }else{
        $redirectPage = "../index.php?response=no_credentials_provided";
    }

    header("Location:" . $redirectPage);
?>