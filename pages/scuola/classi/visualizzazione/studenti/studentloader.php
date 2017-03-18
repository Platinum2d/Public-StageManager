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
                                        $nome = (trim($sheet->getCell('A'.$I)->getValue()));
                                        $cognome = (trim($sheet->getCell('B'.$I)->getValue()));
                                        if (isset($nome) && !empty($nome) && isset($cognome) && !empty($cognome))
                                        {
                                            $username = $nome.$cognome;
                                            str_replace(" ", "", $username);
                                            $username = checkStudent($username);//verifica dell'esistenza del nome utente                            
                                            $password = generateRandomicString(PasswordLenght);
                                            $cryptedPassword = md5($password);
                                            $citta = strtolower(trim($sheet->getCell('C'.$I)->getValue()));
                                                $citta = (empty($citta) || !isset($citta)) ? "Sconosciuta" : $citta;
                                            $email = strtolower(trim($sheet->getCell('D'.$I)->getValue()));
                                                $email = (empty($email) || !isset($email)) ? "Sconosciuta" : $email;
                                            $telefono = strtolower(trim($sheet->getCell('E'.$I)->getValue()));
                                                $telefono = (empty($telefono) || !isset($telefono)) ? "Sconosciuto" : $telefono;
                                                    
                                            $userquery = "INSERT INTO utente (username, password, tipo_utente) VALUES ('".$conn->escape_string($username)."', '$cryptedPassword', ".studType.")";
                                                
                                            $result = $conn->query($userquery);
                                                
                                            if ($result)
                                            {
                                                $insertquery = "INSERT INTO studente (id_studente, nome, cognome, citta, email, telefono, scuola_id_scuola)"
                                                            . " VALUES ((SELECT MAX(id_utente) FROM utente WHERE tipo_utente = ".studType."), '".$conn->escape_string($nome)."','".$conn->escape_string($cognome)."','".$conn->escape_string($citta)."','".$conn->escape_string($email)."','".$conn->escape_string($telefono)."', ".$_SESSION['userId'].")";
                                                                
                                                $attendsquery = "INSERT INTO studente_attends_classe (studente_id_studente, classe_id_classe, anno_scolastico_id_anno_scolastico)"
                                                                . " VALUES ((SELECT MAX(id_utente) FROM utente WHERE tipo_utente = ".studType."), $id_classe, $id_anno)";
                                                                    
                                                if ($conn->query($insertquery) && $conn->query($attendsquery))
                                                {
                                                    $htmltable .= "<tr><td>".($I - 1)."</td> <td>$username</td> <td>$password</td> <td>$citta</td> <td>$email</td> <td>$telefono</td> </tr>";
                                                    $tableforpdf .= "<tr><td>".($I - 1)."</td> <td>$nome $cognome</td> <td>$username</td> <td>$password</td> </tr>";
                                                }
                                                else
                                                {
                                                    $reporterrori .= "<br><h3 style=\"color:red\"> ==== FATAL ERROR ALLA RIGA $I ==== </h3>";
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
        
        doc.save(""+nome_classe+"_"+nome_anno+"_Credenziali_Studenti.pdf");
        $("#forpdf").hide();
    </script>    
</body>      
    <?php
        close_html("../../../../../");