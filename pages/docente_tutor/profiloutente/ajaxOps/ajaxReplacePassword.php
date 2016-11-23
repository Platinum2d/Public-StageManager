<?php
    include "../../../functions.php";
    $conn = dbConnection("../../../../");
    
    $iddocente = $_SESSION['userId'];
    $password = md5($_POST['password']);
    
    $query = "UPDATE `docente` SET `password` = '$password' WHERE `id_docente` = $iddocente";
    if($conn->query($query))
        echo "ok";
    else
        echo "non ok";
?>