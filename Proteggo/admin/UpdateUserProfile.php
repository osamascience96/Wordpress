<?php
    if(isset($_POST['username'])){
        $username = $_POST['username'];

        require 'constants.php';
        require 'helper/APIRequest.php';

        $response = GetAPIDataParam(APIURL . '/VerifyUser.php', array('username' => $username));
        header("Location:/" . DefaultURL . '/dashboard.php?response=' . $response);
    }
?>