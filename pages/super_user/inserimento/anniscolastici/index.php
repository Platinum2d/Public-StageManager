<?php
    include '../../../functions.php';
    checkLogin ( superUserType , "../../../../");
    open_html ( "Inserisci anni scolastici" );
    echo "<script src='../js/scripts.js?1></script>";
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
<link rel="stylesheet" href="../InsertStyle.css">
<body>
    <?php
        topNavbar ("../../../../");
        titleImg ("../../../../");
    ?>
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
                                <input type="button" class="btn btn-primary" value="Invia" onclick="sendSingleData('annoscolastico');">
                            </div>
                            <div class="col col-sm-6" align="center">
                                <input type="checkbox" id="currentyear" /> Anno Corrente
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ("../../../../");
?>