<?php require_once '../admin/helper/session_helper.php';?>
<?php require_once '../admin/constants.php';?>

<?php
    $session_help = new SessionHelper();

    if($session_help->is_session_exists('userObj')){
        $session_help->unset_session_variable('userObj');
        $session_help->remove_all_session_variables();
        $session_help->destroy_session();
    }

    header("Location: " . HOMEURL);
?>