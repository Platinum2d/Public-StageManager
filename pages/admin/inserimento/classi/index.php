<?php
    include '../../../functions.php';
    checkLogin ( superUserType , "../../../../");
    open_html ( "Inserisci classi" );
    echo "<script src='../js/scripts.js'></script>";
    import("../../../../");
?>
    
<script>
    
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };      
    
    var check = setInterval(function(){
        if ($("#nomeClasse").val().isEmpty())
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
                    <h1>Inserimento classi</h1>
                    <br>
                    <div class="row">
                        <form class="form-vertical">
                            <div class="col col-sm-6">
                                <b>Nome della classe*</b> <div class="form-group"> <input class="form-control" id="nomeClasse"> </div>       
                                <!--Periodo di stage<div class="form-group"> <select class="form-control" id="stageClasse"> <option value="-1"> </option> </select></div>-->
                            </div>
                            
                            <div class="col col-sm-6">
                                <b> Scuola* </b> <div class="form-group"> <select class="form-control" id="scuolaClasse"></select></div>
                                <b> Settore di appartenenza* </b> <div class="form-group"> <select class="form-control" id="settoreClasse"></select></div>
                                <!--<b> Anno Scolastico* </b> <div class="form-group"> <select class="form-control" id="annoscolasticoClasse"></select></div>-->                                
                            </div>
                        </form>                        
                    </div>
                    * Campo Obbligatorio <br><br>
                    <input class="btn btn-primary" value="Invia" onclick="sendSingleData('classe');">
                </div>
                
                <div class="panel">
                    <div class="row">
                            <div class="col-sm-6">
                            
                            <form enctype="multipart/form-data" method="post" action="classesloader.php" name="uploadform">
                                Seleziona il file contenente le classi da caricare:
                                <br>
                                <br>
                                <input type="file" class="filestyle" data-buttonName="btn-primary" data-placeholder="File non inserito" name="classesfile">
                                <br>
                                <input type="submit" class="btn btn-primary" value="invia" name="invio">
                                    
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        addSelectionsFor("classe","scuola");
        addSelectionsFor("classe","settore");
//        addSelectionsFor("classe","anno_scolastico");        
//        addSelectionsFor("classe","stage");
    </script>
</body>
<?php
    close_html ();
?>