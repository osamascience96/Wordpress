<?php
    
    require '../app/helper/Operations.php';
    require '../app/service/user.php';

    if(isset($_POST['username'])){
        $username = $_POST['username'];

        if(!IsNullOrEmpty($username)){
            $is_verifed = VerifyUser($username);
            echo json_encode($is_verifed ? 'verified' : 'user_verification_failed');
        }else{
            echo json_encode('username_not_proper');    
        }
    }else{
        echo json_encode('username_credential_needed');
    }
?>