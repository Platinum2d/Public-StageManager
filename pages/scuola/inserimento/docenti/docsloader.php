<?php
    require '../../../../lib/PHPReader/Classes/PHPExcel.php';
    include "../../../../pages/functions.php";
    checkLogin(scuolaType, "../../../../");
    $conn = dbConnection("../../../../");
    open_html ( "Inserimento docenti da file" );
    import("../../../../");
        
    define ("PasswordLenght", 8);
    $type = $_POST['tipo_docente'];
    $type = ($type === "docente_tutor") ? doctutType : docrefType;
        
    function checkDoc($username)
    {
        $connection = dbConnection("../../../../");
        $query = "SELECT id_utente FROM utente WHERE username = '".$connection->escape_string($username)."'";
        $result = $connection->query($query);
        if (!$result || $result->num_rows === 0)
        {
            return $username;
        }
        else
        {
            $tentativi = 1;
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
        topNavbar ("../../../../");
        titleImg ("../../../../");
        ?> 
    
    
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Inserimento docenti da file</h1>
                    <br>
                    <?php
                        if (is_uploaded_file ( $_FILES ['docsfile'] ['tmp_name'] ))
                        {
                            $fileName = $_FILES ['docsfile'] ['name'];
                            echo "<div align='center'><h3 style=\"color:green\"> ==== CARICAMENTO EFFETTUATO CON SUCCESSO ==== </h3></div>";
                            $filepath = "../../../../media/loads/";
                            if (move_uploaded_file ( $_FILES ['docsfile'] ['tmp_name'], $filepath . $fileName)) {
                            //echo "<br><h3 style=\"color:green\"> ==== FILE SPOSTATO CON SUCCESSO ==== </h3><br><br><br>";
                            //analisi delle classi. Se non ne esiste una, creala.
                            echo "<br>";
                            echo "<div align='center'><h4 style='color:red'><u>ATTENZIONE: SALVARE E CONSERVARE IL FILE PDF APPENA SCARICATO.<br><br>LE PASSWORD DEGLI UTENTI APPENA INSERITI SONO REPERIBILI SOLO DA ESSO.</u></h4></div>";
                            echo "<br><br><br>";
                            echo "<div align='center'><b>Estraggo e inizializzo i parametri del file excel.....</b><br></div>";
                            $reader = PHPExcel_IOFactory::createReaderForFile("../../../../media/loads/" . $fileName);
                            $loadedfile = $reader->load("../../../../media/loads/" . $fileName);
                            $sheet = $loadedfile->getSheet(0);
                            $rows = $sheet->getHighestRow();
                            $cols = $sheet->getHighestColumn();
                            echo "<div align='center'><b>Fatto.</b></div><br><br>"; //(trovate $rows righe)
                                
                            //analisi di nomi e cognomi, creazione dello username sul posto. Se uno esiste già, usa il progressivo
                            echo "<div align='center'><b>Creo gli username e inserisco i docenti nel database....</b></div>";
                            $htmltable = "<div class='table-responsive'><table class='table table-hover' id='report'> <thead> <th>#</th> <th>Nome e cognome</th> <th>Username</th> <th>Password</th> <th>Telefono</th>"
                                . "<th>Email</th></thead> <tbody>";
                                $tableforpdf = "<table style='' id='forpdf'> <thead> <th>#</th> <th>Nome azienda</th> <th>Username</th> <th>Password</th> </thead> <tbody>";
                                    $reporterrori = "";
                                        
                                    for ($I=2; $I<$rows;$I++)
                                    {
                                        $tentativi = 1;
                                        $nome = (trim($sheet->getCell('A'.$I)->getValue()));
                                        $cognome = (trim($sheet->getCell('B'.$I)->getValue()));
                                        if (isset($nome) && !empty($nome) && isset($nome) && !empty($nome))
                                        {
                                        $username = $nome.$cognome;
                                        $username = strip_whitespaces($username);
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
                                        
                                        $password = generateRandomString(PasswordLenght);
                                        $cryptedPassword = md5($password);
                                        
                                        $telefono = $conn->escape_string(trim($sheet->getCell('C'.$I)->getValue()));
                                        $telefonoforinsert = (empty($telefono) || !isset($telefono)) ? "NULL" : "'".$telefono."'";
                                        
                                        $email = $conn->escape_string(trim($sheet->getCell('D'.$I)->getValue()));
                                        $emailforinsert = (empty($email) || !isset($email)) ? "NULL" : "'".$email."'";
                                        $conn->query("SET FOREIGN_KEY_CHECKS = 0");
                                            
                                        $userquery = "INSERT INTO utente (username, password, tipo_utente) VALUES ('".$conn->escape_string($username)."', '$cryptedPassword', $type)";
                                            
                                        $insertquery = "INSERT INTO docente (id_docente, nome, cognome, telefono, email, scuola_id_scuola)"
                                        . " VALUES ((SELECT MAX(id_utente) FROM utente WHERE tipo_utente = $type),'".$conn->escape_string($nome)."','".$conn->escape_string($cognome)."',".($telefonoforinsert).",".($emailforinsert).", ".$_SESSION['userId'].")";
                                        $htmltable .= "<tr> <td>".($I - 1)."  </td><td>$nome $cognome</td> <td>$username</td> <td>$password</td> <td>$telefono</td> <td>$email</td> </tr>";
                                                
                                        $tableforpdf .= "<tr><td>".($I - 1)."</td> <td>$nome $cognome</td> <td>$username</td> <td>$password</td> </tr>";
                                            
                                        $conn->query($userquery);

                                        if (!$conn->query($insertquery))
                                            $htmltable .= "<tr><td>$conn->error<br></td></tr>";
                                        }
                                        else
                                        {
                                            //$reporterrori .= "<br><h3 style=\"color:red\"> ==== NOME E/O COGNOME NON IMPOSTATO/I ALLA RIGA ".($I - 1)." ==== </h3>";
                                        }
                                    }
                                    $tableforpdf .= "</tbody></table>";
                                    $htmltable .= "</tbody></table>";
                                }
                                else
                                {
                                    //echo "<br><h3 style=\"color:red\"> ==== SPOSTAMENTO FALLITO ==== </h3>";
                                }
                        }
                        else
                        {
                        echo "<div align='center'><h3 style=\"color:RED\"> ==== CARICAMENTO FALLITO ==== </h3></div>";
                        }
                            
                        echo "<div align='center'><b>Fatto.</b></div><br><br>$htmltable</div>";
                        echo "<br><br>$reporterrori";
                        echo $tableforpdf;
                        unlink($filepath . $fileName);
        ?> 
            
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    var doc = new jsPDF();
    var tb = document.getElementById("forpdf");
    var res = doc.autoTableHtmlToJson(tb);
    doc.autoTable(res.columns, res.data);
    var tipo = (localStorage.getItem("tipo_docente") === "docente_tutor") ?  "Tutor" : "Referenti";
    
    doc.save("Credenziali_Docenti_"+tipo+".pdf");
    $("#forpdf").hide();
</script>
    
</body>
    
<?php
    close_html("../../../../");
?>