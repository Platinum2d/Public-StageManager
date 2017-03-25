<?php
    include "../../../functions.php";
    $conn = dbConnection("../../../../");
    checkLogin(ceoType, "../../../../");
    import("../../../../");
    $oldid = $conn->query("SELECT immagine_profilo_id_immagine_profilo AS id_immagine FROM utente WHERE id_utente = ".$_SESSION['userId'])->fetch_assoc()['id_immagine'];
    echo $_FILES ['profileimagechange'] ['tmp_name'];
    
    if (is_uploaded_file ( $_FILES ['profileimagechange'] ['tmp_name'] ))
    {
        $fileName = $_FILES ['profileimagechange'] ['name'];
        $filepath = "../../../../media/loads/profimgs/ceos/";
        
        if (move_uploaded_file ( $_FILES ['profileimagechange'] ['tmp_name'], $filepath . $fileName))
        {
            $query = "UPDATE immagine_profilo SET URL = 'ceos/$fileName', dimensione = ".filesize($filepath . $fileName)." WHERE id_immagine_profilo = $oldid";
            $url = $conn->query("SELECT URL FROM immagine_profilo WHERE id_immagine_profilo = $oldid")->fetch_assoc()['URL'];
            
            $conn->query($query);
            if (intval($conn->query("SELECT COUNT(id_immagine_profilo) AS count FROM immagine_profilo WHERE URL = '$url'")->fetch_assoc()['count']) === 0)
                unlink("../../../../media/loads/profimgs/$url");
            
            header ( "Location: ../index.php" );
        }
    }
    else
        echo "<br>non lo carico";