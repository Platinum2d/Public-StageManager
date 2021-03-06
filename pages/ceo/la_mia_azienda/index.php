<?php
    include '../../functions.php';
    checkLogin ( ceoType , "../../../");
    
    open_html ( "La mia azienda" );
    import("../../../");
    $id_az = $_SESSION ['userId'];
    echo "<script src='miazienda.js?1'></script>";
    $connessione = dbConnection ("../../../");
    $sql = "SELECT nome_aziendale, citta_aziendale, indirizzo, telefono_aziendale, email_aziendale, sito_web, CAP FROM azienda WHERE id_azienda=$id_az";
    $result = $connessione->query ( $sql );
        
    while ( $row = $result->fetch_assoc () ) {
        $nome = $row ['nome_aziendale'];
        $citta = $row ['citta_aziendale'];
        $indirizzo = $row ['indirizzo'];
        $email = $row ['email_aziendale'];
        $telefono = $row ['telefono_aziendale'];
        $sito = $row ['sito_web'];
        $cap = $row ['CAP'];
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
                            <div class="table-responsive"><table id="myInformations" class="table table-striped table-bordered" style="table-layout: fixed">
                                    <tr>
                                        <th class="col-sm-5">Nome*</th>
                                        <td id="" class="col-sm-5"><div id="first" class='edittextdiv' contenteditable="false"><?php echo $nome; ?></div></td>
                                    </tr>
                                    <tr>
                                        <th>Citt&agrave;</th>
                                        <td id=""><div id="city" class='edittextdiv' contenteditable="false"><?php echo $citta; ?></div></td>
                                    </tr>
                                    <tr>
                                        <th>CAP</th>
                                        <td id=""><div id="cap" class='edittextdiv' contenteditable="false"><?php echo $cap; ?></div></td>
                                    </tr>
                                    <tr>
                                        <th>Indirizzo</th>
                                        <td id=""><div id="address" class='edittextdiv' contenteditable="false"><?php echo $indirizzo; ?></div></td>
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
                                        <th>Sito</th>
                                        <td id=""><div id="website" class='edittextdiv' contenteditable="false"><?php echo $sito; ?></div></td>
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
                                
<!--                            <br>
                            <br>
                            <br>
                            <br>
                            <div class="table-responsive"><table class="table table-striped" style="table-layout: fixed">
                                    <tr>
                                        <td class="col-sm-5"><b>Figure professionali richieste <script>document.write("(massimo "+figuresLimit+")")</script></b></td>
                                        <td class="col-sm-5">
                                            <input class="form-control" data-role="tagsinput" id="figurerichieste">
                                            <script>$("#figurerichieste").tagsinput({ maxTags: figuresLimit });</script>
                                            <span class="glyphicon glyphicon-question-sign" style="cursor: pointer" onclick="openGuide()"></span>
                                        <?php
//                                            $query = "SELECT nome, id_figura_professionale FROM azienda_needs_figura_professionale AS anfp, figura_professionale AS fp "
//                                                    . "WHERE anfp.figura_professionale_id_figura_professionale = fp.id_figura_professionale AND anfp.azienda_id_azienda = ".$_SESSION['userId'];
//                                            $result = $connessione->query($query);
//                                            if ($result->num_rows > 0)
//                                            {
//                                                while ($row = $result->fetch_assoc())
//                                                {
//                                                    $nome = $row['nome'];
//                                                    $id = $row['id_figura_professionale'];
//                                                    ?>
                                                <script> $("#figurerichieste").tagsinput('add', "//<?php echo $nome; ?>"); </script>    
                                                    //<?php
//                                                }
//                                            }
                                        ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>-->
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