<?php
	include "../../pages/functions.php";
	open_html ( "Password Dimenticata" );
    import("../../");
?>

<body>
    <?php
        topNavbar ("../../");
        titleImg ("../../");
    ?>
    <script src="scripts/scripts.js"></script>     
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Passwrod dimenticata</h1>
                    <br>
                    <div class="row">
                        <form action="sendmail.php" method="POST">
                            <div class="col col-sm-6">
                                Email per il recupero password <input type="email" class="form-control" name="mail" required><br>
                                <input type="submit" class="btn btn-primary" value="Invia" id="send" disabled>   
                            </div>
                            
                            <div class="col col-sm-6">
                                Conferma Email <input type="email" class="form-control" name="confermamail" required>
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
	close_html ("../../");
?>