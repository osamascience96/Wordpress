<?php require 'constants.php'?>
<?php require "../".PROJECT_NAME."/includes/head.php"?>
    <?php
        $servResp = isset($_GET['response']) ? $_GET['response'] : null;
    ?>
	<p class="invisibile"><a id="contenuto" name="contenuto"></a></p>
	<hr class="invisibile">
	<div id="contenuti">
            <h1>AUTENTICAZIONE</h1>
            <fieldset id="messaggi">
                <legend>Messaggi</legend>
                <br><br>
            </fieldset>
            <br/>	
            <div id="login">
                <fieldset>
                    <legend>Per accedere al sistema inserire le credenziali</legend>
                    <br><br>
                    <?php if($servResp != null){ ?>
                        <?php if($servResp == "login_success"){?>
                            <h1 style="color: green;">Login Successful</h1>
                        <?php }else if($servResp == "invalid_credentials"){?>
                            <h1 style="color: red;">Login Failed</h1>
                        <?php }?>
                    <?php }?>
                </fieldset>
            </div>
            <br/><br/>
            <fieldset>
                <legend>Informazioni</legend> 
                Per chiarimenti in merito alla login rivolgersi al numero verde
            </fieldset>
	</div>
	<hr class="invisibile">		
<?php require '../'.PROJECT_NAME.'/includes/footer.php'?>