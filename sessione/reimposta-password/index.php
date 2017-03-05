<?php
	include "../../pages/functions.php";
	open_html ( "Reimposta password" );
    import("../../");
?>
<script src="js/scripts.js"></script>
<?php
    $conn = dbConnection("../../");
    if (isset ($_GET ['user']) && isset ($_GET ['code'])) {
        $username = $_GET ['user'];
        $codice = $_GET ['code'];
        $query = "SELECT utente.id_utente 
                    FROM utente, recupera_password 
                    WHERE utente.username = '$username' 
                    AND recupera_password.codice_email = '$codice'
                    AND utente.recupera_password_id_recupera_password = recupera_password.id_recupera_password;";
        $result = $conn->query($query);
        if (!$result->num_rows > 0) //togliere punto esclamativo!!!!!!!!!
        {
            $id_utente = $row ['id_utente'];
        }
        else {
?>
    <script>backToHome ();</script>
<?php            
        }
    }
    else {
?>
    <script>backToHome ();</script>
<?php
    }
?>
<body>
<?php
    topNavbar ("../../");
    titleImg ("../../");
?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Reimposta password</h1>
                    <br>
                    <form onsubmit="replacePassword (); return false;">
                    	<input type="hidden" name="id" value="<?php echo $id_utente; ?>">
                    	<div class="row">
                            <div class="col col-sm-6">
                                Nuova password <input type="password" class="form-control" name="password" required><br>
                            </div>
                            <div class="col col-sm-6">
                                Conferma password <input type="password" class="form-control" name="confermapassword" required>
                            </div>
                    	</div>
                    	<br>
                    	<div class="row">
                            <div class="col col-sm-12">                            	
                                <input type="submit" class="btn btn-primary" value="Invia" id="send" disabled>  
                            </div>
                    	</div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
	close_html ("../../");
?>