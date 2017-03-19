<?php
    
    require '../../../../lib/PHPExcel.php';
    include "../../../../pages/functions.php";
    checkLogin(superUserType, "../../../../");
    $conn = dbConnection("../../../../");
    import("../../../../");
    
    function checkClassExistence($classe)
    {
        $connection = dbConnection("../../../../");
        $query = "SELECT id_classe FROM classe WHERE nome = '".$connection->escape_string($classe)."'";
        $result = $connection->query($query);
        if (!$result || $result->num_rows === 0)
            return false;
        else
            return true;
    }
    
    echo "<html>";
        echo "<head>";
        
        echo "</head>";
        
        echo "<body>";
        if (is_uploaded_file ( $_FILES ['classesfile'] ['tmp_name'] ))
        {
            $fileName = $_FILES ['classesfile'] ['name'];
            echo "<h3 style=\"color:green\"> ==== CARICAMENTO EFFETTUATO CON SUCCESSO ==== </h3>";
            $filepath = "../../../../media/loads/";
            if (move_uploaded_file ( $_FILES ['classesfile'] ['tmp_name'], $filepath . $fileName)) {
                echo "<br><h3 style=\"color:green\"> ==== FILE SPOSTATO CON SUCCESSO ==== </h3><br><br><br>";
                //analisi delle classi. Se non ne esiste una, creala.
                echo "<b>Estraggo e inizializzo i parametri del file excel.....</b><br>";
                        $reader = PHPExcel_IOFactory::createReaderForFile("../../../../media/loads/" . $fileName);
                        $loadedfile = $reader->load("../../../../media/loads/" . $fileName);
                        $sheet = $loadedfile->getSheet(0);
                        $rows = $sheet->getHighestRow();
                        $cols = $sheet->getHighestColumn();
                echo "<b>Fatto (trovate $rows righe)</b><br><br>";
                echo "<b>Controllo le specializzazioni......</b><br>";
                for ($I=2; $I<$rows;$I++)
                {
                    $specializzazionecorrente = $sheet->getCell('B'.$I)->getValue();
                    $specializzazionecorrente = trim($specializzazionecorrente);
                    $specializzazionecorrente = strtolower($specializzazionecorrente);
                    if (isset($specializzazionecorrente) && !empty($specializzazionecorrente))
                    {
                        $query = "SELECT `nome` FROM `specializzazione` WHERE `nome` = '$specializzazionecorrente'";
                        $result = $conn->query($query);
                        if (!$result || $result->num_rows === 0)
                        {
                            echo "Trovata una nuova specializzazione ($specializzazionecorrente), inserimento nel database....<br>";
                            $conn->query("INSERT INTO specializzazione (nome) VALUES ('$specializzazionecorrente')");
                            echo "Fatto<br>";
                        }
                    }
                }
                echo "<b>Fatto</b><br><br>";
                
                //analisi di nomi e cognomi, creazione dello username sul posto. Se uno esiste già, usa il progressivo
                echo "<b>Inserisco le classi nel database....</b><br>";
                $htmltable = "<table class=\"table table-hover\"> <thead> <th>Nome</th> <th>Specializzazione</th> </thead> <tbody>";
                $reporterrori = "";
                
                    for ($I=2; $I<$rows;$I++)
                    {
                        $nome = (trim($sheet->getCell('A'.$I)->getValue()));
                        //se non c'è già la classe
                        $exists = checkClassExistence($nome);
                        $specializzazione = (trim($sheet->getCell('B'.$I)->getValue()));
                        if (isset($nome) && !empty($nome) && isset($specializzazione) && !empty($specializzazione))
                        {             
                            if (!$exists)
                            {
                                $insertquery = "INSERT INTO classe (nome, specializzazione_id_specializzazione) VALUES ('$nome', (SELECT id_specializzazione FROM specializzazione WHERE nome = '".$conn->escape_string($specializzazione)."'))";
                                if ($conn->query($insertquery))
                                {
                                    echo "Generata la classe $nome <br><br>";
                                    $htmltable .= "<tr> <td>$nome</td> <td>$specializzazione</td></tr>";
                                }
                                else
                                {
                                    $htmltable .= "<tr> ERRORE </tr>";
                                }
                            }
                            else
                            {
                                $reporterrori .= "<br><h3 style=\"color:red\"> ==== CLASSE GIA' ESISTENTE ALLA RIGA $I ==== </h3>";
                            }
                            
                        }
                        else
                        {
                            $reporterrori .= "<br><h3 style=\"color:red\"> ==== NOME E/O SPECIALIZZAZIONE NON IMPOSTATO/I ALLA RIGA $I ==== </h3>";
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