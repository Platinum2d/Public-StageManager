<?php	
    include '../../../functions.php';
    header ( "Content-Type: application/xml" );
    $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?><data></data>
XML;
    $xml = new SimpleXMLElement ( $xmlstr );
    $db = dbConnection("../../../../");

    $idStudenteHasStage=$_POST["idStudenteHasStage"];
    $query_line = $db->query ("SELECT * 
                               FROM `lavoro_giornaliero` 
                               WHERE `lavoro_giornaliero`.`studente_has_stage_id_studente_has_stage` = $idStudenteHasStage  
                               ORDER BY `data` ASC;");
    while ( $work_line = $query_line->fetch_assoc () ) {
        $line = $xml->addChild ( "line" );
        $line->addChild ( "id", $work_line ['id_lavoro_giornaliero'] );
        $line->addChild ( "date", date("d-m-Y", strtotime($work_line['data'])) );
        $line->addChild ( "lavoro", xmlEscape($work_line ['lavoro_svolto'] ));
        $line->addChild ( "insegnamenti", xmlEscape($work_line ['insegnamenti'] ));
        if (isset($work_line ['commento'])) {
        	$commento = xmlEscape($work_line ['commento']);
        }
        else {
            $commento = "";
        }
        $line->addChild ( "commento", $commento);
    }
   echo $xml->asXML ();
?>