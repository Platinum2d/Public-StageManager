<?php
    include '../../functions.php';
    checkLogin ( docrefType , "../../../");
    open_html ( "Inserisci docenti tutor" );
    import("../../../");
?>
<link href='css/insertStyle.css' rel='stylesheet' type='text/css'>
<script src='js/scripts.js'></script>
<body>
    <?php
        topNavbar ("../../../");
        titleImg ("../../../");
    ?>
    <input type="hidden" id="userexists" value="0">
    <input type="hidden" id="passworderror" value="0">
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Inserisci docenti tutor</h1>
                    <br>
                    <div class="row">
                        <form class="form-vertical">
                            <div class="col col-sm-6">
                                <b id="usr">Username*</b> 
                                <div class="form-group has-error has-feedback" id="usernameregulator"> 
                                    <input type="text" class="form-control" id="UsernameDocente" required> 
                                    <span class="glyphicon glyphicon-remove form-control-feedback" id="usernamespanregulator"></span> 
                                </div>
                                <b id="psw">Password (minimo 8 caratteri)*</b> 
                                <div class="form-group has-error has-feedback" id="passwordregulator"> 
                                    <input type="password" class="form-control" id="PasswordDocente" required> 
                                    <span class="glyphicon glyphicon-remove form-control-feedback" id="passwordspanregulator"></span> 
                                </div>
                                <b>Conferma Password*</b>
                                <div class="form-group">
									<input type="password" class="form-control" id="ConfermaPasswordDocente" required>
								</div>
                                <b>Nome*</b>
                                <div class="form-group">
                                	<input type="text" class="form-control" id="NomeDocente" required>
                                </div>
                                <b>Cognome*</b>
                                <div class="form-group">
                                	<input type="text" class="form-control" id="CognomeDocente" required>
                                </div>
                                <b>Telefono*</b>
                                <div class="form-group">
                                	<input type="tel" class="form-control" id="TelefonoDocente" required>
                                </div> 
                                <b>E-Mail*</b>
                                <div class="form-group">
                                	<input type="email" class="form-control" id="EmailDocente" required>
                                </div>                       
                                <br>
                                * Campo Obbligatorio
                                <br>
                                <br>                              
                                <button id="inviaSingolo" class="btn btn-primary" onclick="sendSingleData('docente');">Invia</button>
                            </div>                          
                        </form>       
                    </div>
                </div>
                <div class="panel">
                    <h1>Inserimento da file</h1>
                    <br>
                    <div class="row">
                        <div class="col-sm-6">                            
                            <form enctype="multipart/form-data" method="post" action="" name="uploadform">
                                Seleziona il file contenente i docenti da caricare:
                                <br>
                                <br>
                                <input type="file" class="filestyle" data-buttonName="btn-primary" data-placeholder="File non inserito" name="file1">
                                <br>
                                <input type="submit" class="btn btn-primary" value="invia" name="invio">                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ("../../../");
?>