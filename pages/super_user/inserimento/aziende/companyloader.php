<?php
    require '../../../../lib/PHPReader/Classes/PHPExcel.php';
    require_once('../../../../lib/TCPDF/tcpdf.php');
    include "../../../../pages/functions.php";
    checkLogin(superUserType, "../../../../");
    $conn = dbConnection("../../../../");
    import("../../../../");
        
    define ("PasswordLenght", 8);
        
    function generateRandomString($length) 
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
        
        
        
        
        
        
    echo "<html>";
        echo "<head>";
            
        echo "</head>";
            
        echo "<body>";
        if (is_uploaded_file ( $_FILES ['companyfile'] ['tmp_name'] ))
        {
            $fileName = $_FILES ['companyfile'] ['name'];
            echo "<h3 style=\"color:green\"> ==== CARICAMENTO EFFETTUATO CON SUCCESSO ==== </h3>";
            $filepath = "../../../../media/loads/";
            if (move_uploaded_file ( $_FILES ['companyfile'] ['tmp_name'], $filepath . $fileName)) {
                echo "<br><h3 style=\"color:green\"> ==== FILE SPOSTATO CON SUCCESSO ==== </h3><br><br><br>";
                //analisi delle classi. Se non ne esiste una, creala.
                echo "<div style='margin-left:10px'><b>Estraggo e inizializzo i parametri del file excel.....</b><br>";
                        $reader = PHPExcel_IOFactory::createReaderForFile("../../../../media/loads/" . $fileName);
                        $loadedfile = $reader->load("../../../../media/loads/" . $fileName);
                        $sheet = $loadedfile->getSheet(0);
                        $rows = $sheet->getHighestRow();
                        $cols = $sheet->getHighestColumn();
                echo "<b>\tFatto (trovate $rows righe)</b><br><br>";
                    
                //analisi di nomi e cognomi, creazione dello username sul posto. Se uno esiste già, usa il progressivo
                echo "<b>\tCreo gli username e inserisco le aziende nel database....</b><br>";
                $htmltable = "<table class='table table-hover' id='report'> <thead> <th>#</th> <th>Username</th> <th>Password</th> <th>Nome azienda</th> <th>Citta'</th> <th>CAP</th> <th>Indirizzo</th> <th>Telefono</th>"
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
                            $password = generateRandomString(PasswordLenght);
                            $cryptedPassword = md5($password);
                            $citta = (trim($sheet->getCell('B'.$I)->getValue()));
                                $citta = (empty($citta) || !isset($citta)) ? "Sconosciuta" : $citta;
                            $CAP = (trim($sheet->getCell('C'.$I)->getValue()));
                                $CAP = (empty($CAP) || !isset($CAP)) ? "Sconosciuto" : $CAP;
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
                                
                            $userquery = "INSERT INTO utente (username, password, tipo_utente) VALUES ('".$conn->escape_string($username)."', '$cryptedPassword', 4)";
                                
                            $insertquery = "INSERT INTO azienda (id_azienda, nome_aziendale, citta_aziendale, CAP, indirizzo, telefono_aziendale, email_aziendale, sito_web, nome_responsabile, cognome_responsabile, telefono_responsabile, email_responsabile)"
                                            . " VALUES ((SELECT MAX(id_utente) FROM utente WHERE tipo_utente = 4),'".$conn->escape_string($nome)."','".$conn->escape_string($citta)."','".$conn->escape_string($CAP)."','".$conn->escape_string($indirizzo)."','".$conn->escape_string($telefono)."', '".$conn->escape_string($email)."'";
                            $htmltable .= "<tr> <td>".($I - 1)."  </td><td>$username</td> <td>$password</td> <td>$nome</td> <td>$citta</td> <td>$CAP</td> <td>$indirizzo</td>
                            <td>$telefono</td><td>$email</td><td>$sito</td><td>$nomeresponsabile</td><td>$cognomeresponsabile</td><td>$telefonoresponsabile</td> 
                            <td>$mailresponsabile</td></tr>";
                            
                            $tableforpdf .= "<tr><td>".($I - 1)."</td> <td>$nome</td> <td>$username</td> <td>$password</td> </tr>";
                                
                            $sito = (!isset($sito) || empty($sito)) ? "NULL" : $conn->escape_string($sito);
                            $nomeresponsabile = (!isset($nomeresponsabile) || empty($nomeresponsabile)) ? "NULL" : $conn->escape_string($nomeresponsabile);
                            $cognomeresponsabile = (!isset($cognomeresponsabile) || empty($cognomeresponsabile)) ? "NULL" : $conn->escape_string($cognomeresponsabile);
                            $telefonoresponsabile = (!isset($telefonoresponsabile) || empty($telefonoresponsabile)) ? "NULL" : $conn->escape_string($telefonoresponsabile);
                            $mailresponsabile = (!isset($mailresponsabile) || empty($mailresponsabile)) ? "NULL" : $conn->escape_string($mailresponsabile);
                                
                            $insertquery .= ", '$sito', '$nomeresponsabile', '$cognomeresponsabile', '$telefonoresponsabile', '$mailresponsabile')";
    
//                            $conn->query($userquery);
//                                
//                            if ($conn->query($insertquery))
//                            {
//                                echo "Generato l'utente $username <br><br>";
//                            }
//                            else
//                            {
//                                $htmltable .= "<tr> $conn->error<br> </tr>";
//                            }
    
    
                        }
                        else
                        {
                            $reporterrori .= "<br><h3 style=\"color:red\"> ==== NOME NON IMPOSTATO ALLA RIGA ".($I - 1)." ==== </h3>";
                        }
                    }
                    $tableforpdf .= "</tbody></table>";
                    $htmltable .= "</tbody></table>";
            }
            else
            {
                echo "<br><h3 style=\"color:red\"> ==== SPOSTAMENTO FALLITO ==== </h3>";
            }
        }
        else
        {
            echo "<h3 style=\"color:RED\"> ==== CARICAMENTO FALLITO ==== </h3>";
        }
            
        echo "<br>\tFatto.</div><br><br>$htmltable";
        echo "<br><br>$reporterrori";
        echo $tableforpdf;
            
        ?> 
            <script>
                var doc = new jsPDF();
                var tb = document.getElementById("forpdf");
                var res = doc.autoTableHtmlToJson(tb);
                doc.autoTable(res.columns, res.data);
                
                doc.save('sample-file.pdf');
                $("#forpdf").hide();
            </script>    
        <?php
        echo "</body>";
    echo "</html>";
    
    ?>