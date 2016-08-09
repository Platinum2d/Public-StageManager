<?php
    include "../../functions.php";
    checkLogin ( ceoType , "../../../");
    open_html ( "Inserisci tutor" );
    import("../../../");
    echo "<script src='../inserisci_tutor/js/scripts.js'></script>";
?>
<body>
    <input type="hidden" id="alreadyexists" value="0">
    <?php
        topNavbar ("../../../");
        titleImg ("../../../");
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Inserimento tutor</h1>
                    <br>
                    <div class="row">
                        <div class="col col-sm-6">
                            <b id="usr">Username*</b> <input class="form-control" id="usernameCeo">
                            <b>Password (Minimo 8 caratteri)*</b> <input type="password" class="form-control" id="passwordCeo">
                            <b>Conferma Password*</b> <input type="password" class="form-control" id="confermaPasswordCeo">
                            <b>Nome*</b> <input class="form-control" id="nomeCeo">
                            <b>Cognome*</b> <input class="form-control" id="cognomeCeo">
                            <b>Telefono*</b> <input class="form-control" id="telefonoCeo">
                            <b>Email*</b> <input class="form-control" id="emailCeo">
                            <br>
                            * Campo Obbligatorio
                            <br>
                            <br>
                            <br>
                            <input class="btn btn-primary" value="Invia" onclick="sendSingleData('ceo');"> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        String.prototype.isEmpty = function() {
            return (this.length === 0 || !this.trim());
        }; 
        
        var check = setInterval(function (){
            if ($("#alreadyexists").val() === "1" || $("#usernameCeo").val().isEmpty() || $("#passwordCeo").val().isEmpty() || $("#confermaPasswordCeo").val().isEmpty() || $("#nomeCeo").val().isEmpty()
                    || $("#cognomeCeo").val().isEmpty() || $("#telefonoCeo").val().isEmpty() || $("#emailCeo").val().isEmpty() || $("#confermaPasswordCeo").val() !== $("#passwordCeo").val() || $("#passwordCeo").val().length < 8)
            {
                $("input[value=\"Invia\"]").prop("disabled",true);
            }
            else
            {
                $("input[value=\"Invia\"]").prop("disabled",false);
            }
        },1);
        
        $("#usernameCeo").on("input",function (){
            $.ajax({
                type : 'POST',
                url : 'ajaxOps/ajaxCheckUserExistence.php',
                data : { 'user' : $("#usernameCeo").val() },
                cache : false,
                success : function (msg){
                    if (msg === "trovato")
                    {
                        $("#usr").css("color","red");
                        $("#usr").html("Username (gia' in uso)*");
                        $("#alreadyexists").val("1");
                    }
                    else
                    {
                        $("#usr").css("color","#555");
                        $("#usr").html("Username*");                     
                        $("#alreadyexists").val("0");
                    }
                }
            })
        });
    </script>
</body>
<?php
    close_html ();
?>