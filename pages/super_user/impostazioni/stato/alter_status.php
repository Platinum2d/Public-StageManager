<?php
    include "../../../functions.php";
    require '../../../../sessione/stato-portale/status_config.php';
    checkLogin(superUserType, "../../../../");
        
    $stato = $_POST['status'];
        
    $php = "<?php\n" .
        "\t\$status = $stato;//true : online, false : offline\n" .
        "?>";
            
    if (file_put_contents('../../../../sessione/stato-portale/status_config.php', $php)) {
        header ( "Location: index.php" );
    }    