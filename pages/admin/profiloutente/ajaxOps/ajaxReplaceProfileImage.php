<?php
    include "../../../functions.php";
    $conn = dbConnection("../../../../");
    checkLogin(superUserType, "../../../../");
    import("../../../../");
    $oldid = $_POST['oldpictureid'];
    
    if (is_uploaded_file ( $_FILES ['profileimagechange'] ['tmp_name'] ))
    {
        $fileName = $_FILES ['profileimagechange'] ['name'];
        $filepath = "../../../../src/loads/profimgs/superusers/";
        if (move_uploaded_file ( $_FILES ['profileimagechange'] ['tmp_name'], $filepath . $fileName))
        {
            $query = "UPDATE immagine_profilo SET URL = 'superusers/$fileName', dimensione = ".filesize($filepath . $fileName)." WHERE id_immagine_profilo = $oldid";
            $conn->query($query);
            header ( "Location: ../index.php" );
        }
    }