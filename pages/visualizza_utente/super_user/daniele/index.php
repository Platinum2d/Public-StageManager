<?php
    include '../../../functions.php';
    import("../../../../");
    open_html ( "Manicardi Daniele" );
    $connessione = dbConnection ("../../../../");
?>
<body>
   	<?php
        topNavbar ("../../../../");
        titleImg ("../../../../");
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1 style="display: inline">Daniele Manicardi</h1><br><br>
                    <br>
                    <div class="row">
                        <div class="col col-sm-3" id="profilewrapper" align="center">
                            <img src="../../../../media/loads/profimgs/superusers/daniele_profilo.jpg" style="max-height: 255; max-width: 255">
                        </div>
                        <div class="col col-sm-9">
                            <div class="table-responsive">
                                <table style="height: 255px" id="myInformations" class="table table-striped" style="table-layout: fixed">
                                    <tr>
                                        <th class="col-sm-5">Nome</th>
                                        <td id="first" class="col-sm-5">Daniele</td>
                                    </tr><tr>
                                        <th>Cognome</th>
                                        <td id="city">Manicardi</td>
                                    </tr>
                                    <tr>
                                        <th>Telefono</th>
                                        <td id="address">334 9056026</td>
                                    </tr>
                                    <tr>
                                        <th>Mail</th>
                                        <td id="mail">manicardi215@gmail.com</td>
                                    </tr>
                                </table>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col col-sm-12" align="right">
                                    <h4 style="display: inline">Disponibile in qualsiasi momento anche su Social e Whatsapp</h4>
                                </div>
                            </div>
                                
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
                                                                            <script> $("#figurerichieste").tagsinput('add', "//<?php //echo $nome; ?>"); </script>    
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
    close_html ("../../../../");
?>