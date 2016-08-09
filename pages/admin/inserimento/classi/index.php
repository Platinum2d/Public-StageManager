<?php
    include '../../../functions.php';
    checkLogin ( adminType , "../../../../");
    open_html ( "Inserisci classi" );
    echo "<script src='../js/scripts.js'></script>";
    import("../../../../");
?>

<script>
    addSelectionsFor("classe","specializzazione");
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };      
    
    var check = setInterval(function(){
        if ($("#nomeClasse").val().isEmpty() || $("#SpecializzazioneClasse").val().isEmpty())
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
        printChat("../../../../");
    ?>
    <link rel="stylesheet" href="../InsertStyle.css">
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                
                <div class="panel">
                    <h1>Inserimento classi</h1>
                    <br>
                    <div class="row">
                        <div class="col col-sm-6">
                            <b>Nome della classe*</b> <div name="paddedDiv"> <input class="form-control" id="nomeClasse"> </div>                           
                            <br>
                            * Campo Obbligatorio
                            <br>
                            <br>
                            <input class="btn btn-primary" value="Invia" onclick="sendSingleData('classe');">
                        </div>
                        
                        <div class="col col-sm-6">
                            <b> Specializzazione* </b> <div name="paddedDiv"> <select class="form-control" id="SpecializzazioneClasse" onclick="addSelectionsFor('classe','specializzazione');"></select></div>
                            
                        </div>
                    </div>
                </div>
                    
                <div class="panel">
                    <div class="row">
                        <div class="col-sm-6">
                            							<?php
                                if (isset ( $_POST ["invio"] )) {   //la condizione risulta vera se e' stato inviato un file
                                    if (is_uploaded_file ( $_FILES ['file1'] ['tmp_name'] )) {
                                        $fileName = $_FILES ['file1'] ['name'];
                                        $fileType = $_FILES ['file1'] ['type'];
                                        $fileSize = $_FILES ['file1'] ['size'];
                                        $tmp_path = $_SERVER ['DOCUMENT_ROOT'] . prj_pages . "/admin/inserimento/classi/tmp/"; // Percorso dove verra' inviato il file uploadato
                                        if (move_uploaded_file ( $_FILES ['file1'] ['tmp_name'], $tmp_path . $fileName)) {  //il file viene spostato nella nuova cartella temporaneamente
                                            echo 'Nome file: <b>' . $fileName . '</b><br>';
                                            echo 'MIME Type: <b>' . $fileType . '</b><br>';
                                            echo 'Dimensione: <b>' . $fileSize . '</b> byte<br>';
                                            echo '======================<br>';
                                            echo 'File caricato correttamente<br><br>';
                                                
                                            $uploadedFileName = $tmp_path . $fileName;
                                            $uploadedFile = @file ( $uploadedFileName );
                                                
                                            $connessione = dbConnection("../../../../");
                                            if ($uploadedFile != false) {
                                                foreach ( $uploadedFile as $line ) {
                                                    $explodedLine = explode ( ",", $line );
                                                        
                                                    $nome = $explodedLine[0];
                                                    $specializzazione = isset($explodedLine[1]) ? $explodedLine[1] : null;
                                                    $nome = str_replace ( '"', '', $nome );
                                                    $specializzazione = str_replace ( '"', '', $specializzazione );
                                                        
                                                    $query = "INSERT INTO `alternanza_scuola_lavoro`.`classe` (`id_classe`, `nome`, `specializzazione_id_specializzazione`) VALUES (NULL, '$nome', '$specializzazione')";
                                                    $result = $connessione->query ( $query );
                                                }
                                            }
                                            unlink($uploadedFileName);  //cancello il file uploadato
                                        } else {
                                            echo "Si &egrave verificato un errore durante l'upload: " . $_FILES ["file1"] ["error"];
                                        }
                                    } else {
                                        echo "Si &egrave verificato un errore durante l'upload: " . $_FILES ["file1"] ["error"];
                                    }
                                } else {
                            ?>
                            <form enctype="multipart/form-data" method="post" action="" name="uploadform">
                                Seleziona il file contenente le classi da caricare:
                                <br>
                                <br>
                                <input type="file" class="filestyle" data-buttonName="btn-primary" data-placeholder="File non inserito" name="file1">
                                <br>
                                <input type="submit" class="btn btn-primary" value="invia" name="invio">
                                
                            </form>
                            <?php
                                }
                            ?>
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