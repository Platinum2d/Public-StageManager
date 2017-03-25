<?php
    include '../../functions.php';
    checkLogin(scuolaType, "../../../");
    open_html ( "Profilo" );
    import("../../../");
    $id_doc = $_SESSION ['userId'];
    echo "<script src='profiloutente.js'></script>";
    $connessione = dbConnection ("../../../");
    $sql = "SELECT * FROM utente, scuola WHERE id_utente = id_scuola AND id_scuola= $id_doc";
    $result = $connessione->query ( $sql );   
    while ( $row = $result->fetch_assoc () ) {
        $username = $row ['username'];
        $nome = $row ['nome'];
        $email = $row ['email'];
        $telefono = $row ['telefono'];
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
                    <h1>Il mio profilo</h1>
                    <br>
                    <div class="row">
                        
                        <div class="col col-sm-3"> 
                            <?php printProfileImageSection($connessione); ?>
                        </div>
                            
                        <div class="col col-sm-9">
                            <div class="table-responsive"><table id="myInformations" class="table table-striped table-bordered">
                                    <tr>
                                        <th class="col-sm-3">Username</th>
                                        <td id="username" class="col-sm-6"><?php echo $username; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Password</th>
                                        <td id="password"></td>
                                    </tr>
                                    <tr>
                                        <th>Nome</th>
                                        <td id="first"><?php echo $nome; ?></td>
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