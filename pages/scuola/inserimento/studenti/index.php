<?php
    include '../../../functions.php';
    checkLogin ( scuolaType , "../../../../");
    open_html ( "Inserisci studenti" );
    echo "<script src='scripts/script.js'></script>";
    import("../../../../");
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
        
    <script> 
        String.prototype.isEmpty = function() {
            return (this.length === 0 || !this.trim());
        };      
        
        var check = setInterval(function(){
            if ($("#usernameStudente").val().isEmpty() || $("#passwordStudente").val().isEmpty() || $("#confermaPasswordStudente").val().isEmpty() || $("#nomeStudente").val().isEmpty()
                    || $("#cognomeStudente").val().isEmpty() || $("#classeStudente").val().isEmpty() || $("#annoclasseStudente").val().isEmpty() || $("#userexists").val() === "1" || $("#passworderror").val() === "1")
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
                                <b>Anno Scolastico* </b> <div class="form-group"><select class="form-control"  id="annoclasseStudente">  </select> </div>
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
                                    <b>Anno Scolastico* </b> <div class="form-group"><select class="form-control"  id="annoclasseStudenteForm">  </select> </div>
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
        
        $("#usernameStudente").on('input',function (){
            $.ajax({
                type : 'POST',
                url : 'ajaxOpsPerStudente/ajaxCheckUserExistence.php',
                data : {'user' : $("#usernameStudente").val()},
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
                        if ($("#usernameStudente").val().isEmpty())
                        {
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
            if ($("#passwordStudente").val() !== $("#confermaPasswordStudente").val() || $("#passwordStudente").val().length < 8)
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