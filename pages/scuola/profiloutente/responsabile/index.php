<?php
    include '../../../functions.php';
    checkLogin(scuolaType, "../../../../");
    open_html ( "Profilo personale del responsabile" );
    import("../../../../");
    $id_doc = $_SESSION ['userId'];
    echo "<script src='scripts/script.js?1'></script>";
    $connessione = dbConnection ("../../../../");
    $sql = "SELECT * FROM utente, scuola WHERE id_utente = id_scuola AND id_scuola= $id_doc";
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
        topNavbar ("../../../../");
        titleImg ("../../../../");
    ?>
    <!-- Begin Body -->
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1 style="display: inline">Il mio profilo </h1><h3 style="display: inline">(Informazioni personali del responsabile scolastico)</h3>
                    <br>
                    <br>
                        <div class="row">
                            
                        <div class="col col-sm-12">
                            <div class="table-responsive"><table id="myInformations" class="table table-striped table-bordered">
                                    <tr>
                                        <th class="col-sm-5">Nome</th>
                                        <td class="col-sm-5" id="">
                                            <div id="first" class='edittextdiv' contenteditable="false"><?php echo $nome; ?></div></td>
                                    </tr>
                                    <tr>
                                        <th>Cognome</th>
                                        <td id=""><div id="cognome" class='edittextdiv' contenteditable="false"><?php echo $cognome; ?></div></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td id=""><div id="mail" class='edittextdiv' contenteditable="false"><?php echo $email; ?></div></td>
                                    </tr>
                                    <tr>
                                        <th>Telefono</th>
                                        <td id=""><div id="phone" class='edittextdiv' contenteditable="false"><?php echo $telefono; ?></div></td>
                                    </tr>
                                </table></div>
                            <button id="editButton" class="btn btn-warning btn-sm rightAlignment margin buttonfix">
                                <span class="glyphicon glyphicon-edit spanfix"></span>
                            </button>
                            <button id="saveButton" class="btn btn-success btn-sm rightAlignment margin buttonfix">
                                <span class="glyphicon glyphicon-ok spanfix"></span>
                            </button>
                            <button id="cancelButton" class="btn btn-danger btn-sm rightAlignment margin buttonfix">
                                <span class="glyphicon glyphicon-remove spanfix"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ("../../../../");
?>
