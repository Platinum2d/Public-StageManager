<?php
    require '../../../../lib/PHPReader/Classes/PHPExcel.php';
    include "../../../../pages/functions.php";
    checkLogin(scuolaType, "../../../../");
    $conn = dbConnection("../../../../");
    open_html ( "Inserimento aziende da file" );
    import("../../../../");
        
    define ("PasswordLenght", 8);
        
    function checkCompany($username)
    {
        $query = "SELECT id_utente FROM utente WHERE username = '".$conn->escape_string($username)."'";
        $result = $conn->query($query);
        if ($result->num_rows === 0)
        {
            return $username;
        }
        else
        {
            $tentativi = 1;
            while (true)
            {
                $newuser = $username.$tentativi;
                $query = "SELECT id_utente FROM utente WHERE username = '".$conn->escape_string($newuser)."'";
                $result = $conn->query($query);
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
                    <h1>Inserimento aziende fa file</h1>
                    <br>
                    <?php
                        if (is_uploaded_file ( $_FILES ['companyfile'] ['tmp_name'] ))
                        {
                            $fileName = $_FILES ['companyfile'] ['name'];
                            echo "<div align='center'><h3 style=\"color:green\"> ==== CARICAMENTO EFFETTUATO CON SUCCESSO ==== </h3></div>";
                            $filepath = "../../../../media/loads/";
                            if (move_uploaded_file ( $_FILES ['companyfile'] ['tmp_name'], $filepath . $fileName)) {
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
                            echo "<div align='center'><b>Creo gli username e inserisco le aziende nel database....</b></div>";
                            $htmltable = "<div class='table-responsive'><table class='table table-hover' id='report'> <thead> <th>#</th> <th>Username</th> <th>Password</th> <th>Nome azienda</th> <th>Citta'</th> <th>CAP</th> <th>Indirizzo</th> <th>Telefono</th>"
                                . "<th>Email</th><th>Sito web</th><th>Nome responsabile</th><th>Cognome responsabile</th><th>Telefono responsabile</th><th>Email responsabile</th></thead> <tbody>";
                                $tableforpdf = "<table style='' id='forpdf'> <thead> <th>#</th> <th>Nome azienda</th> <th>Username</th> <th>Password</th> </thead> <tbody>";
                                    $reporterrori = "";
                                        
                                    for ($I=2; $I<$rows;$I++)
                                    {
                                        $tentativi = 1;
                                        $nome = (trim($sheet->getCell('A'.$I)->getValue()));
                                        if (isset($nome) && !empty($nome))
                                        {
                                        str_replace(" ", "", $nome);
                                        $username = $nome;
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
                                        $citta = $conn->escape_string(trim($sheet->getCell('B'.$I)->getValue()));
                                        $cittaforinsert = (empty($citta) || !isset($citta)) ? "NULL" : "'".$citta."'";
                                        
                                        $CAP = $conn->escape_string(trim($sheet->getCell('C'.$I)->getValue()));
                                        $CAPforinsert = (empty($CAP) || !isset($CAP)) ? "NULL" : "'".$CAP."'";
                                        
                                        $indirizzo = $conn->escape_string(trim($sheet->getCell('D'.$I)->getValue()));
                                        $indirizzoforinsert = (empty($indirizzo) || !isset($indirizzo)) ? "NULL" : "'".$indirizzo."'";
                                        
                                        $telefono = $conn->escape_string(trim($sheet->getCell('E'.$I)->getValue()));
                                        $telefonoforinsert = (empty($telefono) || !isset($telefono)) ? "NULL" : "'".$telefono."'";
                                        
                                        $email = $conn->escape_string(trim($sheet->getCell('F'.$I)->getValue()));
                                        $emailforinsert = (empty($email) || !isset($email)) ? "NULL" : "'".$email."'";
                                        
                                        $sito = $conn->escape_string(trim($sheet->getCell('G'.$I)->getValue()));
                                        $sitoforinsert = (empty($sito) || !isset($sito)) ? "NULL" : "'".$sito."'";
                                        
                                        $nomeresponsabile = $conn->escape_string(trim($sheet->getCell('H'.$I)->getValue()));
                                        $nomeresponsabileforinsert = (empty($nomeresponsabile) || !isset($nomeresponsabile)) ? "NULL" : "'".$nomeresponsabile."'";
                                        
                                        $cognomeresponsabile = $conn->escape_string(trim($sheet->getCell('I'.$I)->getValue()));
                                        $cognomeresponsabileforinsert = (empty($cognomeresponsabile) || !isset($cognomeresponsabile)) ? "NULL" : "'".$cognomeresponsabile."'";
                                        
                                        $telefonoresponsabile = $conn->escape_string(trim($sheet->getCell('J'.$I)->getValue()));
                                        $telefonoresponsabileforinsert = (empty($telefonoresponsabile) || !isset($telefonoresponsabile)) ? "NULL" : "'".$telefonoresponsabile."'";
                                        
                                        $mailresponsabile = $conn->escape_string(trim($sheet->getCell('K'.$I)->getValue()));
                                        $mailresponsabileforinsert = (empty($mailresponsabile) || !isset($mailresponsabile)) ? "NULL" : "'".$mailresponsabile."'";
                                        $conn->query("SET FOREIGN_KEY_CHECKS = 0");
                                        
                                        $userquery = "INSERT INTO utente (username, password, tipo_utente) VALUES ('".$conn->escape_string($username)."', '$cryptedPassword', ".ceoType.")";
                                        
                                        $insertquery = "INSERT INTO azienda (id_azienda, nome_aziendale, citta_aziendale, CAP, indirizzo, telefono_aziendale, email_aziendale, sito_web, nome_responsabile, cognome_responsabile, telefono_responsabile, email_responsabile)"
                                                . " VALUES ((SELECT MAX(id_utente) FROM utente WHERE tipo_utente = ".ceoType."),'".$conn->escape_string($nome)."', ".($cittaforinsert).", ".($CAPforinsert).", ".($indirizzoforinsert).", ".($telefonoforinsert).", ".($emailforinsert).", ".($sitoforinsert).", ".($nomeresponsabileforinsert).", ".($cognomeresponsabileforinsert).", ".($telefonoresponsabileforinsert).", ".($mailresponsabileforinsert).");";
                                        
                                        $htmltable .= "<tr> <td>".($I - 1)."  </td><td>$username</td> <td>$password</td> <td>$nome</td> <td>$citta</td> <td>$CAP</td> <td>$indirizzo</td>
                                            <td>$telefono</td><td>$email</td><td>$sito</td><td>$nomeresponsabile</td><td>$cognomeresponsabile</td><td>$telefonoresponsabile</td> 
                                            <td>$mailresponsabile</td></tr>";
                                                
                                        $tableforpdf .= "<tr><td>".($I - 1)."</td> <td>$nome</td> <td>$username</td> <td>$password</td> </tr>";
                                            
                                            $conn->query($userquery);

                                            if (!$conn->query($insertquery))
                                                $htmltable .= "<tr><td>$conn->error<br></td></tr>";
                                        }
                                        else
                                        {
                                        //$reporterrori .= "<br><h3 style=\"color:red\"> ==== NOME NON IMPOSTATO ALLA RIGA ".($I - 1)." ==== </h3>";
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
    
    doc.save('Credenziali_Aziende.pdf');
    $("#forpdf").hide();
</script>
    
</body>
    
<?php
    close_html("../../../../");
?>