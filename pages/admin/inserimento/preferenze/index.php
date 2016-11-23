<?php
    include '../../../functions.php';
    checkLogin ( superUserType , "../../../../");
    open_html ( "Inserisci preferenze" );
    echo "<script src='../js/scripts.js'></script>";
    import("../../../../");
?>
<body>
    <?php
        topNavbar ("../../../../");
        titleImg ("../../../../");
    ?>
    <link rel="stylesheet" href="../InsertStyle.css">
    
    <script> 
        String.prototype.isEmpty = function() {
            return (this.length === 0 || !this.trim());
        };      
        
        var check = setInterval(function(){
            if ($("#nomepreferenza").val().isEmpty() || $("#alreadyexists").val() === "1")
            {
                $("input[value=\"Invia\"]").prop("disabled",true);
            }
            else
            {
                $("input[value=\"Invia\"]").prop("disabled",false);
            }
        },1);
    </script>
    
    <input type="hidden" value="0" id="alreadyexists">
    
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">       
                    <h1>Inserimento preferenze</h1>
                    <br>
                    <div class="row">
                        <form class="form-vertical">
                            <div class="col col-sm-6">
                                <b id="pr">Nome della preferenza*</b> <div class="form-group"> <input class="form-control" id="nomepreferenza">  </div>
                                <br>
                                <b>* Campo Obbligatorio</b>
                                <br>
                                <br>
                                <input class="btn btn-primary" value="Invia" onclick="sendSingleData('preferenza');">
                            </div>
                        </form>
                    </div>
                    
                </div>
                    <div class="panel">
                        
                    <form enctype="multipart/form-data" method="post" action="prefloader.php" name="uploadform">
                        Seleziona il file contenente le specializzazioni da caricare:
                        <br>
                        <br>
                        <input type="file" class="filestyle" data-buttonName="btn-primary" data-placeholder="File non inserito" name="preffile">
                        <br>
                        <input type="submit" class="btn btn-primary" value="invia" name="invio">
                    </form>
                </div>
            </div>
        </div>
    </div>
        
    <script>
        $("#nomepreferenza").on("input", function (){
            //alert();
            $.ajax({
                type : 'POST',
                url : "ajaxOpsPerPreferenza/ajaxCheckPreferenceExistence.php",
                data : {'nome' : $("#nomepreferenza").val()},
                success : function (msg)
                {
                    if (msg === "esiste")
                    {
                        $("#pr").css("color","red");
                        $("#pr").html("Nome della preferenza* (già esistente)");
                        $("#alreadyexists").val("1");
                    }
                    else
                    {
                        $("#pr").css("color","#555");
                        $("#pr").html("Nome della preferenza*");
                        $("#alreadyexists").val("0");
                    }
                }
            })
        });
    </script>
</body>
<?php
    close_html ("../../../../");
?>