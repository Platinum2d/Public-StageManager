<?php
    include '../../../functions.php';
    import("../../../../");
    open_html ( "Manicardi Daniele" );
    $connessione = dbConnection ("../../../../");
    $query = "SELECT * FROM utente, super_user WHERE id_utente = id_super_user";
    $result = $connessione->query($query);
    if (is_object($result) && $result->num_rows > 0)
    while ($row = $result->fetch_assoc())
    {
        if (strtolower($row['cognome']) === "manicardi") break;
    }
    $nome = $row['nome'];
    $cognome = $row['cognome'];
    $telefono = $row['telefono'];
    $foto = (isset($row['immagine_profilo_id_immagine_profilo']) && !empty($row['immagine_profilo_id_immagine_profilo'])) ? $row['immagine_profilo_id_immagine_profilo'] : null;
    
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
                            <?php 
                                if ($foto !== null)
                                {
                                    $url = ($connessione->query("SELECT URL FROM immagine_profilo WHERE id_immagine_profilo = $foto")->fetch_assoc()['URL']);
                                    echo "<img src=\"../../../../media/loads/profimgs/$url\" style=\"max-height: 255; max-width: 255\">";
                                }
                                else
                                {
                                    echo "<img src=\"../../../../media/img/default_avatar_male.jpg\" style=\"max-height: 255; max-width: 255\">";
                                }
                            ?>
                            
                        </div>
                        <div class="col col-sm-9">
                            <div class="table-responsive">
                                <table style="height: 255px" id="myInformations" class="table table-striped" style="table-layout: fixed">
                                    <tr>
                                        <th class="col-sm-5">Nome</th>
                                        <td id="first" class="col-sm-5"><?php echo $nome; ?></td>
                                    </tr><tr>
                                        <th>Cognome</th>
                                        <td id="city"><?php echo $cognome; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Telefono</th>
                                        <td id="address"><?php echo $telefono; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Mail</th>
                                        <td id="mail"><?php echo EMAIL_DANIELE?></td>
                                    </tr>
                                </table>
                            </div>
                            <br>
                            <div class="row">
                                <div class="col col-sm-12" align="right">
                                    <h4 style="display: inline">Disponibile in qualsiasi momento anche su Social e Whatsapp</h4>
                                </div>
                            </div>
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