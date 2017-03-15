<?php
    include "../../../functions.php";
    $conn = dbConnection("../../../../");
    
    $idtutor = $_SESSION['userId'];
    $password = md5($_POST['password']);
    
    $query = "UPDATE `utente` 
    			SET `password` = '$password' 
    			WHERE `id_utente` = $idtutor";
    if($conn->query($query))
        echo "ok";
    else
        echo "non ok";
?>