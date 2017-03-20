<?php
    require '../../../../lib/PHPReader/Classes/PHPExcel.php';
    include "../../../../pages/functions.php";
    checkLogin(scuolaType, "../../../../");
    $conn = dbConnection("../../../../");
    open_html ( "Inserimento aziende da file" );
    import("../../../../");
        
    define ("PasswordLenght", 8);
        
    function generateRandomicString($length) 
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) 
        {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
        
    function checkCompany($username)
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
                                        $username = checkCompany($username);//verifica dell'esistenza del nome utente                            
                                        $password = generateRandomicString(PasswordLenght);
                                        $cryptedPassword = md5($password);
                                        $citta = (trim($sheet->getCell('B'.$I)->getValue()));
                                        $citta = (empty($citta) || !isset($citta)) ? "Sconosciuta" : $citta;
                                        $CAP = (trim($sheet->getCell('C'.$I)->getValue()));
                                        $CAP = (empty($CAP) || !isset($CAP)) ? "000" : $CAP;
                                        $indirizzo = (trim($sheet->getCell('D'.$I)->getValue()));
                                        $indirizzo = (empty($indirizzo) || !isset($indirizzo)) ? "Sconosciuto" : $indirizzo;
                                        $telefono = (trim($sheet->getCell('E'.$I)->getValue()));
                                        $telefono = (empty($telefono) || !isset($telefono)) ? "Sconosciuto" : $telefono;
                                        $email = (trim($sheet->getCell('F'.$I)->getValue()));
                                        $email = (empty($email) || !isset($email)) ? "Sconosciuta" : $email;
                                        $sito = (trim($sheet->getCell('G'.$I)->getValue()));
                                        $nomeresponsabile = (trim($sheet->getCell('H'.$I)->getValue()));
                                        $cognomeresponsabile = (trim($sheet->getCell('I'.$I)->getValue()));
                                        $telefonoresponsabile = (trim($sheet->getCell('J'.$I)->getValue()));
                                        $mailresponsabile = (trim($sheet->getCell('K'.$I)->getValue()));
                                        $conn->query("SET FOREIGN_KEY_CHECKS = 0");
                                            
                                        $userquery = "INSERT INTO utente (username, password, tipo_utente) VALUES ('".$conn->escape_string($username)."', '$cryptedPassword', ".ceoType.")";
                                            
                                        $insertquery = "INSERT INTO azienda (id_azienda, nome_aziendale, citta_aziendale, CAP, indirizzo, telefono_aziendale, email_aziendale, sito_web, nome_responsabile, cognome_responsabile, telefono_responsabile, email_responsabile)"
                                        . " VALUES ((SELECT MAX(id_utente) FROM utente WHERE tipo_utente = ".ceoType."),'".$conn->escape_string($nome)."','".$conn->escape_string($citta)."','".$conn->escape_string($CAP)."','".$conn->escape_string($indirizzo)."','".$conn->escape_string($telefono)."', '".$conn->escape_string($email)."'";
                                        $htmltable .= "<tr> <td>".($I - 1)."  </td><td>$username</td> <td>$password</td> <td>$nome</td> <td>$citta</td> <td>$CAP</td> <td>$indirizzo</td>
                                            <td>$telefono</td><td>$email</td><td>$sito</td><td>$nomeresponsabile</td><td>$cognomeresponsabile</td><td>$telefonoresponsabile</td> 
                                            <td>$mailresponsabile</td></tr>";
                                                
                                        $tableforpdf .= "<tr><td>".($I - 1)."</td> <td>$nome</td> <td>$username</td> <td>$password</td> </tr>";
                                            
                                        $sito = (!isset($sito) || empty($sito)) ? "NULL" : $conn->escape_string($sito);
                                        if ($sito === "NULL") $insertquery .= ", $sito"; else $insertquery .= ", '$sito'";
                                            
                                        $nomeresponsabile = (!isset($nomeresponsabile) || empty($nomeresponsabile)) ? "NULL" : $conn->escape_string($nomeresponsabile);
                                        if ($nomeresponsabile === "NULL") $insertquery .= ", $nomeresponsabile"; else $insertquery .= ", '$nomeresponsabile'";
                                            
                                        $cognomeresponsabile = (!isset($cognomeresponsabile) || empty($cognomeresponsabile)) ? "NULL" : $conn->escape_string($cognomeresponsabile);
                                        if ($cognomeresponsabile === "NULL") $insertquery .= ", $cognomeresponsabile"; else $insertquery .= ", '$cognomeresponsabile'";
                                            
                                        $telefonoresponsabile = (!isset($telefonoresponsabile) || empty($telefonoresponsabile)) ? "NULL" : $conn->escape_string($telefonoresponsabile);
                                        if ($telefonoresponsabile === "NULL") $insertquery .= ", $telefonoresponsabile"; else $insertquery .= ", '$telefonoresponsabile'";
                                            
                                        $mailresponsabile = (!isset($mailresponsabile) || empty($mailresponsabile)) ? "NULL" : $conn->escape_string($mailresponsabile);
                                        if ($telefonoresponsabile === "NULL") $insertquery .= ", $telefonoresponsabile)"; else $insertquery .= ", '$telefonoresponsabile')";
                                            
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