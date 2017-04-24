<?php
    include '../../../functions.php';
    checkLogin ( superUserType , "../../../../");
    open_html ( "Inserisci scuole" );
    echo "<script src='../js/scripts.js?1'></script>";
    import("../../../../");
?>
    
<script>
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };  
    
    $(document).ready(function (){
        $("#usernameScuola").keypress(function (e){
            if (e.which === 32) return false;
        });
    });
    
    var check = setInterval(function(){
        if ($("#usernameScuola").val().isEmpty() || $("#passwordScuola").val().isEmpty() || $("#confermapasswordScuola").val().isEmpty() || $("#nomeScuola").val().isEmpty() || $("#userexists").val() === "1" || 
                $("#passworderror").val() === "1")
        {
            $("input[value=\"Invia\"]").prop("disabled",true);
        }
        else
        {
            $("input[value=\"Invia\"]").prop("disabled",false);
        }
    },1);
    
    
</script>
<body>
    <?php
        topNavbar ("../../../../");
        titleImg ("../../../../");
    ?>
    <input type="hidden" id="userexists" value="0">
    <input type="hidden" id="passworderror" value="0">
    <link rel="stylesheet" href="../InsertStyle.css">
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                
                <div class="panel">
                    <h1>Inserimento Scuole</h1>
                    <br>
                    <div class="row">
                        <form class="form-vertical">
                            <div class="col col-sm-6">
                                
                                <b id='usr'>Username*</b> 
                                <div class="form-group">
                                    <div class="form-group has-error has-feedback" id="usernameregulator"> 
                                        <input class="form-control" id="usernameScuola"> 
                                        <span class="glyphicon glyphicon-remove form-control-feedback" id="usernamespanregulator"></span> 
                                    </div>
                                </div>
                                <b id='psw'>Password (minimo 8 caratteri)*</b> 
                                <div class="form-group">
                                    <div class="form-group has-error has-feedback" id="passwordregulator"> 
                                        <input  type="password" class="form-control" id="passwordScuola"> 
                                        <span class="glyphicon glyphicon-remove form-control-feedback" id="passwordspanregulator"></span>                                         
                                    </div>
                                </div>
                                <b>Conferma Password*</b> <div class="form-group"> <input  type="password" class="form-control" id="confermapasswordScuola"> </div>
                                    
                                Telefono<div class="form-group"> <input class="form-control" id="telefonoScuola"> </div>
                                Email<div class="form-group"> <input class="form-control" id="emailScuola"> </div>
                                Sito Web<div class="form-group"> <input class="form-control" id="sitoScuola"> </div>
                                <br>
                                * Campo Obbligatorio                                
                                <br>
                                <br>
                                <input type="button" class="btn btn-primary" value="Invia" onclick="sendSingleData('scuola')"> 
                            </div>
                            <div class="col col-sm-6">
                                <b>Nome*</b> <div class="form-group"> <input class="form-control" id="nomeScuola"> </div>
                                Citta'<div class="form-group"> <input class="form-control" id="cittaScuola"> </div>
                                CAP<div class="form-group"> <input type="number" min='1' class="form-control" id="CAPScuola"> </div>
                                Indirizzo<div class="form-group"> <input class="form-control" id="indirizzoScuola"> </div>
                                    
                            </div>                           
                        </form>
                            
                    </div>
                </div>
            </div>
        </div>
    </div>
        
    <script>
        $("#usernameScuola").on('input',function (){
            $.ajax({
                type : 'POST',
                url : '../ajaxOps/ajaxCheckUserExistence.php',
                data : {'user' : $("#usernameScuola").val()},
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
                        if ($("#usernameScuola").val().isEmpty())
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
        
        function checkPasswordScuola()
        {
            if ($("#passwordScuola").val() !== $("#confermapasswordScuola").val() || $("#passwordScuola").val().length < 8)
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
        }
        
        $("#passwordScuola").on("input", checkPasswordScuola);
        $("#confermapasswordScuola", checkPasswordScuola);
    </script>
</body>
<?php
    close_html ("../../../../");
?>