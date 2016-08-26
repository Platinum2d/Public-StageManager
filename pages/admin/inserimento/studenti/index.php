<?php
    include '../../../functions.php';
    checkLogin ( adminType , "../../../../");
    open_html ( "Inserisci studenti" );
    echo "<script src='../js/scripts.js'></script>";
    import("../../../../");
?>
<script>
    addSelectionsFor('studente','classe');
    addSelectionsFor('studente','azienda');
    addSelectionsFor('studente','docente');
</script>

<body>
    <?php
        topNavbar ("../../../../");
        titleImg ("../../../../");
        printChat("../../../../");
    ?>
    <link rel="stylesheet" href="../InsertStyle.css">
    
    <script> 
        String.prototype.isEmpty = function() {
            return (this.length === 0 || !this.trim());
        };      
        
        var check = setInterval(function(){
            if ($("#usernameStudente").val().isEmpty() || $("#passwordStudente").val().isEmpty() || $("#confermaPasswordStudente").val().isEmpty() || $("#nomeStudente").val().isEmpty()
                    || $("#cognomeStudente").val().isEmpty() || $("#cittaStudente").val().isEmpty() || $("#mailStudente").val().isEmpty() || $("#telefonoStudente").val().isEmpty() 
                    || $("#classeStudente").val().isEmpty() || $("#userexists").val() === "1")
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
                                <b>Citta*</b> <div class="form-group"> <input class="form-control" id="cittaStudente"> </div>
                                <b>Mail*</b> <div class="form-group"> <input class="form-control" id="mailStudente"> </div>
                                <b>Telefono*</b> <div class="form-group"> <input class="form-control" type="number" min="1" id="telefonoStudente"> </div>
                                <br>
                                * Campo Obbligatorio
                                <br>
                                <br>
                                <input class="btn btn-primary" value="Invia" onclick="sendSingleData('studente');">
                                    
                                    
                            </div>
                                
                            <div class="col col-sm-6">
                                
                                Inizio Stage <div class="form-group"> <input class="form-control" data-provide="datepicker" id="inizioStageStudente"> </div>
                                Durata Stage <div class="form-group"> <input class="form-control" type="number" min="1" id="durataStageStudente"> </div>
                                <b>Classe* </b> <div class="form-group"><select class="form-control"  id="classeStudente" onclick="addSelectionsFor('studente','classe')">  </select> </div>
                                Azienda <div class="form-group"><select class="form-control"  id="aziendaStudente" onclick="addSelectionsFor('studente','azienda')"> </select>  </div>
                                Docente <div class="form-group"><select class="form-control"  id="docenteStudente" onclick="addSelectionsFor('studente','docente')"> </select> </div>
                                Tutor <div class="form-group"><select class="form-control"  id="tutorStudente" style="color:#D3D3D3"> <option> selezionare una azienda.... </option> </select> </div>
    <!--                            Durata Stage <input class="form-control" type="number" min="1" id="duarataStageStudente">
                                Durata Stage <input class="form-control" type="number" min="1" id="duarataStageStudente">-->
                                <select id="keepIdAzienda" style="visibility: hidden"></select><br>
                                    
                            </div>
                        </form>
                    </div>
                </div>
                    
                <div class="panel">
                    <div class="row">
                        <div class="col-sm-6">
                            <form enctype="multipart/form-data" method="post" action="studentloader.php" name="uploadform">
                                Seleziona il file contenente gli studenti da caricare:
                                <br>
                                <br>
                                <input type="file" class="filestyle" data-buttonName="btn-primary" data-placeholder="File non inserito" name="studentfile">
                                <br>
                                <input type="submit" class="btn btn-primary" value="invia" name="invio">
                            </form>
                            <script>
                                $("#usernameStudente").on('input',function (){
                                    $.ajax({
                                        type : 'POST',
                                        url : '../ajaxOps/ajaxCheckUserExistence.php',
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
                                        //alert($("#passwordTutor").val() + " " + $("#confermaPasswordTutor").val());
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
    close_html ();
?>