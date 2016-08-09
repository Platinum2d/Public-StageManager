<?php
    include '../../functions.php';
    checkLogin ( adminType , "../../../");
    open_html ( "Assegnazione" );
    echo "<link href='stile.css' rel='stylesheet' type='text/css'>";
    echo "<script src='js/scripts.js'></script>";
    $conn = dbConnection ();
?>
<body>
 	<?php
        topNavbar ("../../../");
        titleImg ("../../../");
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Assegnazione aziende</h1>
                    <div class="row">
                        <div class="col col-sm-12">
                            <ul id="classes" class="nav nav-tabs">
     							<?php
                                    $query = "SELECT  `nome`, `id_classe` FROM  `classe` ";
                                    $result1 = $conn->query ( $query );
                                    while ( $row = $result1->fetch_assoc () ) {
                                        $nome = $row ['nome'];
                                        $idclasse = $row ['id_classe'];
                                        echo "<li>
                                                <a class='navbar-brand classe' href='javascript:void(0)'>
                                                    <input type='hidden' value='$idclasse' class='classe_id'/>
                                                    $nome
                                                </a>
                                            </li>";
                                    }
                                ?>
                            </ul>
                            <div id="messageSpace">
                                <p id="message" class="bg-success">
                                    Modifica avvenuta con successo.
                                </p>
                            </div>
                            
                            <div id="messagefFailureSpace">
                                <p id="FailureMessage" class="bg-danger">
                                    Modifica Fallita.
                                </p>
                            </div>
                            <div id="main">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ();
?>