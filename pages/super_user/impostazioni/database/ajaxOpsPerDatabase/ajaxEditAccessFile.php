<?php    
    require_once "../../../../../db_config.php";
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
        $password = $dbpassword;
    }
    
    if ($overwrite) {
        $overwrite = "true";
    }
    else {
        $overwrite = "false";
    }
    if ($readytouse) {
        $readytouse = "true";
    }
    else {
        $readytouse = "false";
    }
    $php = "<?php\n" .
            "\t\$dbhost = \"$host\";\n" .
            "\t\$dbname = \"$name\";\n" .
            "\t\$dbuser = \"$user\";\n" .
            "\t\$dbpassword = \"$password\";\n" .
            "\t\$overwrite = $overwrite;\n" .
            "\t\$readytouse = $readytouse;\n" .
            "?>";
    if (file_put_contents('../../../../../db_config.php', $php)) {
        echo "ok";
    }
    else {
        echo "no ok";
    }
?>