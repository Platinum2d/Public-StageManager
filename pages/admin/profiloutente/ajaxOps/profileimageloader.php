<?php
    include "../../../functions.php";
    $conn = dbConnection("../../../../");
    checkLogin(adminType, "../../../../");
    import("../../../../");
    if (is_uploaded_file ( $_FILES ['profileimage'] ['tmp_name'] ))
    {
        $fileName = $_FILES ['profileimage'] ['name'];
        $filepath = "../../../../src/loads/profimgs/superusers/";
        if (move_uploaded_file ( $_FILES ['profileimage'] ['tmp_name'], $filepath . $fileName))
        {
            $query = "INSERT INTO immagine_profilo (URL, dimensione) VALUES ('superusers/$fileName', ".filesize($filepath . $fileName).")";
            $conn->query($query);
            $query = "UPDATE docente SET immagine_profilo_id_immagine_profilo = (SELECT MAX(id_immagine_profilo) FROM immagine_profilo) WHERE id_docente = ".$_SESSION['userId'];
            $conn->query($query);
            echo $conn->error;
            header ( "Location: ../index.php" );
        }
    }