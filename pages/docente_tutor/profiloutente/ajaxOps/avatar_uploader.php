<?php
    include "../../../functions.php";
    $conn = dbConnection("../../../../");
    checkLogin(ceoType, "../../../../");
    import("../../../../");
    if (is_uploaded_file ( $_FILES ['profileimage'] ['tmp_name'] ))
    {
        $fileName = $_FILES ['profileimage'] ['name'];
        $filepath = "../../../../src/loads/profimgs/docs_tutor/";
        if (!file_exists($filepath)) {
            mkdir($filepath, 0777, true);
        }
        if (move_uploaded_file ( $_FILES ['profileimage'] ['tmp_name'], $filepath . $fileName))
        {
            $query = "INSERT INTO immagine_profilo (URL, dimensione) VALUES ('docs_tutor/$fileName', ".filesize($filepath . $fileName).")";
            $conn->query($query);
            $query = "UPDATE utente SET immagine_profilo_id_immagine_profilo = (SELECT MAX(id_immagine_profilo) FROM immagine_profilo) WHERE id_utente = ".$_SESSION['userId'];
            $conn->query($query);
            echo $conn->error;
            header ( "Location: ../index.php" );
        }
    }
?>