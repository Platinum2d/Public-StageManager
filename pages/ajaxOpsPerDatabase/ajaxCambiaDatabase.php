<?php
    include "../functions.php";

    $database = "".$_POST['db'];
    
    $_SESSION['database'] = $database;
    
    echo $_SESSION['database'];
?>