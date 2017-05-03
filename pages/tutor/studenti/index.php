<?php
    include '../../functions.php';
    checkLogin ( aztutType , "../../../" );
    open_html ( "Studenti" );
    import("../../../");
    echo "<script src='js/scripts_studenti.js'></script>";
    echo "<link href='css/styles.css' rel='stylesheet' type='text/css'>";
    $conn = dbConnection ("../../../");
        
    $id_tutor = $_SESSION ['userId'];        
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
                    <h1>Studenti</h1>
                    <div class="row">
                        <div class="col col-sm-12">
                            <div class="table-responsive"><table id="mainTable" class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th class="text-center">Nome</th>
                                            <th class="text-center">Cognome</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Telefono</th>
                                            <th class="text-center">Visita azienda</th>
                                            <th class="text-center">Azioni</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $sql = "SELECT studente.nome, studente.cognome, studente.id_studente, studente.telefono, studente.email, studente_has_stage.id_studente_has_stage, studente_has_stage.visita_azienda 
												FROM studente, studente_has_stage 
												WHERE studente_has_stage.tutor_id_tutor = $id_tutor 
												AND studente_has_stage.studente_id_studente = studente.id_studente;";
                                        $Result = $conn->query ( $sql );
                                        $I=0;
                                        while ( $row = $Result->fetch_assoc () ) {
                                            $id_studente_has_stage = $row ['id_studente_has_stage'];
                                            $nome = $row ['nome'];
                                            $cognome = $row ['cognome'];
                                            $email = $row ['email'];
                                            $telefono = $row ['telefono'];
                                            $visita_azienda = $row ['visita_azienda'];
                                            echo <<<HTML
                                                <tr id="$id_tutor" data-shs="$id_studente_has_stage">
                                                    <td id="first">$nome</td>
                                                    <td id="last">$cognome</td>
                                                    <td id="mail">$email</td>
                                                    <td id="phone">$telefono</td>
HTML;
                                   	?>
	                                    <td class="text-center"><input id="visita" type="checkbox" name="visita" data-visita="<?php echo $visita_azienda; ?>" <?php if ($visita_azienda) {echo "checked";}?>/></td>
	                                    <td class="text-center">
	                                        <form method="POST" action="registro.php" style="margin-bottom: 0;">
	                                            <input type="hidden" name="shs" value="<?php echo $id_studente_has_stage; ?>">
	                                            <button class="btn btn-info" name="registro_studente"<?php if (!$visita_azienda) {echo " disabled='disabled'";}?>><span class="glyphicon glyphicon-pencil"></span> Registro</button>
	                                        </form> 
	                                        <form method="POST" action="valutazione-studente.php" style="margin-bottom: 0;">
	                                            <input type="hidden" name="shs" value="<?php echo $id_studente_has_stage; ?>">
		                                        <button class="btn btn-info" name="valuta_studente"<?php if (!$visita_azienda) {echo " disabled='disabled'";}?>><span class="glyphicon glyphicon-education"></span> Valuta</button>
		                                    </form>
	                                    </td>
                                    </tr>
                                    <?php
                                        }
                                    ?>
                                    </tbody>
                                </table></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php 
    close_html("../../../");
?>