<?php
    include '../../functions.php';
    checkLogin ( docrefType , "../../../");
    open_html ( "Profilo" );
    import("../../../");
    $id_doc = $_SESSION ['userId'];
    echo "<script src='js/profiloutente.js?1'></script>";
    $connessione = dbConnection ("../../../");
    $sql = "SELECT nome, cognome, email, telefono, username 
    		FROM docente, utente 
    		WHERE id_docente=$id_doc
    		AND id_docente = id_utente;";
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
                <div class="panel">
                    <br>
                    <h1 style="display: inline">Il mio profilo </h1>
                    <br>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col col-sm-3" id='profilewrapper'>
                            <?php printProfileImageSection($connessione); ?>
                        </div>
                        <div class="col col-sm-9">
                            <div>
                                <table id="myInformations" class="table table-striped table-responsive table-bordered" style="table-layout: fixed">
                                    <tr>
                                        <th class="col-sm-3">Username</th>
                                        <td class="col-sm-6"><div class='edittextdiv' contenteditable="false" id="username"><?php echo $username; ?></div></td>
                                    </tr>
                                    <tr>
                                        <th>Password</th>
                                        <td id="password"></td>
                                    </tr>
                                    <tr>
                                        <th>Nome</th>
                                        <td id=""><div class='edittextdiv' contenteditable="false" id="first"><?php echo $nome; ?></div></td>
                                    </tr>
                                    <tr>
                                        <th>Cognome</th>
                                        <td id=""><div class='edittextdiv' contenteditable="false" id="last"><?php echo $cognome; ?></div></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td id=""><div class='edittextdiv' contenteditable="false" id="mail"><?php echo $email; ?></div></td>
                                    </tr>
                                    <tr>
                                        <th>Telefono</th>
                                        <td id=""><div class='edittextdiv' contenteditable="false" id="phone"><?php echo $telefono; ?></div></td>
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