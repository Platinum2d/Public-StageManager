<?php
    include '../../functions.php';
    checkLogin ( aztutType , "../../../" );
    open_html ( "Profilo" );
    import("../../../");
    $id_tutor = $_SESSION ['userId'];
    echo "<script src='js/profiloutente.js?1'></script>";
    $connessione = dbConnection ("../../../");
    $sql = "SELECT nome, cognome, nome_aziendale, tutor.email, tutor.telefono, utente.username 
			FROM tutor, azienda, utente 
			WHERE id_utente = id_tutor 
			AND id_tutor = $id_tutor 
			AND id_azienda = azienda_id_azienda;";
    $result = $connessione->query ( $sql );
        
    while ( $row = $result->fetch_assoc () ) {
        $nome = $row ['nome'];
        $cognome = $row ['cognome'];
        $email = $row ['email'];
        $telefono = $row ['telefono'];
        $username = $row ['username'];
        $azienda = $row ['nome_aziendale'];
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
                    <h1 style="display: inline">Il mio profilo </h1>
                    <br>
                    <br>
                    <br>
                    <div class="row">
                        <div class="col col-sm-3" id='profilewrapper'>
                            <?php printProfileImageSection($connessione); ?>
                        </div>
                        <div class="col col-sm-9">
                            <div><table id="myInformations" class="table table-striped table-responsive table-bordered" style="table-layout: fixed">
                                    <tr>
                                        <th class="col-sm-3">Username</th>
                                        <td id="" class="col-sm-6"><div id="username" class='edittextdiv' contenteditable="false"><?php echo $username; ?></div></td>
                                    </tr>
                                    <tr>
                                        <th>Password</th>
                                        <td id="password"></td>
                                    </tr>
                                    <tr>
                                        <th>Nome</th>
                                        <td id=""><div id="first" class='edittextdiv' contenteditable="false"><?php echo $nome; ?></div></td>
                                    </tr>
                                    <tr>
                                        <th>Cognome</th>
                                        <td id=""><div id="last" class='edittextdiv' contenteditable="false"><?php echo $cognome; ?></div></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td id=""><div id="mail" class='edittextdiv' contenteditable="false"><?php echo $email; ?></div></td>
                                    </tr>
                                    <tr>
                                        <th>Telefono</th>
                                        <td id=""><div id="phone" class='edittextdiv' contenteditable="false"><?php echo $telefono; ?></div></td>
                                    </tr>
                                    <tr>
                                        <th>Azienda</th>
                                        <td id=""><div id="company" class='edittextdiv' contenteditable="false"><?php echo $azienda; ?></div></td>
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