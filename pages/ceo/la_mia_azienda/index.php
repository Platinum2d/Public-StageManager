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
    <!-- Begin Body -->
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
                                        <td class="col-sm-5"><b>Specializzazioni</b></td>
                                        <td class="col-sm-5">
                                        <?php
                                            $Query = "SELECT specializzazione.nome FROM `specializzazione`,`azienda_has_specializzazione`,`azienda`"
                                            . " WHERE id_azienda = azienda_id_azienda"
                                            . " AND id_specializzazione = specializzazione_id_specializzazione"
                                            . " AND id_azienda = ".$_SESSION['userId']." ORDER BY specializzazione.nome ASC";
                                                
                                            $result = $connessione->query($Query);
                                            $value = "";
                                            while ($row = $result->fetch_assoc())
                                            {
                                                $value .= $row['nome'] . ",";
                                            }
                                            echo " <input id=\"speclist\" disabled=\"true\" type=\"text\" value=\"$value\" data-role=\"tagsinput\" /> <br><br><div id=\"HiddenAddBox\">";
                                                
                                            $query = "SELECT * FROM specializzazione WHERE nome != 'sconosciuta' AND  nome != 'Sconosciuta' ORDER BY nome ASC";
                                            $result = $connessione->query($query);
                                            echo "<select id=\"addspec\" class=\"form-control\" style=\"max-width : 350px\">";
                                            while ($row = $result->fetch_assoc()){ echo "<option value=\"".$row['id_specializzazione']."\"> ".$row['nome']." </option>"; }
                                            echo "</select> <input id=\"btnaddspec\"  type=\"button\" class=\"btn btn-primary\" value=\"Aggiungi\" style=\"margin-top : 5px\"> </div>";
                                        ?>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <button id="editButtonspec" class="btn btn-warning btn-sm rightAlignment margin buttonfix" onclick="openSpecEdit()">
                                <span class="glyphicon glyphicon-edit"></span>
                            </button>
                                
                            <button id="cancelButtonspec" class="btn btn-danger btn-sm rightAlignment margin buttonfix" onclick="closeSpecEdit()">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        $("input[type=\"text\"]").keydown(function (){ return false; });
        $('#speclist').on('itemRemoved', function (event){
            $.ajax({
                type : 'POST',
                url : 'ajaxOpsPerSpec/ajaxRemoveSpec.php',
                data : { 'specializzazione' : event.item },
                cache : false,
                success : function (msg)
                {
                    if (msg !== "ok")
                        alert("Eliminazione della specializzazione non riuscita!");
                }
            });
        });
        
        $("#btnaddspec").click(function (){
            var toadd = $( "#addspec option:selected" ).text();
            var current = $( "#speclist" ).val();

            if (current.indexOf(toadd.trim()) === -1)
            {
                $('#speclist').tagsinput('add', $( "#addspec option:selected" ).text());                                        
                $.ajax({
                    type : 'POST',
                    url : 'ajaxOpsPerSpec/ajaxAddSpec.php',
                    data : { 'id' : $( "#addspec" ).val() },
                    cache : false,
                    success : function (msg)
                    {
                        if (msg !== "ok")
                            alert("Inserimento della specializzazione non riuscito!");
                    }
                });
            }
        });
    </script>
</body>
<?php
    close_html ();
?>