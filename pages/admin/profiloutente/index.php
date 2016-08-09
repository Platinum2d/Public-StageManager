<?php
    include '../../functions.php';
   checkLogin ( adminType , "../../../");
    import("../../../");
    open_html ( "Profilo" );
    $id_doc = $_SESSION ['userId'];
    echo "<script src='profiloutente.js'></script>";
    $connessione = dbConnection ("../../../");
    $sql = "SELECT * FROM docente WHERE id_docente=$id_doc";
    $result = $connessione->query ( $sql );
        
    while ( $row = $result->fetch_assoc () ) {
        $nome = $row ['nome'];
        $cognome = $row ['cognome'];
        $email = $row ['email'];
        $telefono = $row ['telefono'];
    }
?>
<body>
    <?php    
   // printBadge("../../../");
        topNavbar ("../../../");
        titleImg ("../../../");
        printChat("../../../");            
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Il mio profilo</h1>
                    <br>
                    <div class="row">
                        <div class="col col-sm-12">
                            <div class="table-responsive"><table id="myInformations" class="table table-striped">
                                <tr>
                                    <th class="col-sm-5">Nome</th>
                                    <td id="first" class="col-sm-5"><?php echo $nome; ?></td>
                                </tr>
                                <tr>
                                    <th>Cognome</th>
                                    <td id="last"><?php echo $cognome; ?></td>
                                </tr>
                                <tr>
                                    <th>Email</th>
                                    <td id="mail"><?php echo $email; ?></td>
                                </tr>
                                <tr>
                                    <th>Telefono</th>
                                    <td id="phone"><?php echo $telefono; ?></td>
                                </tr>
                            </table></div>
                            <button id="editButton" class="btn btn-warning btn-sm rightAlignment margin buttonfix">
                                <span class="glyphicon glyphicon-edit"></span>
                            </button>
                            <button id="saveButton" class="btn btn-success btn-sm rightAlignment margin buttonfix">
                                <span class="glyphicon glyphicon-ok"></span>
                            </button>
                            <button id="cancelButton" class="btn btn-danger btn-sm rightAlignment margin buttonfix">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
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