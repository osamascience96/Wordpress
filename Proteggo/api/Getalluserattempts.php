<?php
    require '../app/service/user.php';
    require '../app/helper/Operations.php';

    if(isset($_POST['username'])){

        $username = $_POST['username'];

        if(!IsNullOrEmpty($username)){
            // Get the user based on the username
            echo json_encode(GetUserAttempt($username));
        }else{
            echo json_encode("param_not_provided_properly");
        }
    }else{
        // Get all the users
        echo json_encode(GetAllUserAttempts());
    }
?>