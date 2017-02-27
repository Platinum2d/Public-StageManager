<?php    
    require '../../../../lib/PHPExcel.php';
    include "../../../../pages/functions.php";
    checkLogin(superUserType, "../../../../");
    $conn = dbConnection("../../../../");
    import("../../../../");
    
    function checkSpecExistence($spec){
        $connessione = dbConnection("../../../../");
        $query = "SELECT id_specializzazione FROM specializzazione WHERE nome = '".$connessione->escape_string($spec)."'";
        $result = $connessione->query($query);
        if (!$result || $result->num_rows === 0)
        {
            return false;
        }
        else
        {
            return true;
        }
    }
    
    echo "<html>";
        echo "<head>";
        
        echo "</head>";
        
        echo "<body>";
        if (is_uploaded_file ( $_FILES ['specfile'] ['tmp_name'] ))
        {
            $fileName = $_FILES ['specfile'] ['name'];
            echo "<h3 style=\"color:green\"> ==== CARICAMENTO EFFETTUATO CON SUCCESSO ==== </h3>";
            $filepath = "../../../../media/loads/";
            if (move_uploaded_file ( $_FILES ['specfile'] ['tmp_name'], $filepath . $fileName)) {
                echo "<br><h3 style=\"color:green\"> ==== FILE SPOSTATO CON SUCCESSO ==== </h3><br><br><br>";
                //analisi delle classi. Se non ne esiste una, creala.
                echo "<b>Estraggo e inizializzo i parametri del file excel.....</b><br>";
                        $reader = PHPExcel_IOFactory::createReaderForFile("../../../../media/loads/" . $fileName);
                        $loadedfile = $reader->load("../../../../media/loads/" . $fileName);
                        $sheet = $loadedfile->getSheet(0);
                        $rows = $sheet->getHighestRow();
                        $cols = $sheet->getHighestColumn();
                echo "<b>Fatto (trovate $rows righe)</b><br><br>";
                
                echo "<b>Creo gli username e inserisco gli studenti nel database....</b><br>";
                $htmltable = "<table class=\"table table-hover\"> <thead> <th>Nome</th></thead> <tbody>";
                $reporterrori = "";
                
                    for ($I=2; $I<$rows;$I++)
                    {
                        $tentativi = 1;
                        $nome = strtolower(trim($sheet->getCell('A'.$I)->getValue()));
                        $exists = checkSpecExistence($nome);
                        if (isset($nome) && !empty($nome))
                        {
                            if(!$exists)
                            {
                                $insertquery = "INSERT INTO specializzazione (nome) VALUES ('".$conn->escape_string($nome)."')";
                                if ($conn->query($insertquery))
                                {
                                    echo "Generato la specializzazione $nome <br><br>";
                                    $htmltable .= "<tr> <td>$nome</td></tr>";
                                }
                                else
                                {
                                    $htmltable .= "<tr> ERRORE </tr>";
                                }
                            }
                            else
                            {
                                $reporterrori .= "<br><h3 style=\"color:red\"> ==== SPECIALIZZAZIONE GIA' ESISTENTE ALLA RIGA $I ==== </h3>";
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
?>