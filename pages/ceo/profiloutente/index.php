<?php
    include '../../functions.php';
    checkLogin ( ceoType , "../../../");
    import("../../../");
    open_html ( "Profilo" );
    $id_az = $_SESSION ['userId'];
    echo "<script src='profiloutente.js'></script>";
    $connessione = dbConnection ("../../../");
    $sql = "SELECT nome_responsabile, cognome_responsabile, telefono_responsabile, email_responsabile, username FROM azienda, utente WHERE id_azienda = id_utente AND id_azienda=$id_az";
    $result = $connessione->query ( $sql );
        
    while ( $row = $result->fetch_assoc () ) {
        $nome = $row ['nome_responsabile'];
        $cognome = $row ['cognome_responsabile'];
        $email = $row ['email_responsabile'];
        $telefono = $row ['telefono_responsabile'];
        $username = $row ['username'];
    }
?>
<body>
    <?php
        topNavbar ("../../../");
        titleImg ("../../../");
    ?>
    <!-- Begin Body -->
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <br>
                    <h1 style="display: inline">Il mio profilo </h1><h3 style="display: inline">(Informazioni personali del responsabile)</h3>
                    <br>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col col-sm-3" id='profilewrapper'>
                            <?php printProfileImageSection($connessione); ?>
                        </div>
                        <div class="col col-sm-9">
                            <div class="table-responsive"><table id="myInformations" class="table table-striped table-bordered" style="table-layout: fixed">
                                    <tr>
                                        <th class="col-sm-3">Username</th>
                                        <td id="username" class="col-sm-6"><?php echo $username; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Password</th>
                                        <td id="password"></td>
                                    </tr>
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
    <script>
        doSetupForProfileImage();
    </script>
</body>
<?php
    close_html ("../../../");
?>