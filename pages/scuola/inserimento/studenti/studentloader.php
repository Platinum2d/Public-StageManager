<?php    
    require '../../../../../lib/PHPReader/Classes/PHPExcel.php';
    include "../../../../../pages/functions.php";
    checkLogin(scuolaType, "../../../../../");
    $conn = dbConnection("../../../../../");
    open_html ( "Inserimento studenti da file" );
    import("../../../../../");
        
    define ("PasswordLenght", 8);
        
    $id_anno = $_POST['anno'];
    $id_classe = $_POST['classe'];
        
    function generateRandomicString($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
        
    function checkStudent($username){
        $connection = dbConnection("../../../../../");
        $query = "SELECT id_utente FROM utente WHERE username = '".$connection->escape_string($username)."'";
        $result = $connection->query($query);
        if (!$result || $result->num_rows === 0)
        {
            return $username;
        }
        else
        {
            $tentativi = 1;
//            checkStudentRecursive($username . $tentativi, $tentativi);
            while (true)
            {
                $newuser = $username.$tentativi;
                $query = "SELECT id_utente FROM utente WHERE username = '".$connection->escape_string($newuser)."'";
                $result = $connection->query($query);
                if (!$result || $result->num_rows === 0)
                {
                    return $newuser;
                }
                $tentativi++;
            }
        }
    }
        
    ?>
        
<body>
    
        <?php
        topNavbar ("../../../../../");
        titleImg ("../../../../../");
        ?> 
            
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Inserimento studenti fa file</h1>       
                    <br>
                    <?php
                        if (is_uploaded_file ( $_FILES ['studentfile'] ['tmp_name'] ))
                        {
                            $fileName = $_FILES ['studentfile'] ['name'];
                            echo "<div align='center'><h3 style=\"color:green\"> ==== CARICAMENTO EFFETTUATO CON SUCCESSO ==== </h3><div>";
                            $filepath = "../../../../../media/loads/";
                            if (move_uploaded_file ( $_FILES ['studentfile'] ['tmp_name'], $filepath . $fileName)) 
                            {
                                //echo "<br><h3 style=\"color:green\"> ==== FILE SPOSTATO CON SUCCESSO ==== </h3>";
                                echo "<br>";
                                echo "<div align='center'><h4 style='color:red'><u>ATTENZIONE: SALVARE E CONSERVARE IL FILE PDF APPENA SCARICATO.<br><br>LE PASSWORD DEGLI UTENTI APPENA INSERITI SONO REPERIBILI SOLO DA ESSO.</u></h4></div>";
                                echo "<br><br><br>";
                                echo "<b>Estraggo e inizializzo i parametri del file excel.....</b><br>";
                                        $reader = PHPExcel_IOFactory::createReaderForFile($filepath . $fileName);
                                        $loadedfile = $reader->load($filepath . $fileName);
                                        $sheet = $loadedfile->getSheet(0);
                                        $rows = $sheet->getHighestRow();
                                        $cols = $sheet->getHighestColumn();
                                echo "<b>Fatto</b><br><br>"; //(trovate $rows righe)
                                    
                                //analisi di nomi e cognomi, creazione dello username sul posto. Se uno esiste già, usa il progressivo
                                echo "<b>Creo gli username e inserisco gli studenti nel database....</b><br>";
                                $htmltable = "<table class=\"table table-hover\"> <thead> <th>#</th> <th>Username</th> <th>Password</th> <th>Citta'</th> <th>Mail</th> <th>Telefono</th> </thead> <tbody>";
                                $tableforpdf = "<table id='forpdf'> <thead> <th>#</th> <th>Nome e cognome</th> <th>Username</th> <th>Password</th> </thead> <tbody>";
                                $reporterrori = "";
                                    
                                    for ($I=2; $I<$rows;$I++)
                                    {
                                        $nome = $conn->escape_string(trim($sheet->getCell('A'.$I)->getValue()));
                                        $cognome = $conn->escape_string(trim($sheet->getCell('B'.$I)->getValue()));
                                        if (isset($nome) && !empty($nome) && isset($cognome) && !empty($cognome))
                                        {
                                            $username = $nome.$cognome;
                                            str_replace(" ", "", $username);
                                            $query = "SELECT id_utente FROM utente WHERE username = '".$conn->escape_string($username)."'";
                                            $result = $conn->query($query);
                                            if ($result->num_rows > 0)
                                            {
                                                $tentativi = 1;
                                                while (true)
                                                {
                                                    $newuser = $username.$tentativi;
                                                    $query = "SELECT id_utente FROM utente WHERE username = '".$conn->escape_string($newuser)."'";
                                                    $result = $conn->query($query);
                                                    if ($result->num_rows === 0)
                                                    {
                                                        $username = $newuser;
                                                        break;
                                                    }
                                                    $tentativi++;
                                                }
                                            }   
                                            $password = generateRandomicString(PasswordLenght);
                                            $cryptedPassword = md5($password);
                                            $citta = $conn->escape_string(strtolower(trim($sheet->getCell('C'.$I)->getValue())));
                                                $cittaforinsert = (empty($citta) || !isset($citta)) ? "NULL" : "'".$citta."'";
                                            $email = $conn->escape_string(strtolower(trim($sheet->getCell('D'.$I)->getValue())));
                                                $emailforinsert = (empty($email) || !isset($email)) ? "NULL" : "'".$email."'";
                                            $telefono = $conn->escape_string(strtolower(trim($sheet->getCell('E'.$I)->getValue())));
                                                $telefonoforinsert = (empty($telefono) || !isset($telefono)) ? "NULL" : "'".$telefono."'";
                                                    
                                            $userquery = "INSERT INTO utente (username, password, tipo_utente) VALUES ('".$conn->escape_string($username)."', '$cryptedPassword', ".studType.")";
                                                
                                            $result = $conn->query($userquery);
                                                
                                            if ($result)
                                            {
                                                $insertquery = "INSERT INTO studente (id_studente, nome, cognome, citta, email, telefono, scuola_id_scuola)"
                                                            . " VALUES ((SELECT MAX(id_utente) FROM utente WHERE tipo_utente = ".studType."), '".$conn->escape_string($nome)."','".$conn->escape_string($cognome)."',".$cittaforinsert.",".$emailforinsert.",".$telefonoforinsert.", ".$_SESSION['userId'].")";
                                                                
                                                $attendsquery = "INSERT INTO studente_attends_classe (studente_id_studente, classe_id_classe, anno_scolastico_id_anno_scolastico)"
                                                                . " VALUES ((SELECT MAX(id_utente) FROM utente WHERE tipo_utente = ".studType."), $id_classe, $id_anno)";
                                                
                                                $resultinsert = $conn->query($insertquery);
                                                $resultattends = $conn->query($attendsquery);
                                                
                                                if ($resultattends && $resultinsert)
                                                {
                                                    //inserimento studente_has_stage
                                                    //inserimento docente_referente_has_studente_has_stage
                                                    
                                                    $classexperiencesquery = "SELECT id_classe_has_stage 
                                                                              FROM classe_has_stage 
                                                                              WHERE classe_id_classe = $id_classe 
                                                                              AND anno_scolastico_id_anno_scolastico = $id_anno";
                                                    $resultexp = $conn->query($classexperiencesquery);
                                                    if (is_object($resultexp) && $resultexp->num_rows > 0)
                                                    {
                                                        while ($rowexp = $resultexp->fetch_assoc())
                                                        {
                                                            $id_classe_has_stage = $rowexp['id_classe_has_stage'];
                                                            
                                                            $query = "INSERT INTO studente_has_stage ("
                                                            . "visita_azienda, autorizzazione_registro, studente_id_studente, "
                                                            . "classe_has_stage_id_classe_has_stage, valutazione_studente_id_valutazione_studente, "
                                                            . "valutazione_stage_id_valutazione_stage, azienda_id_azienda, "
                                                            . "docente_tutor_id_docente_tutor, tutor_id_tutor) "
                                                            . "VALUES (0, 1, (SELECT MAX(id_studente) FROM studente), "
                                                            . "$id_classe_has_stage, NULL, "
                                                            . "NULL, NULL, "
                                                            . "NULL, NULL)";
                                                            
                                                            if (!$conn->query($query))
                                                                $reporterrori .= "<br><h3 style=\"color:red\">  ==== FATAL ERROR ALLA RIGA $I ==== </h3>";
                                                            
                                                            $docsrefquery = "SELECT DISTINCT docente_id_docente 
                                                                             FROM studente_has_stage AS shs, docente_referente_has_studente_has_stage AS drhshs, classe_has_stage AS chs 
                                                                             WHERE shs.id_studente_has_stage = drhshs.studente_has_stage_id_studente_has_stage 
                                                                             AND shs.classe_has_stage_id_classe_has_stage = chs.id_classe_has_stage 
                                                                             AND shs.classe_has_stage_id_classe_has_stage = $id_classe_has_stage";
                                                            
                                                            $docsrefresult = $conn->query($docsrefquery);
                                                            if (is_object($docsrefresult) && $docsrefresult->num_rows > 0)
                                                            {
                                                                while ($rowdoc = $docsrefresult->fetch_assoc())
                                                                {
                                                                    $id_doc = $rowdoc['docente_id_docente'];
                                                                    
                                                                    $query = "INSERT INTO docente_referente_has_studente_has_stage (studente_has_stage_id_studente_has_stage, docente_id_docente) "
                                                                            . "VALUES((SELECT MAX(id_studente_has_stage) FROM studente_has_stage), $id_doc)";
                                                                    if (!$conn->query($query))
                                                                               $reporterrori .= "<br><h3 style=\"color:red\">  ==== FATAL ERROR ALLA RIGA $I ==== </h3>";               
                                                                }
                                                            }
                                                        }
                                                    }
                                                    
                                                    $htmltable .= "<tr><td>".($I - 1)."</td> <td>$username</td> <td>$password</td> <td>$citta</td> <td>$email</td> <td>$telefono</td> </tr>";
                                                    $tableforpdf .= "<tr><td>".($I - 1)."</td> <td>$nome $cognome</td> <td>$username</td> <td>$password</td> </tr>";
                                                }
                                                else
                                                {
                                                    $reporterrori .= "<br><h3 style=\"color:red\"> ==== $insertquery FATAL ERROR ALLA RIGA $I ==== </h3>";
                                                }
                                            }                            
                                        }
                                        else
                                        {
                                            //$reporterrori .= "<br><h3 style=\"color:red\"> ==== NOME, COGNOME E/O CLASSE NON IMPOSTATO/I ALLA RIGA $I ==== </h3>";
                                        }
                                    }
                                    $htmltable .= "</tbody></table>";
                                    $tableforpdf .= "</tbody></table>";
                            }
                            else
                            {
                                //echo "<br><h3 style=\"color:red\"> ==== SPOSTAMENTO FALLITO ==== </h3>";
                            }
                        }
                        else
                        {
                            echo "<div align='center'><h3 style=\"color:RED\"> ==== CARICAMENTO FALLITO ==== </h3><div>";
                        }
                            
                        echo "<b>Fatto</b><br><br>$htmltable";
                        echo "<br><br>$reporterrori";
                        echo $tableforpdf;
                        unlink($filepath . $fileName);
                        ?> 
                </div>
            </div>
        </div>
    </div>
        
    <script>
        var doc = new jsPDF();
        var tb = document.getElementById("forpdf");
        var res = doc.autoTableHtmlToJson(tb);
        doc.autoTable(res.columns, res.data);
        var nome_classe = localStorage.getItem("nome_classe");
        var nome_anno = localStorage.getItem("nome_anno");
        
        doc.save(nome_classe+"_"+nome_anno+"_Credenziali_Studenti.pdf");
        $("#forpdf").hide();
    </script>    
</body>      
    <?php
        close_html("../../../../../");