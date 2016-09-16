<?php
    
    $user = $_POST['user'];
    $host = $_POST['host'];
    $name = $_POST['name'];
    $editpassword = $_POST['editpassword'];
    if ($editpassword)
    {
        $password = $_POST['password'];
    }
    else
    {
        $recoveredData = file_get_contents("../../../../../db.txt");
        $database = unserialize($recoveredData);
        $password = $database['password'];
    }
        
    $connessione = new mysqli( $host, $user, $password, $name );
    if ($connessione->error) 
        echo $connessione->error;
    else
    {
        $createfile = fopen("../../../../../db.txt", "w");        
        $serializedPOST = serialize($_POST);
        file_put_contents("../../../../../db.txt", $serializedPOST);
        fclose($createfile);
        $_SESSION['dbhost'] = $name;
        $_SESSION['dbuser'] = $user;
        $_SESSION['dbpassword'] = $password;
        $_SESSION['dbname'] = $name;
        echo "ok";
    }