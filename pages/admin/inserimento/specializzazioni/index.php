<?php
    include '../../../functions.php';
    checkLogin ( superUserType , "../../../../");
    open_html ( "Inserisci specializzazioni" );
    echo "<script src='../js/scripts.js'></script>";
    import("../../../../");
?>
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
            if ($("#nomespecializzazione").val().isEmpty())
            {
                $("input[value=\"Invia\"]").prop("disabled",true);
            }
            else
            {
                $("input[value=\"Invia\"]").prop("disabled",false);
            }
        },1);
    </script>
        
    <div class="container">
        <div class="row">
            <form class="form-vertical">
                <div class="col col-sm-12">
                    <div class="panel">       
                        <h1>Inserimento specializzazioni</h1>
                        <br>
                        <div class="row">
                            <div class="col col-sm-6">
                                <b>Nome della specializzazione*</b> <div class="form-group">  <input class="form-control" id="nomespecializzazione">  </div>
                                <br>
                                * Campo Obbligatorio
                                <br>
                                <br>
                                <input class="btn btn-primary" value="Invia" onclick="sendSingleData('specializzazione');">
                            </div>
                        </div>
                        
                    </div>
                    
                    <div class="panel">
                        <div class="row">
                                <div class="col-sm-6">
                            
                                <form enctype="multipart/form-data" method="post" action="specloader.php" name="uploadform">
                                    Seleziona il file contenente le specializzazioni da caricare:
                                    <br>
                                    <br>
                                    <input type="file" class="filestyle" data-buttonName="btn-primary" data-placeholder="File non inserito" name="specfile">
                                    <br>
                                    <input type="submit" class="btn btn-primary" value="invia" name="invio">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>
<?php
    close_html ();
?>