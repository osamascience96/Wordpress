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

    $response = GetAPIData(APIURL . '/GetAllResponse.php');

    $responseServer = isset($_GET['response']) ? $_GET['response'] : null;
?>
    <!-- add the navigation -->
    <?php require_once '../admin/includes/navigation.php';?>
    <div class="container">
        <br>
        <?php if($responseServer != null){?>
            <?php if($responseServer == "response_updated"){?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> User Response Updated Successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php }else{?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Failed!</strong> User Response create failed.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php }?>
        <?php }?>
        <br>
        <form action="edituserresponse.php" method="post">
            <div class="row">
                <div class="col-12">
                    <label for="" class="form-label">Enter Login Success Response</label>
                    <input type="text" class="form-control" name="login_success_response" placeholder="Enter Login Success" value="<?=$response[0]->after_loginsuccess_response?>" required>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <label for="" class="form-label">Enter Login Failed Response</label>
                    <input type="text" class="form-control" name="login_failed_response" placeholder="Enter Login Failed" value="<?=$response[1]->after_loginfailed_response?>" required>
                </div>
            </div>
            <hr>
            <button type="submit" class="btn btn-success btn-block">Save Response</button>
        </form>
    </div>
    <script src="../admin/js/jquery.min.js"></script>
    <script src="../admin/js/popper.js"></script>
    <script src="../admin/js/bootstrap.min.js"></script>
    <script src="../admin/js/main.js"></script>
<?php require '../admin/includes/head.php';?>