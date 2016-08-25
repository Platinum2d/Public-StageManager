<?php
    include '../../functions.php';
    checkLogin ( studType,"../../../" );
    open_html ( "Profilo" );
    import("../../../");
    $id_stud = $_SESSION ['userId'];
    echo "<script src='profiloutente.js'></script>";
    $connessione = dbConnection ("../../../");
    $sql = "SELECT * FROM studente WHERE id_studente=$id_stud";
    $result = $connessione->query ( $sql );
    while ( $row = $result->fetch_assoc () ) {
        $nome = $row ['nome'];
        $cognome = $row ['cognome'];
        $citta = $row ['citta'];
        $email = $row ['email'];
        $telefono = $row ['telefono'];
        $username = $row ['username'];
		//$preferenza = $row ['preferenza'];
    }
	$result = $connessione->query($sql);
?>
<body>
    <style>
        .minw{
            width: 65%;
        }
    </style>
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
                        <div class="col col-sm-12">
                            <div class="table-responsive"><table id="myInformations" class="table table-striped" style="table-layout:fixed"><tr>
                                    <th class="col-sm-5">Username</th>
                                        <td id="username" class="col-sm-5"><?php echo $username; ?></td>
                                    </tr>
                                    <tr>
                                        <th class="col-sm-5">Password</th>
                                        <td id="password" class="col-sm-5"></td>
                                    </tr>
                                    
                                    <tr>
                                        <th class="col-sm-5">Nome</th>
                                        <td id="first" class="col-sm-5"><?php echo $nome; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Cognome</th>
                                        <td id="last"><?php echo $cognome; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Citt&agrave;</th>
                                        <td id="city"><?php echo $citta; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td id="mail"><?php echo $email; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Telefono</th>
                                        <td id="phone"><?php echo $telefono; ?></td>
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
                        
                    <div class="row">
                        <div class="col col-sm-12">
                            <div class="table-responsive"><table class="table table-striped" style="margin-top: 50px; table-layout: fixed;">
                                    <tr>
                                        <th class="col-sm-5">Preferenze</th>
                                        <td class="col-sm-5" id="preference" contenteditable='false' class="minw"> 
                                        <?php 
                                            $Query = "SELECT preferenza.nome FROM `preferenza`,`studente`,`studente_has_preferenza`"
                                                    . " WHERE id_studente = studente_id_studente"
                                                    . " AND id_preferenza = preferenza_id_preferenza"
                                                    . " AND id_studente = ".$_SESSION['userId']." ORDER BY preferenza.nome ASC";
                                                        
                                            $result = $connessione->query($Query);
                                            $value = "";
                                            while ($row = $result->fetch_assoc())
                                            {
                                                $value .= $row['nome'] . ",";
                                            }
                                            echo " <input id=\"preferenceslist\" disabled=\"true\" type=\"text\" value=\"$value\" data-role=\"tagsinput\" /> <br><br><div id=\"HiddenAddBox\"><label name=\"addpr\">Aggiungi una preferenza:</label>";
                                                
                                            $query = "SELECT * FROM preferenza ORDER BY nome ASC";
                                            $result = $connessione->query($query);
                                            echo "<select id=\"addpreference\" class=\"form-control\" style=\"max-width : 350px\">";
                                            while ($row = $result->fetch_assoc()){ echo "<option value=\"".$row['id_preferenza']."\"> ".$row['nome']." </option>"; }
                                            echo "</select> <input id=\"btnaddpref\"  type=\"button\" class=\"btn btn-primary\" value=\"Aggiungi\" style=\"margin-top : 5px\"> </div>";
                                        ?>
                                        </td>
                                    </tr>
                                </table></div>
                                    
                            <button id="editButtonpreference" class="btn btn-warning btn-sm rightAlignment margin buttonfix" onclick="openPreferenceEdit()">
                                <span class="glyphicon glyphicon-edit"></span>
                            </button>
                                
                            <button id="cancelButtonpreference" class="btn btn-danger btn-sm rightAlignment margin buttonfix" onclick="closePreferenceEdit()">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#preferenza').prop('disabled', true);
        $('#preferenza').css('color', '#828282');
        $('#preferenceslist').on('itemRemoved', function (event){
            $.ajax({
                type : 'POST',
                url : 'ajaxOps/ajaxRemovePreference.php',
                data : { 'preferenza' : event.item },
                cache : false,
                success : function (msg)
                {
                    if (msg !== "ok")
                        alert("Eliminazione della preferenza non riuscita!");
                }
            });
        });
        
        $("#btnaddpref").click(function () {
            var toadd = $( "#addpreference option:selected" ).text();
            var current = $( "#preferenceslist" ).val();
            
            if (current.indexOf(toadd.trim()) === -1)
            {
                $('#preferenceslist').tagsinput('add', $( "#addpreference option:selected" ).text());                                        
                $.ajax({
                    type : 'POST',
                    url : 'ajaxOps/ajaxAddPreference.php',
                    data : { 'preferenza' : $( "#addpreference" ).val() },
                    cache : false,
                    success : function (msg)
                    {
                        if (msg !== "ok")
                            alert("Inserimento della preferenza non riuscita!");
                    }
                });
            }
        });
        $("#HiddenAddBox").hide();
    </script>
</body>
<?php
    close_html ();
?>