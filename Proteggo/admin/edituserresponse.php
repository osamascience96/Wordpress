<?php
    if(isset($_POST['login_success_response']) && isset($_POST['login_failed_response'])){
        $successResponse = $_POST['login_success_response'];
        $failedResponse = $_POST['login_failed_response'];

        require 'constants.php';
        require 'helper/APIRequest.php';

        $response = GetAPIDataParam(APIURL . '/SetResponse.php', array('login_success_response' => $successResponse));
        $response = GetAPIDataParam(APIURL . '/SetResponse.php', array('login_failed_response' => $failedResponse));
        $finalresp = !empty($response) ? "response_updated" : "response_not_updated";
        header("Location:/" . DefaultURL . '/userresponse.php?response=' . $finalresp);
    }
?>