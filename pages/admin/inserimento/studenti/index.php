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
                        
                        <div class="col col-sm-6">
                            <b id="usr">Username*</b> <div name="paddedDiv"> <input class="form-control" id="usernameStudente"> </div>
                            <b id="psw">Password*</b> <div name="paddedDiv"> <input class="form-control" type="password" id="passwordStudente"> </div>
                            <b>Conferma Password*</b> <div name="paddedDiv"> <input class="form-control" type="password" id="confermaPasswordStudente"> </div>
                            <b>Nome*</b> <div name="paddedDiv"> <input class="form-control" id="nomeStudente"> </div>
                            <b>Cognome*</b> <div name="paddedDiv"> <input class="form-control" id="cognomeStudente"> </div>
                            <b>Citta*</b> <div name="paddedDiv"> <input class="form-control" id="cittaStudente"> </div>
                            <b>Mail*</b> <div name="paddedDiv"> <input class="form-control" id="mailStudente"> </div>
                            <b>Telefono*</b> <div name="paddedDiv"> <input class="form-control" type="number" min="1" id="telefonoStudente"> </div>
                            <br>
                            * Campo Obbligatorio
                            <br>
                            <br>
                            <input class="btn btn-primary" value="Invia" onclick="sendSingleData('studente');">
                                
                                
                        </div>
                        
                        <div class="col col-sm-6">
                            
                            Inizio Stage <div name="paddedDiv"> <input class="form-control" data-provide="datepicker" id="inizioStageStudente"> </div>
                            Durata Stage <div name="paddedDiv"> <input class="form-control" type="number" min="1" id="durataStageStudente"> </div>
                            <b>Classe* </b> <div name="paddedDiv"><select class="form-control"  id="classeStudente" onclick="addSelectionsFor('studente','classe')">  </select> </div>
                            Azienda <div name="paddedDiv"><select class="form-control"  id="aziendaStudente" onclick="addSelectionsFor('studente','azienda')"> </select>  </div>
                            Docente <div name="paddedDiv"><select class="form-control"  id="docenteStudente" onclick="addSelectionsFor('studente','docente')"> </select> </div>
                            Tutor <div name="paddedDiv"><select class="form-control"  id="tutorStudente" style="color:#D3D3D3"> <option> selezionare una azienda.... </option> </select> </div>
