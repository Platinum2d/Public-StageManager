<?php
    $psw = $_POST['password'];
    $recoveredData = file_get_contents("../../../../../db.txt");
    $database = unserialize($recoveredData);
    
    if (($database['password']) === ($psw))
        echo "ok";
    else
        echo "non ok";
?>