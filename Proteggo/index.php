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
            <form method=POST action="app/handle_request.php" autocomplete="off">
                <div id="login">
                    <fieldset>
                        <legend>Per accedere al sistema inserire le credenziali</legend>
                        <br><br>
                         <?php if($servResp != null){?>
                            <?php if($servResp == "no_credentials_provided"){?>
                                <h3 style="color:red;">User Login Credentials not provided</h3>
                            <?php }else if($servResp == "loggedout"){?>
                                <h3 style="color:green;">User Logged Out Successfully</h3>
                            <?php }else if($servResp == "missing_credentials"){?>
                                <h3 style="color:red;">User Login Credentials Missing</h3>
                            <?php }?>
                        <?php }?> 
                        <label for="j_username">Codice Identificativo</label>
                        <input name="j_username" id="j_username" maxlength="16" required>
                        <br>
                        <label for="j_password">Parola chiave</label>
                        <input type="password" name="j_password" id="j_password" required>
                        <br><br>
                        <input type="submit" name="conferma" value="CONFERMA"  class="button" />
                        <input type="reset" name="ripulisci" value="RIPULISCI"   class="button" />
                        <br><br>
                        <a href="#"><b>Parola chiave dimenticata?</b></a>
                        <br>
                    </fieldset>
                </div>
            </form> 
            <br/><br/>
            <fieldset>
                <legend>Informazioni</legend> 
                Per chiarimenti in merito alla login rivolgersi al numero verde
            </fieldset>
	</div>
	<hr class="invisibile">		
<?php require '../'.PROJECT_NAME.'/includes/footer.php'?>