<?php
    require 'constants.php';
    require 'helper/APIRequest.php';

    if(isset($_POST['username']) && isset($_POST['password'])){
        $username = $_POST['username'];
        $password = $_POST['password'];



        $response = GetAPIDataParam(APIURL . '/InsertUser.php', array('username' => $username,'password' => $password));
        header("Location:/" . DefaultURL . '/adduser.php?response=' . $response);
    }
?>