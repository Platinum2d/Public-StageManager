<?php
    $psw = $_POST['password'];
    require_once "../../../../../db_config.php";
    
    if (($dbpassword) === ($psw))
        echo "ok";
    else
        echo "non ok";
?>