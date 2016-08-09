<?php
    include '../../../functions.php';
    checkLogin ( adminType , "../../../../");
    open_html ( "Inserisci aziende" );
    import("../../../../");
    echo "<script src='../js/scripts.js'></script>";
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
            if ($("#UsernameAzienda").val().isEmpty() || $("#PasswordAzienda").val().isEmpty() || $("#ConfermaPasswordAzienda").val().isEmpty() || $("#NomeAzienda").val().isEmpty()
                    || $("#CittaAzienda").val().isEmpty() || $("#CAPAzienda").val().isEmpty() || $("#IndirizzoAzienda").val().isEmpty() || $("#userexists").val() === "1")
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
                    <h1>Inserimento aziende</h1>
                    <br>
                    <div class="row">
                        <div class="col col-sm-6">
                            <b id="usr">Username*</b> <div name="paddedDiv"> <input class="form-control" id="UsernameAzienda"> </div> 
                            <b id="psw">Password (minimo 8 caratteri)*</b> <div name="paddedDiv"> <input type="password" class="form-control" id="PasswordAzienda"></div> 
                            <b>Conferma Password*</b><div name="paddedDiv"> <input type="password" class="form-control" id="ConfermaPasswordAzienda"></div> 
                            <b>Nome Azienda*</b> <div name="paddedDiv"><input class="form-control" id="NomeAzienda"></div> 
                            <b>Citta'*</b><div name="paddedDiv"> <input class="form-control" id="CittaAzienda"></div> 
                            <b>CAP*</b><div name="paddedDiv"> <input type="number" min="1" class="form-control" id="CAPAzienda"></div> 
                            <b>Indirizzo*</b><div name="paddedDiv"> <input class="form-control" id="IndirizzoAzienda"></div> 
                            <br>
                            * Campo Obbligatorio
                            <br>
                            <br>
                            <input class="btn btn-primary" value="Invia" onclick="sendSingleData('azienda');">                             
                                 
                        </div>
                        <div class="col col-sm-6">
                            Telefono <div name="paddedDiv"><input class="form-control" id="TelefonoAzienda"> </div>
                            Indirizzo E-Mail <div name="paddedDiv"><input class="form-control" id="MailAzienda"> </div>
                            Sito <div name="paddedDiv"><input class="form-control" id="SitoAzienda"> </div> 
                            Nome Responsabile <div name="paddedDiv"><input class="form-control" id="NomeResponsabileAzienda"> </div> 
                            Cognome Responsabile <div name="paddedDiv"><input class="form-control" id=CognomeResponsabileAzienda"> </div> 
                            Telefono Responsabile <div name="paddedDiv"> <input class="form-control" id="TelefonoResponsabileAzienda"> </div> 
                            Indirizzo E-Mail Responsabile <div name="paddedDiv"> <input class="form-control" id="MailResponsabileAzienda"> </div>
                                
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
                                        $tmp_path = $_SERVER ['DOCUMENT_ROOT'] . prj_pages . "/admin/inserimento/aziende/tmp/"; // Percorso dove verra' inviato il file uploadato
                                        if (move_uploaded_file ( $_FILES ['file1'] ['tmp_name'], $tmp_path . $fileName)) {  //il file viene spostato nella nuova cartella temporaneamente
                                            echo 'Nome file: <b>' . $fileName . '</b><br>';
                                            echo 'MIME Type: <b>' . $fileType . '</b><br>';
                                            echo 'Dimensione: <b>' . $fileSize . '</b> byte<br>';
                                            echo '======================<br>';
                                            echo 'File caricato correttamente<br><br>';
                                                
                                            $registerFileName = $tmp_path . "registroAziende.txt";
                                            $registerFile = fopen ( $registerFileName, "a" );   //viene creato un file di registro dove vengono memorizzate le info che 
                                                                                                //verranno anche inserite nel database. Se le password vengono inviate
                                                                                                //direttamente agli utenti via mail, valutare se necessario
                                                                                                    
                                            $uploadedFileName = $tmp_path . $fileName;
                                            $uploadedFile = @file ( $uploadedFileName );
                                                
                                            $connessione = dbConnection("../../../../");
                                            if ($uploadedFile != false) {
                                                foreach ( $uploadedFile as $line ) {
                                                    $explodedLine = explode ( ",", $line );
                                                        
                                                    $nome_aziendale = $explodedLine [0];
                                                    $nome_aziendale = str_replace ( '"', '', $nome_aziendale );
                                                        
                                                    $usernameLength = 8;    //per evitare username troppo lunghi
                                                    $username = str_replace ( ' ', '', $nome_aziendale );
                                                    $username = substr ($username, 0, $usernameLength );
                                                        
                                                    $query = "SELECT * FROM `alternanza_scuola_lavoro`.`azienda` WHERE username LIKE '$username%'";
                                                    $result = $connessione->query ( $query );
                                                    $NumRighe = mysqli_num_rows ( $result );
                                                    $NumRighe++;
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
                                                        
                                                    $citta_aziendale = $explodedLine [1];
                                                    $CAP = $explodedLine [2];
                                                    $indirizzo = $explodedLine [3];
                                                    $telefono = $explodedLine [4];
                                                    $email_aziendale = $explodedLine [5];
                                                    $sito = $explodedLine [6];
                                                    $specializzazione = $explodedLine [7];
                                                        
                                                    $citta_aziendale = str_replace ( '"', '', $citta_aziendale );
                                                    $CAP = str_replace ( '"', '', $CAP );
                                                    $indirizzo = str_replace ( '"', '', $indirizzo );
                                                    $telefono = str_replace ( '"', '', $telefono );
                                                    $email_aziendale = str_replace ( '"', '', $email_aziendale );
                                                    $sito = str_replace ( '"', '', $sito );
                                                    $specializzazione = str_replace ( '"', '', $specializzazione );
                                                        
                                                    fputs ( $registerFile, $username . ";" . $password . ";" . $nome_aziendale . ";" . $citta_aziendale . ";" . $CAP . ";" . $indirizzo . ";" . $telefono . ";" . $email_aziendale . ";" . $sito . ";\n" ); //compilazione del file di registro
                                                    $password = MD5 ( $password );
                                                    $query = "INSERT INTO `alternanza_scuola_lavoro`.`azienda` (`id_azienda`, `username`, `password`, `nome_aziendale`,`citta_aziendale`, `CAP`, `indirizzo`, `telefono_aziendale`, `email_aziendale`, `sito_web`, `nome_responsabile`,`cognome_responsabile`,`telefono_responsabile`,`email_responsabile`) VALUES (NULL, '$username', '$password', '$nome_aziendale', '$citta_aziendale', '$CAP', '$indirizzo', '$telefono','$email_aziendale',  '$sito', '',  '',  '',  '')";
                                                    $result = $connessione->query ( $query );
                                                        
                                                    $query = "SELECT MAX(id_azienda) as M FROM azienda";
                                                    $result = $connessione->query ( $query );
                                                    $id = mysqli_fetch_array ( $result );
                                                    $id = $id ['M'];    //ottengo l'id dell'utente appena inserito
                                                    $specializzazione = explode ( "-", $specializzazione );
                                                    foreach ( $specializzazione as $line ) {    //vado a inserire l'associazione fra specializzazione e azienda nel db
                                                        $line = str_replace ( '"', '', $line );
                                                        $query = "INSERT INTO `alternanza_scuola_lavoro`.`azienda_has_specializzazione` (`id_azienda_has_specializzazione`, `azienda_id_azienda`, `specializzazione_id_specializzazione`) VALUES (NULL, '$id', '$line')";
                                                        $result = $connessione->query ( $query );
                                                    }
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
                                Seleziona il file contenente le aziende da caricare:
                                <br>
                                <br>
                                <input type="file" class="filestyle" data-buttonName="btn-primary" data-placeholder="File non inserito" name="file1">
                                <br>
                                <input type="submit" class="btn btn-primary" value="invia" name="invio">
                                    
                            </form>
                                
  							<?php
                                }
                            ?>
                            <script>
                                $("#UsernameAzienda").on('input',function (){
                                    $.ajax({
                                        type : 'POST',
                                        url : '../ajaxOps/ajaxCheckUserExistence.php',
                                        data : {'user' : $("#UsernameAzienda").val()},
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
                                    if ($("#PasswordAzienda").val() !== $("#ConfermaPasswordAzienda").val() || $("#PasswordAzienda").val().length < 8)
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