   <?php
include '../functions.php';
function sessionInformation($usr, $userId, $type, $table) {
    session_start ();
    $_SESSION ['user'] = $usr;
    $_SESSION ['userId'] = $userId;
    $_SESSION ['type'] = $type;
    $_SESSION ['nameTable'] = $table;
    $_SESSION ['database'] = "1";
}

$usr = $_POST ["user"];
$psw = MD5 ( $_POST ["password"] );
$connessione = dbConnection ("../../");
$usr = $connessione->escape_string($usr);
/*
 * $query = "SELECT username, password, 'azienda' as type
 * FROM azienda
 * UNION
 * SELECT username, password, 'docente'
 * FROM docente
 * UNION
 * SELECT username, password, 'studente'
 * FROM studente
 * UNION
 * SELECT username, password, 'tutor'
 * FROM tutor;";
 * $result = $connessione->query($query);
 * while ($row = $result->fetch_assoc()) {
 * if($row['user']==$usr && $row['password']==$psw){
 * $tipo=$row['type'];
 * break;
 * }
 * }
 */
$tipo = 0;
$table = "docente";
$query = "SELECT id_docente, username, password, docente_referente, docente_tutor, super_user
            FROM $table
            WHERE username='$usr' AND password='$psw';";
$result = $connessione->query ( $query );
$numrows = $result->num_rows;
if ($numrows != 0) {
    $row = $result->fetch_assoc ();
    if ($row ["docente_referente"] == 1 && $row ["docente_tutor"] == 1 && $row ["super_user"] == 1) {
        $tipo = 1;
        $userId = $row ['id_docente'];
    } elseif ($row ["docente_referente"] == 1 && $row ["docente_tutor"] == 1 && $row ["super_user"] == 0) {
        $tipo = 2;
        $userId = $row ['id_docente'];
    } elseif ($row ["docente_referente"] == 1 && $row ["docente_tutor"] == 0 && $row ["super_user"] == 1) {
        $tipo = 1;
        $userId = $row ['id_docente'];
    } elseif ($row ["docente_referente"] == 1 && $row ["docente_tutor"] == 0 && $row ["super_user"] == 0) {
        $tipo = 2;
        $userId = $row ['id_docente'];
    } elseif ($row ["docente_referente"] == 0 && $row ["docente_tutor"] == 1 && $row ["super_user"] == 1) {
        $tipo = 1;
        $userId = $row ['id_docente'];
    } elseif ($row ["docente_referente"] == 0 && $row ["docente_tutor"] == 1 && $row ["super_user"] == 0) {
        $tipo = 3;
        $userId = $row ['id_docente'];
    } else {
        $tipo = 1;
        $userId = $row ['id_docente'];
    }
}
if ($tipo == 0) {
    $table = "azienda";
    $query = "SELECT id_azienda, username, password
                FROM $table
                WHERE username='$usr' AND password='$psw';";
    $result = $connessione->query ( $query );
    $numrows = $result->num_rows;
    if ($numrows != 0) {
        $row = $result->fetch_assoc ();
        $tipo = 4;
        $userId = $row ['id_azienda'];
    }
}
if ($tipo == 0) {
    $table = "studente";
    $query = "SELECT id_studente, username, password
                FROM  $table
                WHERE username='$usr' AND password='$psw';";
    $result = $connessione->query ( $query );
    $numrows = $result->num_rows;;
    if ($numrows != 0) {
        $row = $result->fetch_assoc ();
        $tipo = 6;
        $userId = $row ['id_studente'];
    }
}
if ($tipo == 0) {
    $table = "tutor";
    $query = "SELECT id_tutor, username, password
                FROM $table
                WHERE username='$usr' AND password='$psw';";
    $result = $connessione->query ( $query );
    $numrows = $result->num_rows;
    if ($numrows != 0) {
        $row = $result->fetch_assoc ();
        $tipo = 5;
        $userId = $row ['id_tutor'];
    }
}
if ($tipo != 0) {
    sessionInformation ( $usr, $userId, $tipo, $table );
}

$xmlstr = <<<XML
<?xml version="1.0" encoding="utf-8" ?>
<data>
</data>
XML;
$xml = new SimpleXMLElement ( $xmlstr );
$xml->addChild ( "tipo", $tipo );
echo $xml->asXML ();
?>