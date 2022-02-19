<?php require '../admin/includes/head.php';?>
<?php
    require 'helper/session_helper.php';
    require 'constants.php';
    require 'helper/APIRequest.php';

    // check if the session is set
    $session = new SessionHelper();
    if(!$session->is_session_exists('userObj')){
        header("Location: /" . DefaultURL);
    }

    $username = $_GET['username'];

    $response = GetAPIDataParam(APIURL . '/Getalluserattempts.php', array('username' => $username));
?>
    <!-- add the navigation -->
    <?php require_once '../admin/includes/navigation.php';?>
    <div class="container-fluid">
        <form method="post" action="UpdateUserProfile.php">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6">
                    <label for="" class="form-label">Username</label>
                    <input type="text" class="form-control" value="<?=$response->username?>" disabled>
                </div>
                <input type="hidden" name="username" value="<?=$username?>"/>
            </div>
            <br>
            <div class="table-responsive">
                <table class="table table-hover table-dark">
                    <thead>
                        <tr>
                            <th scope="col">Attempts</th>
                            <th scope="col">Status</th>
                            <th scope="col">Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($response->user_attempts as $object){?>
                            <tr>
                                <th scope="row"><?=$object->attempts?></th>
                                <td><?=$object->status == "login_success" ? "Login Successful" : "Login Failed"?></td>
                                <td><?=$object->timestamp?></td>
                            </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
            <input class="btn btn-success btn-block" type="submit" value="Verify Profile">
        </form>
    </div>
    <script src="../admin/js/jquery.min.js"></script>
    <script src="../admin/js/popper.js"></script>
    <script src="../admin/js/bootstrap.min.js"></script>
    <script src="../admin/js/main.js"></script>
<?php require '../admin/includes/head.php';?>