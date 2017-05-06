<?php
    include '../../../functions.php';
    checkLogin ( docrefType , "../../../../");
    open_html ( "Inserisci studenti" );
    import("../../../../");
    echo "<script src='scripts/script.js'></script>";    
?>
<script>
    addSelectionsFor('anno_scolastico');
    addSelectionsFor('classe');
</script>
    
<body>
    <?php
        topNavbar ("../../../../");
        titleImg ("../../../../");
    ?>
    <input type="hidden" id="userexists" value="0">
    <input type="hidden" id="passworderror" value="0">
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Inserimento studenti</h1>
                    <br>
                    <div class="row">
                        <form class="form-vertical">
                            <div class="col col-sm-6">
                                
                                <b id="usr">Username*</b> <div class="form-group">
                                    <div class="form-group has-error has-feedback" id="usernameregulator"> 
                                        <input class="form-control" id="usernameStudente"> 
                                        <span class="glyphicon glyphicon-remove form-control-feedback" id="usernamespanregulator"></span> 
                                    </div>                                
                                </div>
                                <b id="psw">Password*</b> 
                                <div class="form-group"> 
                                    <div class="form-group has-error has-feedback" id="passwordregulator"> 
                                        <input class="form-control" type="password" id="passwordStudente">
                                        <span class="glyphicon glyphicon-remove form-control-feedback" id="passwordspanregulator"></span> 
                                    </div> 
                                </div>
                                <b>Conferma Password*</b> <div class="form-group"> <input class="form-control" type="password" id="confermaPasswordStudente"> </div>
                                <b>Nome*</b> <div class="form-group"> <input class="form-control" id="nomeStudente"> </div>
                                <b>Cognome*</b> <div class="form-group"> <input class="form-control" id="cognomeStudente"> </div>
                                <b>Città</b> <div class="form-group"> <input class="form-control" id="cittaStudente"> </div>
                                <b>E-mail</b> <div class="form-group"> <input class="form-control" id="mailStudente"> </div>
                                <b>Telefono</b> <div class="form-group"> <input class="form-control" type="number" min="1" id="telefonoStudente"> </div>
                                <br>
                                * Campo Obbligatorio
                                <br>
                                <br>
                                <input type="button" class="btn btn-primary" value="Invia" onclick="sendData();">
                                    
                                    
                            </div>
                                
                            <div class="col col-sm-6">
                                <b>Classe* </b> <div class="form-group"><select class="form-control"  id="classeStudente">  </select> </div>
                            </div>
                        </form>
                    </div>
                </div>
                    
                <div class="panel">
                    <div class="row">
                        <div class="col col-sm-12">
                            <div class="row">
                                <div class="col col-sm-6">
                                    <form onsubmit="updateFormInputs()" enctype="multipart/form-data" method="POST" action="studentloader.php" name="uploadform">
                                        Seleziona il file contenente gli studenti da caricare:
                                        <br>
                                        <br>
                                        <input type="file" class="filestyle" data-buttonName="btn-primary" data-placeholder="File non inserito" name="studentfile">
                                        <input type="hidden" name="classe" value="">
                                        <input type="hidden" name="anno" value="">
                                        <br>
                                        <input type="submit" class="btn btn-primary" value="invia" name="invio">
                                        <div align="right">
                                            <u><a style="color: #828282" href="Stage_Manager_Modulo_Studenti.xlsx" download>Scarica modello per gli studenti</a></u>
                                        </div>
                                    </form>
                                </div>
                                <div class="col col-sm-6">
                                    <b>Classe* </b> <div class="form-group"><select class="form-control"  id="classeStudenteForm">  </select> </div>
                                </div>
                            </div>                        
                        </div>                    
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ("../../../../");
?>