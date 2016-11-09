<?php
    include '../../../functions.php';
    checkLogin ( superUserType , "../../../../");
    open_html ( "Inserisci anni scolastici" );
    echo "<script src='../js/scripts.js'></script>";
    import("../../../../");
?>
    
<script>
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };      
    
    var check = setInterval(function(){
        if ($("#nomeAnno").val().isEmpty())
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
    <link rel="stylesheet" href="../InsertStyle.css">
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                
                <div class="panel">
                    <h1>Inserimento anni scolastici</h1>
                    <br>
                    <div class="row">
                        <form class="form-vertical">
                            <div class="col col-sm-6">
                                <b>Nome dell'anno scolastico*</b> <div class="form-group"> <input class="form-control" id="nomeAnno"> </div>                           
                                <br>
                                * Campo Obbligatorio
                                <br>
                                <br>
                                <input class="btn btn-primary" value="Invia" onclick="sendSingleData('annoscolastico');">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ();
?>