<!--                            Durata Stage <input class="form-control" type="number" min="1" id="duarataStageStudente">
                            Durata Stage <input class="form-control" type="number" min="1" id="duarataStageStudente">-->
                            <select id="keepIdAzienda" style="visibility: hidden"></select><br>
                                
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
                                        $tmp_path = $_SERVER ['DOCUMENT_ROOT'] . prj_pages . "/admin/inserimento/studenti/tmp/"; // Percorso dove verra' inviato il file uploadato
                                        if (move_uploaded_file ( $_FILES ['file1'] ['tmp_name'], $tmp_path . $fileName)) {  //il file viene spostato nella nuova cartella temporaneamente
                                            echo 'Nome file: <b>' . $fileName . '</b><br>';
                                            echo 'MIME Type: <b>' . $fileType . '</b><br>';
                                            echo 'Dimensione: <b>' . $fileSize . '</b> byte<br>';
                                            echo '======================<br>';
                                            echo 'File caricato correttamente<br><br>';
                                                
                                            $registerFileName = $tmp_path . "registroStudenti.txt";
                                            $registerFile = fopen ( $registerFileName, "a" );   //viene creato un file di registro dove vengono memorizzate le info che
                                                                                                //verranno anche inserite nel database. Se le password vengono inviate
                                                                                                //direttamente agli utenti via mail, valutare se necessario
                                            $uploadedFileName = $tmp_path . $fileName;
                                            $uploadedFile = @file ( $uploadedFileName );
                                                
                                            $connessione = dbConnection("../../../../");
                                            if ($uploadedFile != false) {
                                                foreach ( $uploadedFile as $line ) {
                                                    $explodedLine = explode ( ",", $line );
                                                        
                                                    $cognome = $explodedLine [0];
                                                    $nome = $explodedLine [1];
                                                    $cognome = str_replace ( '"', '', $cognome );
                                                    $nome = str_replace ( '"', '', $nome );
                                                        
                                                    $username = $cognome . "." . $nome;
                                                    $username = str_replace ( ' ', '', $username );
                                                        
                                                    $query = "SELECT * FROM `alternanza_scuola_lavoro`.`studente` WHERE username LIKE '$username%'";
                                                    $result = $connessione->query ( $query );
                                                    $NumRighe = mysqli_num_rows ( $result );
                                                    $NumRighe ++;
                                                    if ($NumRighe > 1){ //per evitare che si inseriscano utenti con lo stesso username
                                                        $username = $username . $NumRighe;
                                                    }
                                                        
                                                    $passwordLength = 8;    //per evitare password troppo lunghe
                                                    $possibleChars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; // generazione Password 8 caratteri random
                                                    $i = 0;
                                                    $password = "";                                                        
                                                    while ( $i < $passwordLength ) {    //generazione casuale delle password
                                                        $char = substr ( $possibleChars, mt_rand ( 0, strlen ( $possibleChars ) - 1 ), 1 );
                                                        if (! strstr ( $password, $char )) {
                                                            $password .= $char;
                                                            $i ++;
                                                        }
                                                    }
                                                        
                                                    $citta = $explodedLine [2];
                                                    $citta = str_replace ( '"', '', $citta );
                                                    $email = $explodedLine [3];
                                                    $email = str_replace ( '"', '', $email );
                                                    $telefono = $explodedLine [4];
                                                    $telefono = str_replace ( '"', '', $telefono );
                                                    $classe = $explodedLine [5];
                                                    $classe = str_replace ( '"', '', $classe );
                                                    fputs ( $registerFile, $username . ";" . $password . ";" . $nome . ";" . $cognome. ";" . $email . ";\n" ); //compilazione del file di registro
                                                    $password = MD5 ( $password );
                                                        
                                                    $query = "INSERT INTO `alternanza_scuola_lavoro`.`studente` (`id_studente`, `username`, `password`, `nome`, `cognome`, `citta`, `email`, `telefono`, `inizio_stage`,  `durata_stage`, `visita_azienda`, `classe_id_classe`,  `azienda_id_azienda`, `docente_id_docente`, `tutor_id_tutor`, `valutazione_studente_id_valutazione_studente`, `valutazione_stage_id_valutazione_stage`) VALUES (NULL, '$username', '$password', '$nome', '$cognome', '$citta', '$email' , '$telefono', NULL, NULL, '0', '$classe', NULL, NULL,  NULL, NULL, NULL)";
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
                            <form enctype="multipart/form-data" method="post" action="studentloader.php" name="uploadform">
                                Seleziona il file contenente gli studenti da caricare:
                                <br>
                                <br>
                                <input type="file" class="filestyle" data-buttonName="btn-primary" data-placeholder="File non inserito" name="studentfile">
                                <br>
                                <input type="submit" class="btn btn-primary" value="invia" name="invio">
                            </form>
                            <?php
                                }
                            ?>
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
                                            }
                                            else
                                            {
                                                $("#userexists").val("0");
                                                $("#usr").html("Username*");
                                                $("#usr").css("color","#828282");
                                            }
                                        }
                                    });
                                });
                                
                                var checkpw = setInterval(function (){
                                    if ($("#passwordStudente").val() !== $("#confermaPasswordStudente").val() || $("#passwordStudente").val().length < 8)
                                    {
                                        //alert($("#passwordTutor").val() + " " + $("#confermaPasswordTutor").val());
                                        $("#psw").html("Password (Minimo 8 caratteri)* troppo corta o non coincide con la conferma");
                                        $("#psw").css("color","red");
                                    }
                                    else
                                    {
                                        $("#psw").css("color","#828282"); 
                                        $("#psw").html("Password (Minimo 8 caratteri)*");
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