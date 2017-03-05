<?php
    include "../../../functions.php";
    $conn = dbConnection("../../../../");
    
    $id_scuola = $_SESSION['userId'];
    $password = md5($_POST['password']);
    
    $query = "UPDATE `utente` SET `password` = '$password' WHERE `id_utente` = $id_scuola";
    if($conn->query($query))
        echo "ok";
    else
        echo "non ok";
?>