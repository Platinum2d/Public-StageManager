<?php
    include "../../../functions.php";
        $xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;

    $xml = new SimpleXMLElement ( $xmlstr );
    
    $conn = dbConnection("../../../../");
    $idtutor = $_POST['idtutor'];
    
    $query = "SELECT * FROM tutor WHERE id_tutor = $idtutor ";
    $result = $conn->query($query);
    
    $tutors = $xml->addChild('tutors');
    while ($row = $result->fetch_assoc())
    {
        $tutor = $tutors->addChild('tutor');
        $tutor->addChild('username',$row['username']);
        $tutor->addChild('nome',$row['nome']);
        $tutor->addChild('cognome',$row['cognome']);
        $tutor->addChild('telefono',$row['telefono']);
        $tutor->addChild('email',$row['email']);
        $resultstudent = $conn->query("SELECT cognome, nome FROM studente WHERE tutor_id_tutor = $idtutor");
        if ($resultstudent && $resultstudent->num_rows > 0)
        {
            $studenti = $tutor->addChild('studenti');
            while ($rowstudent = $resultstudent->fetch_assoc())
            {
                $studente = $studenti->addChild('studente');
                $studente->addChild('nome', $rowstudent['nome']);
                $studente->addChild('cognome', $rowstudent['cognome']);
            }        
        }
    }
    
    echo $xml->asXML();