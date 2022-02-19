<?php require '../admin/includes/head.php';?>
<?php require_once '../admin/helper/Operations.php';?>
    <?php
        $response = isset($_GET['response']) ? $_GET['response'] : null;
    ?>
    <section class="ftco-section">
		<div class="container"> 
			<div class="row justify-content-center">
				<div class="col-md-7 col-lg-5">
                    <?php if(!IsNullOrEmpty($response)){?>
                        <?php if($response == "no_credentials_provided"){?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> No credentials Provided.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php }else if($response == "missing_credentials"){?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> Login Credentials are missing.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php }else if($response == "invalid_credentials"){?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <strong>Error!</strong> Invalid Credentials Provided.
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        <?php }?>
                    <?php }?>
					<div class="wrap">
						<div class="img" style="background-image: url('../admin/images/bg-1.jpg');"></div>
						<div class="login-wrap p-4 p-md-5">
                            <div class="d-flex">
                                <div class="w-100">
                                    <h3 class="mb-4">Sign In</h3>
                                </div>
                            </div>
                            <form action="../admin/controller/Login.php" method="post" class="signin-form">
                                <div class="form-group mt-3">
                                    <input type="text" name="username" class="form-control" required>
                                    <label class="form-control-placeholder" for="username">Username</label>
                                </div>
                                <div class="form-group">
                                    <input id="password-field" name="password" type="password" class="form-control" required>
                                    <label class="form-control-placeholder" for="password">Password</label>
                                    <span toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="form-control btn btn-primary rounded submit px-3">Sign In</button>
                                </div>
                            </form>
		                </div>
                </div>
            </div>
        </div>
		</div>
	</section>
    <script src="../admin/js/jquery.min.js"></script>
    <script src="../admin/js/popper.js"></script>
    <script src="../admin/js/bootstrap.min.js"></script>
    <script src="../admin/js/main.js"></script>
<?php require '../admin/includes/head.php';?>