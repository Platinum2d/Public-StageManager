<html>
    <head>
        <title> Installazione! </title>
        <?php
            include "../pages/functions.php";
            import("../");
        ?>
        <link href="installStyle.css" rel="stylesheet">
    </head>
    
    <body>
        <div class="container">
            <div class="row">
                <div class="col col-sm-12">
                    <div class="panel mainpanel" style="min-height: 0px">
                        <h1 style="color:#ff3333"> CREDENZIALI DELL'ADMIN </h1> <br> <div id="plis">Ora necessitiamo dei dati con cui effettuerai il primo accesso. Compila i seguenti campi per favore</div>  <br><br><br>
                            <div class="row">
                                <div class="col col-sm-6">
                                    <div class="paddedDiv"> <b> Username* </b> <input type="text" class="form-control" id="Username"></div> 
                                    <div class="paddedDiv"> Nome <input type="text" class="form-control" id="Nome"> </div>
                                    <div class="paddedDiv"> Cognome <input type="text" class="form-control" id="Cognome"> </div>
                                   
                                    
                                </div>
                                <div class="col col-sm-6">
                                    <div class="paddedDiv"> <b> Password (minimo 8 caratteri)* </b> <input type="password" class="form-control" id="Password"> </div>
                                    <div class="paddedDiv"> <b> Conferma Password* </b> <input type="password" class="form-control" id="ConfermaPassword"> </div>
                                    <div class="paddedDiv"> Indirizzo e-Mail <input type="text" class="form-control" id="Mail"> </div>
                                    <div class="paddedDiv"> Telefono <input type="text" class="form-control" id="Telefono"> </div>
                                </div>
                            </div>
                        <p style='padding-left:20px'> *Campo obbligatorio </p>
                        <div class="paddedDiv" align="right">  <input id="sub" type="button" value="Avanti" class="btn btn-primary" onclick="insertSuperUser()"> <br> <br> </div><p id='report'></p>
                    </div>
                </div>
            </div>
        </div>
        
        <script> 
            String.prototype.isEmpty = function() {
                return (this.length === 0 || !this.trim());
            };            
            var timer = setInterval(function(){
            if (($("#Password").val()).isEmpty() || ($("#Username").val()).isEmpty() || ($("#ConfermaPassword").val()).isEmpty() || ($("#Password").val()) !== ($("#ConfermaPassword").val()) || ($("#Password").val()).length < 8){
                $("#sub").prop("disabled",true);
            }
            else
            {
                $("#sub").prop("disabled",false);
            }
        },1);

            function insertSuperUser()
            {
                SuperUser = {
                  'username' : $("#Username").val(),
                  'nome' : $("#Nome").val(),
                  'mail' : $("#Mail").val(),
                  'password' : $("#Password").val(),
                  'cognome' : $("#Cognome").val(),
                  'telefono' : $("#Telefono").val()
                };
                
                SuperUser.nome = (SuperUser.nome.isEmpty()) ? "Sconosciuto" : SuperUser.nome;
                SuperUser.mail = (SuperUser.mail.isEmpty()) ? "Sconosciuta" : SuperUser.mail;
                SuperUser.cognome = (SuperUser.cognome.isEmpty()) ? "Sconosciuto" : SuperUser.cognome;
                SuperUser.telefono = (SuperUser.telefono.isEmpty()) ? "Sconosciuto" : SuperUser.telefono;
                
                $.ajax({
                    type : 'POST',
                    url : 'ajaxOps/ajaxCreateSuperUser.php',
                    data : SuperUser,
                    cache : false,
                    success : function (msg)
                    {
                        if(msg !== "ok")
                            $("#report").html(""+msg);
                        else
                            location.href = "../pages/done.php";
                    }
                });
            }
        </script>
    </body>
</html>