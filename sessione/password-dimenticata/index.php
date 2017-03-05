<?php
	include "../../pages/functions.php";
	open_html ( "Password dimenticata" );
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
                    <h1>Recupero tramite indirizzo e-mail</h1>
                    <br>
                    <form onsubmit="emailRecovery (); return false;" method="POST">
                    	<div class="row">
                            <div class="col col-sm-6">
                                Email per il recupero password <input type="email" class="form-control" name="mail" required>
                            </div>
                            <div class="col col-sm-6">
                                Conferma Email <input type="email" class="form-control" name="confermamail" required>
                            </div>
                    	</div>
                    	<br>
                    	<div class="row">
                            <div class="col col-sm-12">                            	
                                <input type="submit" class="btn btn-primary" value="Invia" id="sendEmail" disabled>   
                            </div>
                    	</div>
                    </form>
                	<!--<hr class="hr-padding"/>
                    <h1>Recupero tramite domanda segreta</h1>
                    <br>
                	<div class="row">
                        <div class="col col-sm-6">
                            Username <input type="text" class="form-control" id="username">
                        </div>
                        <div class="col col-sm-6">
                        <br>
                            <button class="btn btn-primary" id="confermaUsername">Calcola domanda segreta</button>
                        </div>
                	</div>
                	<br>
                    <form class="hidden" action="" method="POST">
                    	<input type="hidden" name="user" required/>
                    	<div class="row">
                            <div class="col col-sm-6">
                                Domanda <input type="text" class="form-control" name="domanda">
                            </div>
                            <div class="col col-sm-6">
                                Risposta <input type="text" class="form-control" name="risposta" required>
                            </div>
                    	</div>
                    	<br>
                    	<div class="row">
                            <div class="col col-sm-12">                            	
                                <input type="submit" class="btn btn-primary" value="Invia" id="sendAnswer">   
                            </div>
                    	</div>
                    </form>
                    -->
                </div>
            </div>
        </div>
    </div>
</body>
<?php
	close_html ("../../");
?>