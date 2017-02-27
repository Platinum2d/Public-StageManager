<?php
    include "../../../functions.php";
    $conn = dbConnection("../../../../");
    checkLogin(superUserType, "../../../../");
    import("../../../../");
    $oldid = $conn->query("SELECT immagine_profilo_id_immagine_profilo AS id_immagine FROM utente WHERE id_utente = ".$_SESSION['userId'])->fetch_assoc()['id_immagine'];
    
    if (is_uploaded_file ( $_FILES ['profileimagechange'] ['tmp_name'] ))
    {
        $fileName = $_FILES ['profileimagechange'] ['name'];
        $filepath = "../../../../media/loads/profimgs/superusers/";
        if (move_uploaded_file ( $_FILES ['profileimagechange'] ['tmp_name'], $filepath . $fileName))
        {
            $query = "UPDATE immagine_profilo SET URL = 'superusers/$fileName', dimensione = ".filesize($filepath . $fileName)." WHERE id_immagine_profilo = $oldid";
            $conn->query($query);
            header ( "Location: ../index.php" );
        }
    }
?>