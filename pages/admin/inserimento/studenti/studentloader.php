<?php    
    require '../../../../src/lib/PHPReader/Classes/PHPExcel.php';
    include "../../../../pages/functions.php";
    checkLogin(superUserType, "../../../../");
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
    
    function checkStudentRecursive($username){
        $connection = dbConnection("../../../../");
        $query = "SELECT id_studente FROM studente WHERE username = '".$conn->escape_string($username)."'";
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
                $query = "SELECT id_studente FROM studente WHERE username = '".$conn->escape_string($newuser)."'";
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
        if (is_uploaded_file ( $_FILES ['studentfile'] ['tmp_name'] ))
        {
            $fileName = $_FILES ['studentfile'] ['name'];
            echo "<h3 style=\"color:green\"> ==== CARICAMENTO EFFETTUATO CON SUCCESSO ==== </h3>";
            $filepath = "../../../../src/loads/";
            if (move_uploaded_file ( $_FILES ['studentfile'] ['tmp_name'], $filepath . $fileName)) {
                echo "<br><h3 style=\"color:green\"> ==== FILE SPOSTATO CON SUCCESSO ==== </h3><br><br><br>";
                //analisi delle classi. Se non ne esiste una, creala.
                echo "<b>Estraggo e inizializzo i parametri del file excel.....</b><br>";
                        $reader = PHPExcel_IOFactory::createReaderForFile("../../../../src/loads/" . $fileName);
                        $loadedfile = $reader->load("../../../../src/loads/" . $fileName);
                        $sheet = $loadedfile->getSheet(0);
                        $rows = $sheet->getHighestRow();
                        $cols = $sheet->getHighestColumn();
                echo "<b>Fatto (trovate $rows righe)</b><br><br>";
                echo "<b>Controllo le classi......</b><br>";
                for ($I=2; $I<$rows;$I++)
                {
                    $classecorrente = $sheet->getCell('C'.$I)->getValue();
                    $classecorrente = trim($classecorrente);
                    $classecorrente = strtolower($classecorrente);
                    if (isset($classecorrente) && !empty($classecorrente))
                    {
                        $query = "SELECT `nome` FROM `classe` WHERE `nome` = '$classecorrente'";
                        $result = $conn->query($query);
                        if (!$result || $result->num_rows === 0)
                        {
                            echo "Trovata una nuova classe ($classecorrente), inserimento nel database....<br>";
                            $conn->query("INSERT INTO classe (nome, specializzazione_id_specializzazione) VALUES ('$classecorrente', (SELECT id_specializzazione FROM specializzazione WHERE nome = 'Sconosciuta'))");
                            echo "Fatto<br>";
                        }
                    }
                }
                echo "<b>Fatto</b><br><br>";
                
                //analisi di nomi e cognomi, creazione dello username sul posto. Se uno esiste già, usa il progressivo
                echo "<b>Creo gli username e inserisco gli studenti nel database....</b><br>";
                $htmltable = "<table class=\"table table-hover\"> <thead> <th>Username</th> <th>Password</th> <th>Citta'</th> <th>Classe</th> <th>Mail</th> <th>Telefono</th> </thead> <tbody>";
                $reporterrori = "";
                
                    for ($I=2; $I<$rows;$I++)
                    {
                        $tentativi = 1;
                        $nome = (trim($sheet->getCell('A'.$I)->getValue()));
                        $cognome = (trim($sheet->getCell('B'.$I)->getValue()));
                        $classe = strtolower(trim($sheet->getCell('C'.$I)->getValue()));
                        if (isset($nome) && !empty($nome) && isset($cognome) && !empty($cognome) && isset($classe) && !empty($classe))
                        {
                            $username = $nome.$cognome;
                            $username = checkStudentRecursive($username);//verifica dell'esistenza del nome utente                            
                            $password = generateRandomString();
                            $cryptedPassword = md5($password);
                            $citta = strtolower(trim($sheet->getCell('D'.$I)->getValue()));
                                $citta = (empty($citta) || !isset($citta)) ? "Sconosciuta" : $citta;
                            $email = strtolower(trim($sheet->getCell('E'.$I)->getValue()));
                                $email = (empty($email) || !isset($email)) ? "Sconosciuta" : $email;
                            $telefono = strtolower(trim($sheet->getCell('F'.$I)->getValue()));
                                $telefono = (empty($telefono) || !isset($telefono)) ? "Sconosciuto" : $telefono;
                            
                            $insertquery = "INSERT INTO studente (username, password, nome, cognome, citta, email, telefono, AutorizzazioneRegistro, visita_azienda, classe_id_classe)"
                                            . " VALUES ('".$conn->escape_string($username)."','$cryptedPassword','".$conn->escape_string($nome)."','".$conn->escape_string($cognome)."','".$conn->escape_string($citta)."','".$conn->escape_string($email)."','".$conn->escape_string($citta)."', 1, 0, (SELECT id_classe FROM classe WHERE nome = '$classe'))";
                            if ($conn->query($insertquery))
                            {
                                echo "Generato l'utente $username <br><br>";
                                $htmltable .= "<tr> <td>$username</td> <td>$password</td> <td>$citta</td> <td>$classe</td> <td>$email</td> <td>$telefono</td> </tr>";
                            }
                            else
                            {
                                $htmltable .= "<tr> ERRORE </tr>";
                            }
                            
                        }
                        else
                        {
                            $reporterrori .= "<br><h3 style=\"color:red\"> ==== NOME, COGNOME E/O CLASSE NON IMPOSTATO/I ALLA RIGA $I ==== </h3>";
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