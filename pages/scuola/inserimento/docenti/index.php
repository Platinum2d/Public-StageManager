<?php
    include '../../../functions.php';
    checkLogin ( scuolaType , "../../../../");
    open_html ( "Inserisci docenti" );
    echo "<script src='scripts/script.js'></script>";
    import("../../../../");
    $conn = dbConnection("../../../../");
    
?>
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
            if ($("#UsernameDocente").val().isEmpty() || $("#PasswordDocente").val().isEmpty() || $("#ConfermaPasswordDocente").val().isEmpty() || $("#NomeDocente").val().isEmpty()
                    || $("#CognomeDocente").val().isEmpty() || $("#userexists").val() === "1" || $("#passworderror").val() === "1")
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
                    <h1>Inserimento docenti</h1>
                    <br>
                    <div class="row">
                        <form class="form-vertical">
                            <div class="col col-sm-6">
                                <b id="usr">Username*</b> 
                                <div class="form-group has-error has-feedback" id="usernameregulator"> 
                                    <input class="form-control" id="UsernameDocente"> 
                                    <span class="glyphicon glyphicon-remove form-control-feedback" id="usernamespanregulator"></span> 
                                </div>
                                <b id="psw">Password (minimo 8 caratteri)*</b> 
                                <div class="form-group has-error has-feedback" id="passwordregulator"> 
                                    <input type="password" class="form-control" id="PasswordDocente"> 
                                    <span class="glyphicon glyphicon-remove form-control-feedback" id="passwordspanregulator"></span> 
                                </div>
                                <b>Conferma Password*</b> <div class="form-group"> <input type="password" class="form-control" id="ConfermaPasswordDocente"> </div>
                                <b>Nome*</b> <div class="form-group"> <input class="form-control" id="NomeDocente"> </div>
                                <b>Cognome*</b> <div class="form-group"> <input class="form-control" id="CognomeDocente"> </div>
                                <b>Telefono</b> <div class="form-group"> <input class="form-control" id="TelefonoDocente"> </div> 
                                <b>E-mail</b> <div class="form-group"> <input class="form-control" id="EmailDocente"> </div>                       
                                <br>
                                * Campo Obbligatorio
                                <br>
                                <br>                              
                                <input type="button" class="btn btn-primary" value="Invia" onclick="send();">     
                            </div>
                            <div class="col col-sm-6">
                                <div align="center">
                                    <label><input  type="checkbox" id="isDocenteReferente">  Inserisci come docente referente</label>
                                </div>                                
                            </div>
                        </form>       
                    </div>
                </div>
                <div class="panel">
                    <div class="row">
                        <div class="col col-sm-12">
                            <div class="row">
                                <div class="col col-sm-6">
                                    <form onsubmit="setUserToAdd();" enctype="multipart/form-data" method="POST" action="docsloader.php" name="uploadform">
                                        Seleziona il file contenente i docenti da caricare:
                                        <br>
                                        <br>
                                        <input type="file" class="filestyle" data-buttonName="btn-primary" data-placeholder="File non inserito" name="docsfile">
                                        <input type="hidden" name="tipo_docente" value="">
                                        <br>
                                        <input type="submit" class="btn btn-primary" value="invia" name="invio">
                                        <div align="right">
                                            <u><a style="color: #828282" href="Stage_Manager_Modulo_Docenti.xlsx" download>Scarica modello per i docenti</a></u>
                                        </div>
                                    </form>
                                </div>
                                <div class="col col-sm-6">
                                    <div class="list-group">
                                        <a href="javascript:handleTypes('docstutor')" id='docstutor' class="list-group-item active">Docenti Tutor</a>
                                        <a href="javascript:handleTypes('docsref')" id='docsref' class="list-group-item">Docenti Referenti</a>
                                    </div>
                                </div>
                            </div>                        
                        </div>                    
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function (){
            $(".buttonText").html("        Sfoglia");
            $(".icon-span-filestyle").remove();
        });
        $("#UsernameDocente").on('input',function (){
            $.ajax({
                type : 'POST',
                url : 'ajaxOps/ajaxCheckUserExistence.php',
                data : {'user' : $("#UsernameDocente").val()},
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
                        if ($("#UsernameDocente").val().isEmpty())
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
            if ($("#PasswordDocente").val() !== $("#ConfermaPasswordDocente").val() || $("#PasswordDocente").val().length < 8)
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
</body>
<?php
    close_html ("../../../../");
?>