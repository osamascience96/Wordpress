<?php
    require '../app/helper/session_helper.php';

    $response = "";
    
    $session_helper = new SessionHelper();

    if($session_helper->is_session_exists('user_obj')){
        // remove the session 
        $session_helper->unset_session_variable('user_obj');
        // end the session
        $session_helper->destroy_session();

        $response = "?response=loggedout";
    }

    header("Location:../index.php" . $response);
?>