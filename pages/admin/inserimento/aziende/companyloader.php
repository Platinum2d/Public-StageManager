<?php
    
    require '../../../../src/lib/PHPReader/Classes/PHPExcel.php';
    include "../../../../pages/functions.php";
    checkLogin(adminType, "../../../../");
    $conn = dbConnection("../../../../");
    import("../../../../");
        
    function generateRandomString($length = 5) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
        
    function checkCompanyRecursive($username){
        $connection = dbConnection("../../../../");
        $query = "SELECT id_azienda FROM azienda WHERE username = '".$connection->escape_string($username)."'";
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
                $query = "SELECT id_azienda FROM azienda WHERE username = '".$connection->escape_string($newuser)."'";
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
            $filepath = "../../../../src/loads/";
            if (move_uploaded_file ( $_FILES ['companyfile'] ['tmp_name'], $filepath . $fileName)) {
                echo "<br><h3 style=\"color:green\"> ==== FILE SPOSTATO CON SUCCESSO ==== </h3><br><br><br>";
                //analisi delle classi. Se non ne esiste una, creala.
                echo "<b>Estraggo e inizializzo i parametri del file excel.....</b><br>";
                        $reader = PHPExcel_IOFactory::createReaderForFile("../../../../src/loads/" . $fileName);
                        $loadedfile = $reader->load("../../../../src/loads/" . $fileName);
                        $sheet = $loadedfile->getSheet(0);
                        $rows = $sheet->getHighestRow();
                        $cols = $sheet->getHighestColumn();
                echo "<b>Fatto (trovate $rows righe)</b><br><br>";
                    
                //analisi di nomi e cognomi, creazione dello username sul posto. Se uno esiste già, usa il progressivo
                echo "<b>Creo gli username e inserisco le aziende nel database....</b><br>";
                $htmltable = "<table class=\"table table-hover\"> <thead> <th>Username</th> <th>Password</th> <th>Nome azienda</th> <th>Citta'</th> <th>CAP</th> <th>Indirizzo</th> <th>Telefono</th>"
                        . "<th>Email</th><th>Sito web</th><th>Nome responsabile</th><th>Cognome responsabile</th><th>Telefono responsabile</th><th>Email responsabile</th></thead> <tbody>";
                $reporterrori = "";
                    
                    for ($I=2; $I<$rows;$I++)
                    {
                        $tentativi = 1;
                        $nome = (trim($sheet->getCell('A'.$I)->getValue()));
                        if (isset($nome) && !empty($nome))
                        {
                            $username = $nome;
                            $username = checkCompanyRecursive($username);//verifica dell'esistenza del nome utente                            
                            $password = generateRandomString();
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
                                
                            $insertquery = "INSERT INTO azienda (username, password, nome_aziendale, citta_aziendale, CAP, indirizzo, telefono_aziendale, email_aziendale, sito_web, nome_responsabile, cognome_responsabile, telefono_responsabile, email_responsabile)"
                                            . " VALUES ('".$conn->escape_string($username)."','$cryptedPassword','".$conn->escape_string($nome)."','".$conn->escape_string($citta)."','".$conn->escape_string($CAP)."','".$conn->escape_string($indirizzo)."','".$conn->escape_string($telefono)."', '".$conn->escape_string($email)."'";
                             $htmltable .= "<tr> <td>$username</td> <td>$password</td> <td>$nome</td> <td>$citta</td> <td>$CAP</td> <td>$indirizzo</td>
                            <td>$telefono</td><td>$email</td><td>$sito</td><td>$nomeresponsabile</td><td>$cognomeresponsabile</td><td>$telefonoresponsabile</td> 
                            <td>$mailresponsabile</td></tr>";
                            if (!isset($sito) || empty($sito))$insertquery .= ", NULL";
                            else $insertquery .= ", '".$conn->escape_string($sito)."'";
                            
                            if (!isset($nomeresponsabile) || empty($nomeresponsabile)) $insertquery .= ", NULL";
                            else $insertquery .= ", '".$conn->escape_string($nomeresponsabile)."'";
                            
                            if (!isset($cognomeresponsabile) || empty($cognomeresponsabile)) $insertquery .= ", NULL";
                            else $insertquery .= ", '".$conn->escape_string($cognomeresponsabile)."'";
                            
                            if (!isset($telefonoresponsabile) || empty($telefonoresponsabile)) $insertquery .= ", NULL";
                            else $insertquery .= ", '".$conn->escape_string($telefonoresponsabile)."'";
                            
                            if (!isset($mailresponsabile) || empty($mailresponsabile)) $insertquery .= ", NULL)";
                            else $insertquery .= ", '".$conn->escape_string($mailresponsabile)."')";
                                
                            if ($conn->query($insertquery))
                            {
                                echo "Generato l'utente $username <br><br>";
                            }
                            else
                            {
                                $htmltable .= "<tr> $conn->error<br> </tr>";
                            }
                                
                        }
                        else
                        {
                            $reporterrori .= "<br><h3 style=\"color:red\"> ==== NOME NON IMPOSTATO ALLA RIGA $I ==== </h3>";
                        }
                    }
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
            
        echo "<br><br>$htmltable";
        echo "<br><br>$reporterrori";
        echo "</body>";
    echo "</html>";