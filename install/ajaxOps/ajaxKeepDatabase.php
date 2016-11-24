<?php

    $host = $_POST['host'];
    $name = $_POST['name'];
    $user = $_POST['user'];
    $password = $_POST['password'];
    
    $connessione = new mysqli( $host, $user, $password, $name );
    if (mysqli_connect_error ()) echo mysqli_connect_errno ();
    else
    {
        $createfile = fopen("../../db.txt", "w");
        fclose($createfile);
        $serializedPOST = serialize($_POST);
        file_put_contents("../../db.txt", $serializedPOST);
        $okuser = fopen("../../okuser.txt","w");
        fclose($okuser);
        echo "ok";
    }