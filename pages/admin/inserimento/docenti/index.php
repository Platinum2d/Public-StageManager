<?php
    include '../../../functions.php';
    checkLogin ( adminType , "../../../../");
    open_html ( "Inserisci docenti" );
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
            if ($("#UsernameDocente").val().isEmpty() || $("#PasswordDocente").val().isEmpty() || $("#ConfermaPasswordDocente").val().isEmpty() || $("#NomeDocente").val().isEmpty()
                    || $("#CognomeDocente").val().isEmpty() || $("#TelefonoDocente").val().isEmpty() || $("#EmailDocente").val().isEmpty() || (!$("#isSuperUser").prop("checked") && 
                    !$("#isDocenteTutor").prop("checked") && !$("#isDocenteReferente").prop("checked")) || $("#userexists").val() === "1")
            {
                $("input[value=\"Invia\"]").prop("disabled",true);
            }
            else
            {
                $("input[value=\"Invia\"]").prop("disabled",false);
            }
            
            if ($("#isSuperUser").prop("checked"))
            {
                $("#isDocenteTutor").prop("checked",false);
                $("#isDocenteReferente").prop("checked",false);
            }
        },1);
        

    </script>
    <input type="hidden" id="userexists" value="0">
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Inserimento docenti</h1>
                    <br>
                    <div class="row">
                        <div class="col col-sm-6">
                            <b id="usr">Username*</b> <div name="paddedDiv"> <input class="form-control" id="UsernameDocente"> </div>
                            <b id="psw">Password (minimo 8 caratteri)*</b> <div name="paddedDiv"> <input type="password" class="form-control" id="PasswordDocente"> </div>
                            <b>Conferma Password*</b> <div name="paddedDiv"> <input type="password" class="form-control" id="ConfermaPasswordDocente"> </div>
                            <b>Nome*</b> <div name="paddedDiv"> <input class="form-control" id="NomeDocente"> </div>
                            <b>Cognome*</b> <div name="paddedDiv"> <input class="form-control" id="CognomeDocente"> </div>
                            <b>Telefono*</b> <div name="paddedDiv"> <input class="form-control" id="TelefonoDocente"> </div> 
                            <b>E-Mail*</b> <div name="paddedDiv"> <input class="form-control" id="EmailDocente"> </div>                       
                            <br>
                            * Campo Obbligatorio
                            <br>
                            <br>                              
                            <input class="btn btn-primary" value="Invia" onclick="sendSingleData('docente');">     
                        </div>
                        
                        <br>
                        
                        <div name="paddedDiv">
                            <div class="col col-sm-2">
                                <label><input type="checkbox" id="isSuperUser"> Super User</label> <br>
                            </div>
                            <div class="col col-sm-2">
                                <label><input type="checkbox" id="isDocenteTutor" onchange="uncheckTheOtherCheckBox('docenteTutor')" checked=""> Docente Tutor</label><br>                      
                            </div>
                            <div class="col col-sm-2">
                                <label><input type="checkbox" id="isDocenteReferente" onchange="uncheckTheOtherCheckBox('docenteReferente')" checked="uncheckTheOtherCheckBox('docenteReferente')"> Docente Referente</label> <br>                      
                            </div>
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
                                        $tmp_path = $_SERVER ['DOCUMENT_ROOT'] . prj_pages . "/admin/inserimento/docenti/tmp/"; // Percorso dove verra' inviato il file uploadato
                                        if (move_uploaded_file ( $_FILES ['file1'] ['tmp_name'], $tmp_path . $fileName)) {  //il file viene spostato nella nuova cartella temporaneamente
                                            echo 'Nome file: <b>' . $fileName . '</b><br>';
                                            echo 'MIME Type: <b>' . $fileType . '</b><br>';
                                            echo 'Dimensione: <b>' . $fileSize . '</b> byte<br>';
                                            echo '======================<br>';
                                            echo 'File caricato correttamente<br><br>';
                                                
                                            $registerFileName = $tmp_path . "registroDocenti.txt";
                                            $registerFile = fopen ( $registerFileName, "a" );   //viene creato un file di registro dove vengono memorizzate le info che
                                                                                                //verranno anche inserite nel database. Se le password vengono inviate
                                                                                                //direttamente agli utenti via mail, valutare se necessario
                                            $uploadedFileName = $tmp_path . $fileName;
                                            $uploadedFile = @file ( $uploadedFileName );
                                                
                                            $connessione = dbConnection("../../../../");
                                            if ($uploadedFile != false) {
                                                foreach ( $uploadedFile as $line ) {
                                                    $explodedLine = explode ( ",", $line );
                                                        
                                                    $nome = $explodedLine [0];
                                                    $cognome = $explodedLine [1];
                                                    $nome = str_replace ( '"', '', $nome );
                                                    $cognome = str_replace ( '"', '', $cognome );
                                                        
                                                    $username = $cognome . "." . $nome;
                                                    $username = str_replace ( ' ', '', $username );
                                                        
                                                    $query = "SELECT * FROM `alternanza_scuola_lavoro`.`docente` WHERE username LIKE '$username%';";
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
                                                            $i++;
                                                        }
                                                    }
                                                        
                                                    $telefono = $explodedLine [2];
                                                    $telefono = str_replace ( '"', '', $telefono );
                                                    $email = $explodedLine [3];
                                                    $email = str_replace ( '"', '', $email );
                                                    $referente = $explodedLine [4];
                                                    $referente = str_replace ( '"', '', $referente );
                                                    $tutor = $explodedLine [5];
                                                    $tutor = str_replace ( '"', '', $tutor );
                                                    $super = $explodedLine [6];
                                                    $super = str_replace ( '"', '', $super );
                                                    fputs ( $registerFile, $username . ";" . $password . ";" . $nome . ";" . $cognome. ";" . $telefono. ";" . $email . ";" . $referente. ";" . $tutor . ";" . $super. ";\n" ); //compilazione del file di registro
                                                    $password = MD5 ( $password );
                                                        
                                                    $query = "INSERT INTO `alternanza_scuola_lavoro`.`docente` (`id_docente`, `username`, `password`, `nome`, `cognome`, `telefono`, `email`, `docente_referente`, `docente_tutor`,  `super_user`) VALUES (NULL, '$username', '$password', '$nome', '$cognome', '$telefono', '$email' , '$referente', '$tutor', '$super');";
                                                    $result = $connessione->query ( $query );
                                                }
                                            }
                                            unlink($uploadedFileName);  //cancello il file uploadato
                                        } else {
                                            echo "Si &egrave; verificato un errore durante l'upload: " . $_FILES ["file1"] ["error"];
                                        }
                                    } else {
                                        echo "Si &egrave verificato un errore durante l'upload: " . $_FILES ["file1"] ["error"];
                                    }
                                } else {
                            ?>
                            <form enctype="multipart/form-data" method="post" action="" name="uploadform">
                                Seleziona il file contenente i docenti da caricare:
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
                                $("#UsernameDocente").on('input',function (){
                                    $.ajax({
                                        type : 'POST',
                                        url : '../ajaxOps/ajaxCheckUserExistence.php',
                                        data : {'user' : $("#UsernameDocente").val()},
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
                                    if ($("#PasswordDocente").val() !== $("#ConfermaPasswordDocente").val() || $("#PasswordDocente").val().length < 8)
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
    <script src="../js/scripts.js" type="text/javascript">
    </script>
</body>
<?php
    close_html ();
?>