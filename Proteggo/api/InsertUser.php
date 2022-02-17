<?php
    require '../app/helper/Operations.php';

    if(isset($_POST['username']) && isset($_POST['password'])){
        require '../app/service/user.php';

        $username = $_POST['username'];
        $password = $_POST['password'];
        $timestamp = date("Y-m-d h:i:s a");

        if(!IsNullOrEmpty($username) && !IsNullOrEmpty($password)){
            $is_user_created = InsertUser($username, $password, $timestamp);
            
            if($is_user_created){
                echo json_encode("user_created_success");
            }else{
                echo json_encode("user_insert_failed_or_already_exists");
            }
        }else{
            echo json_encode("provide_params_properly");    
        }
    }else{
        echo json_encode("params_not_provided");
    }
?>