<?php require '../admin/includes/head.php';?>
<?php
    require 'helper/session_helper.php';
    require 'constants.php';

    // check if the session is set
    $session = new SessionHelper();
    if(!$session->is_session_exists('userObj')){
        header("Location: /" . DefaultURL);
    }


    $response = isset($_GET['response']) ? $_GET['response'] : null;
?>
    <!-- add the navigation -->
    <?php require_once '../admin/includes/navigation.php';?>
    <div class="container">
        <br>
        <?php if($response != null){?>
            <?php if($response == "user_created_success"){?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> User Created Successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php }else{?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Failed!</strong> User couldn't be created successfully.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php }?>
        <?php }?>
        <br>
        <form action="insertuser.php" method="post">
            <div class="row">
                <div class="col-12">
                    <label for="username" class="form-label">Enter Username</label>
                    <input type="text" id="username" name="username" class="form-control" required>
                </div>
                <div class="col-12">
                    <label for="password" class="form-label">Enter Password</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>
            </div>
            <hr>
            <input type="submit" class="btn btn-success btn-block" value="Save User">
        </form>
    </div>
    <script src="../admin/js/jquery.min.js"></script>
    <script src="../admin/js/popper.js"></script>
    <script src="../admin/js/bootstrap.min.js"></script>
    <script src="../admin/js/main.js"></script>
<?php require '../admin/includes/head.php';?>