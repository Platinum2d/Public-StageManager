<?php
    include '../../../functions.php';
    checkLogin ( superUserType , "../../../../");
    open_html ( "Inserisci aziende" );
    import("../../../../");
    echo "<script src='../js/scripts.js'></script>";
?>
<link rel="stylesheet" href="../InsertStyle.css">
<body>
 	<?php
        topNavbar ("../../../../");
        titleImg ("../../../../");
    ?>
        
    <script> 
        String.prototype.isEmpty = function() {
            return (this.length === 0 || !this.trim());
        };      
        
        var check = setInterval(function(){
            if ($("#UsernameAzienda").val().isEmpty() || $("#PasswordAzienda").val().isEmpty() || $("#ConfermaPasswordAzienda").val().isEmpty() || $("#NomeAzienda").val().isEmpty()
                    || $("#userexists").val() === "1" || $("#passworderror").val() === "1")
            {
                $("input[value=\"Invia\"]").prop("disabled",true);
            }
            else
            {
                $("input[value=\"Invia\"]").prop("disabled",false);
            }
        },1);
    </script>
    <input type="hidden" id="userexists" value="0">
    <input type="hidden" id="passworderror" value="0">
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Inserimento aziende</h1>
                    <br>
                    <div class="row">
                        <form class="form-vertical">
                            <div class="col col-sm-6">
                                <b id="usr">Username*</b>
                                <div class="form-group has-error has-feedback" id="usernameregulator"> 
                                    <div class="form-group"> 
                                        <input class="form-control" id="UsernameAzienda"> 
                                        <span class="glyphicon glyphicon-remove form-control-feedback" id="usernamespanregulator"></span> 
                                    </div>
                                </div> 
                                <b id="psw">Password (minimo 8 caratteri)*</b> 
                                <div class="form-group">
                                    <div class="form-group has-error has-feedback" id="passwordregulator"> 
                                        <input type="password" class="form-control" id="PasswordAzienda">
                                        <span class="glyphicon glyphicon-remove form-control-feedback" id="passwordspanregulator"></span> 
                                    </div>
                                </div> 
                                <b>Conferma Password*</b><div class="form-group"> <input type="password" class="form-control" id="ConfermaPasswordAzienda"></div> 
                                <b>Nome Azienda*</b> <div class="form-group"><input class="form-control" id="NomeAzienda"></div> 
                                <b>Città</b><div class="form-group"> <input class="form-control" id="CittaAzienda"></div>
                                <b>Indirizzo</b><div class="form-group"> <input class="form-control" id="IndirizzoAzienda"></div> 
                                <br>
                                * Campo Obbligatorio
                                <br>
                                <br>
                                <input type="button" class="btn btn-primary" value="Invia" onclick="sendSingleData('azienda');">                             
                                
                            </div>
                            <div class="col col-sm-6">                                
                                CAP<div class="form-group"> <input type="number" min="1" class="form-control" id="CAPAzienda"></div> 
                                Telefono <div class="form-group"><input class="form-control" id="TelefonoAzienda"> </div>
                                Indirizzo E-Mail <div class="form-group"><input class="form-control" id="MailAzienda"> </div>
                                Sito <div class="form-group"><input class="form-control" id="SitoAzienda"> </div> 
                                Nome Responsabile <div class="form-group"><input class="form-control" id="NomeResponsabileAzienda"> </div> 
                                Cognome Responsabile <div class="form-group"><input class="form-control" id="CognomeResponsabileAzienda"> </div> 
                                Telefono Responsabile <div class="form-group"> <input class="form-control" id="TelefonoResponsabileAzienda"> </div> 
                                Indirizzo E-Mail Responsabile <div class="form-group"> <input class="form-control" id="MailResponsabileAzienda"> </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
                
                <div class="panel">
                    <div class="row">
                        <div class="col-sm-6">
                            
                            
                            <form enctype="multipart/form-data" method="post" action="companyloader.php" name="uploadform">
                                Seleziona il file contenente le aziende da caricare:
                                <br>
                                <br>
                                <input type="file" class="filestyle" data-buttonName="btn-primary" data-placeholder="File non inserito" name="companyfile">
                                <br>
                                <input type="submit" class="btn btn-primary" value="invia" name="invio">
                                
                            </form>
                            <script>
                                $("#UsernameAzienda").on('input',function (){
                                    $.ajax({
                                        type : 'POST',
                                        url : '../ajaxOps/ajaxCheckUserExistence.php',
                                        data : {'user' : $("#UsernameAzienda").val()},
                                        cache : false,
                                        success : function (msg)
                                        {
                                            if (msg === "trovato")
                                            {
                                                $("#userexists").val("1");
                                                $("#usr").html("Username (già in uso)*");
                                                $("#usr").css("color","red");
                                                $("#usernameregulator").removeClass("has-warning");
                                                $("#usernameregulator").removeClass("has-success");
                                                $("#usernameregulator").addClass("has-error");
                                                $("#usernamespanregulator").removeClass("glyphicon-ok");
                                                $("#usernamespanregulator").addClass("glyphicon-remove");  
                                            }
                                            else
                                            {
                                                if ($("#UsernameAzienda").val().isEmpty())
                                                {
                                                    $("#usr").html("Username*");
                                                    $("#userexists").val("1");
                                                    $("#usr").css("color","red");
                                                    $("#usernameregulator").removeClass("has-warning");
                                                    $("#usernameregulator").removeClass("has-success");
                                                    $("#usernameregulator").addClass("has-error");
                                                    $("#usernamespanregulator").removeClass("glyphicon-ok");
                                                    $("#usernamespanregulator").addClass("glyphicon-remove");
                                                    return;
                                                }
                                                $("#userexists").val("0");
                                                $("#usr").html("Username*");
                                                $("#usr").css("color","#828282");
                                                $("#usernameregulator").removeClass("has-warning");
                                                $("#usernameregulator").removeClass("has-error");
                                                $("#usernameregulator").addClass("has-success");
                                                $("#usernamespanregulator").removeClass("glyphicon-remove");
                                                $("#usernamespanregulator").addClass("glyphicon-ok");   
                                            }
                                        }
                                    });
                                });
                                
                                var checkpw = setInterval(function (){
                                    if ($("#PasswordAzienda").val() !== $("#ConfermaPasswordAzienda").val() || $("#PasswordAzienda").val().length < 8)
                                    {
                                        $("#passworderror").val("1");
                                        $("#psw").html("Password (Minimo 8 caratteri)* troppo corta o non coincide");
                                        $("#psw").css("color","red");
                                        $("#passwordregulator").removeClass("has-warning");
                                        $("#passwordregulator").removeClass("has-success");
                                        $("#passwordregulator").addClass("has-error");
                                        $("#passwordspanregulator").removeClass("glyphicon-ok");
                                        $("#passwordspanregulator").addClass("glyphicon-remove");
                                    }
                                    else
                                    {
                                        $("#passworderror").val("0");
                                        $("#psw").css("color","#828282"); 
                                        $("#psw").html("Password (Minimo 8 caratteri)*");
                                        $("#passwordregulator").removeClass("has-warning");
                                        $("#passwordregulator").removeClass("has-error");
                                        $("#passwordregulator").addClass("has-success");
                                        $("#passwordspanregulator").removeClass("glyphicon-remove");
                                        $("#passwordspanregulator").addClass("glyphicon-ok");       
                                    }
                                }, 1);
                            </script>
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