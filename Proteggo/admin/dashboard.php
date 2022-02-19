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

    $response = GetAPIData(APIURL . '/Getalluserattempts.php');

    $responseServer = isset($_GET['response']) ? $_GET['response'] : null;
?>
    <!-- add the navigation -->
    <?php require_once '../admin/includes/navigation.php';?>
    <div class="container-fluid">
        <br>
        <?php if($responseServer != null){?>
            <?php if($responseServer == "verified"){?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> Profile Verified Successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php }else{?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> Profile couldn't be verified due to some problem.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php }?>
        <?php }?>
        <h5>All Users</h5>
        <div class="table-responsive">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Username</th>
                        <th scope="col">Password</th>
                        <th scope="col">Verified</th>
                        <th scope="col">Created at</th>
                        <th scope="col"></th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($response as $object){?>
                        <tr>
                            <th scope="row"><?=$object->username?></th>
                            <td><?=$object->password?></td>
                            <td><?=$object->verified == 1 ? '<i class="fa fa-check" aria-hidden="true"></i>' : '<i class="fa fa-times" aria-hidden="true"></i>' ?></td>
                            <td><?=$object->created_at?></td>
                            <td>
                                <a href="UserProfile.php?username=<?=$object->username?>" class="btn btn-primary">View</a>
                            </td>
                        </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="../admin/js/jquery.min.js"></script>
    <script src="../admin/js/popper.js"></script>
    <script src="../admin/js/bootstrap.min.js"></script>
    <script src="../admin/js/main.js"></script>
<?php require '../admin/includes/head.php';?>