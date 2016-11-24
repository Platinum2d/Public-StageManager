<?php
    include '../../functions.php';
    checkLogin ( ceoType );
    open_html ( "Profilo" );
    $id_az = $_SESSION ['userId'];
    //echo "<script src='/pages/ceo/profiloutente/profiloutente.js'></script>";
    $connessione = dbConnection ();
    $sql = "SELECT nome_responsabile, cognome_responsabile, telefono_responsabile, email_responsabile FROM azienda WHERE id_azienda=$id_az";
    $result = $connessione->query ( $sql );
        
    while ( $row = $result->fetch_assoc () ) {
        $nome = $row ['nome_responsabile'];
        $cognome = $row ['cognome_responsabile'];
        $email = $row ['email_responsabile'];
        $telefono = $row ['telefono_responsabile'];
    }
?>
<body>
    <?php
        topNavbar ();
        titleImg ();
    ?>
    <!-- Begin Body -->
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Il mio profilo</h1>
                    <br>
                    <div class="row">
                        <div class="col col-sm-12">
                            <table id="myInformations" class="table table-striped">
                                <tr>
                                    <th >Nome</th>
                                    <td id="first" ><?php echo $nome; ?></td>
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
                            </table>
                            <button id="editButton" class="btn btn-warning btn-sm rightAlignment margin">
                                <span class="glyphicon glyphicon-edit"></span>
                            </button>
                            <button id="saveButton" class="btn btn-success btn-sm rightAlignment margin">
                                <span class="glyphicon glyphicon-ok"></span>
                            </button>
                            <button id="cancelButton" class="btn btn-danger btn-sm rightAlignment margin">
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