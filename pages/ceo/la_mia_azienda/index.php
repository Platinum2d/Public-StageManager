<?php
    include '../../functions.php';
    checkLogin ( ceoType , "../../../");
    import("../../../");
    open_html ( "La mia azienda" );
    $id_az = $_SESSION ['userId'];
    echo "<script src='miazienda.js'></script>";
    $connessione = dbConnection ("../../../");
    $sql = "SELECT nome_aziendale, citta_aziendale, indirizzo, telefono_aziendale, email_aziendale FROM azienda WHERE id_azienda=$id_az";
    $result = $connessione->query ( $sql );
        
    while ( $row = $result->fetch_assoc () ) {
        $nome = $row ['nome_aziendale'];
        $citta = $row ['citta_aziendale'];
        $indirizzo = $row ['indirizzo'];
        $email = $row ['email_aziendale'];
        $telefono = $row ['telefono_aziendale'];
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
                    <h1>La mia azienda</h1>
                    <br>
                    <div class="row">
                        <div class="col col-sm-12">
                            <div class="table-responsive"><table id="myInformations" class="table table-striped" style="table-layout: fixed">
                                    <tr>
                                        <th class="col-sm-5">Nome</th>
                                        <td id="first" class="col-sm-5"><?php echo $nome; ?></td>
                                    </tr><tr>
                                        <th>Citt&agrave;</th>
                                        <td id="city"><?php echo $citta; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Indirizzo</th>
                                        <td id="address"><?php echo $indirizzo; ?></td>
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
                                
                            <br>
                            <br>
                            <br>
                            <br>
                            <div class="table-responsive"><table class="table table-striped" style="table-layout: fixed">
                                    <tr>
                                        <td class="col-sm-5"><b>Figure professionali richieste</b></td>
                                        <td class="col-sm-5">
                                            <input class="form-control" data-role="tagsinput" id="figurerichieste">
                                            <script>$("#figurerichieste").tagsinput();</script>
                                            <span class="glyphicon glyphicon-question-sign" style="cursor: pointer" onclick="openGuide()"></span>
                                        <?php
                                            $query = "SELECT nome, id_figura_professionale FROM azienda_needs_figura_professionale AS anfp, figura_professionale AS fp "
                                                    . "WHERE anfp.figura_professionale_id_figura_professionale = fp.id_figura_professionale AND anfp.azienda_id_azienda = ".$_SESSION['userId'];
                                            $result = $connessione->query($query);
                                            while ($row = $result->fetch_assoc())
                                            {
                                                $nome = $row['nome'];
                                                $id = $row['id_figura_professionale'];
                                                ?>
                                            <script> $("#figurerichieste").tagsinput('add', "<?php echo $nome; ?>"); </script>    
                                                <?php
                                            }
                                        ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</body>
<?php
    close_html ("../../../");
?>