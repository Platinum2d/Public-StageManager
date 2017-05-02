<?php
    include '../../functions.php';
    checkLogin ( superUserType , "../../../");
    
    open_html ( "Profilo" );
    import("../../../");
    $id_doc = $_SESSION ['userId'];
    echo "<script src='profiloutente.js?7'></script>";
    $connessione = dbConnection ("../../../");
    $sql = "SELECT username, nome, cognome, email, telefono FROM super_user, utente WHERE id_super_user = ".$_SESSION['userId'] . " AND id_utente = id_super_user";
    $result = $connessione->query ( $sql );
        
    while ( $row = $result->fetch_assoc () ) {
        $nome = $row ['nome'];
        $cognome = $row ['cognome'];
        $email = $row ['email'];
        $telefono = $row ['telefono'];
        $username = $row ['username']; 
    }
?>
<body>
    <?php
        topNavbar ("../../../");
        titleImg ("../../../");          
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div id="mainpanel" class="panel">
                    <h1>Il mio profilo</h1>
                    <br>
                    <div class="row">
                        <div class="col col-sm-3" id='profilewrapper'>
                            <?php printProfileImageSection($connessione); ?>
                        </div>
                        <div class="col col-sm-9">
                            <div class="table-responsive" >
                                <table id="myInformations" class="table table-striped table-bordered">
                                    <tr>
                                        <th class="col-sm-3">Username</th>
                                        <td class="col-sm-6"><div class='edittextdiv' id="username" contenteditable="false"><?php echo $username; ?></div></td>
                                    </tr>
                                    <tr>
                                        <th>Password</th>
                                        <td id="password"></td>
                                    </tr>
                                    <tr>
                                        <th>Nome</th>
                                        <td><div id="first" class='edittextdiv' contenteditable="false"><?php echo $nome; ?></div></td>
                                    </tr>
                                    <tr>
                                        <th>Cognome</th>
                                        <td><div class='edittextdiv' id="last" contenteditable="false"><?php echo $cognome; ?></div></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td><div class='edittextdiv' id="mail" contenteditable="false"><?php echo $email; ?></div></td>
                                    </tr>
                                    <tr>
                                        <th>Telefono</th>
                                        <td><div class='edittextdiv' id="phone" contenteditable="false"><?php echo $telefono; ?></div></td>
                                    </tr>
                                </table>
                            </div>
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
