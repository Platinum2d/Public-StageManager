<?php
    include '../../../functions.php';
    checkLogin ( scuolaType , "../../../../");
    open_html ( "Inserisci stage" );
    echo "<script src='script.js?2'></script>";
    import("../../../../");
?>

<script>
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };      
    
    var check = setInterval(function(){
        if ($("#inizioStage").val().isEmpty() || $("#fineStage").val().isEmpty())
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
                    <h1>Inserimento Periodi di stage</h1>
                    <br>
                    <div class="row">
                        <form class="form-vertical">
                            <div class="col col-sm-6">
                                <b>Inizio Stage*</b> <div class="form-group"> <input data-provide='datepicker' class="form-control" id="inizioStage"> </div>
                                <br>
                                * Campo Obbligatorio
                                <br>
                                <br>
                                <input type="button" class="btn btn-primary" value="Invia" onclick="sendData();">
                            </div>
                            <div class="col col-sm-6"> 
                                <b>Fine Stage*</b> <div class="form-group"> <input data-provide='datepicker' class="form-control" id="fineStage"> </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#inizioStage").datepicker({ dateFormat: 'dd-mm-yy' });
        $("#fineStage").datepicker({ dateFormat: 'dd-mm-yy' });
    </script>
</body>
<?php
    close_html ("../../../../");
?>