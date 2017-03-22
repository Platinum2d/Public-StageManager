<?php
    
    include '../../../../functions.php';
    $connection = dbConnection("../../../../../");
    
    $figuraprofessionale = $connection->escape_string(strtolower(trim($_POST['nome'])));
    $settore = $_POST['settore'];
    
    $checkquery = "SELECT id_figura_professionale FROM figura_professionale WHERE nome = '$figuraprofessionale'";
    $resultcheck = $connection->query($checkquery);
    
    if (is_object($resultcheck) && $resultcheck->num_rows > 0)
    {
        $id_figura_gia_presente = $resultcheck->fetch_assoc()['id_figura_professionale'];
        $settorequery = "INSERT INTO settore_has_figura_professionale (settore_id_settore, figura_professionale_id_figura_professionale) VALUES ($settore, $id_figura_gia_presente)";        
        $checkassignmentquery = "SELECT id_settore_has_figura_professionale 
                                 FROM settore_has_figura_professionale WHERE figura_professionale_id_figura_professionale = $id_figura_gia_presente 
                                 AND settore_id_settore = $settore";
        
        $checkassignmentresult = $connection->query($checkassignmentquery);
        if (is_object($checkassignmentresult) && $checkassignmentresult->num_rows > 0)
        {
            echo "ok";
        }
        else
        {
            if ($connection->query($settorequery)) 
                echo "ok"; 
            else 
                echo $connection->error;
        }
    }
    else
    {
        $query = "INSERT INTO figura_professionale (nome) VALUES ('$figuraprofessionale')";
        $settorequery = "INSERT INTO settore_has_figura_professionale (settore_id_settore, figura_professionale_id_figura_professionale) VALUES ($settore, (SELECT MAX(id_figura_professionale) FROM figura_professionale))";
        $result = $connection->query($query);

        if ($result)
        {
            $settorequery = "INSERT INTO settore_has_figura_professionale (settore_id_settore, figura_professionale_id_figura_professionale) VALUES ($settore, (SELECT MAX(id_figura_professionale) FROM figura_professionale))";
            if ($connection->query($settorequery)) 
                echo "ok"; 
            else 
                echo $connection->error;
        }
    }
?>