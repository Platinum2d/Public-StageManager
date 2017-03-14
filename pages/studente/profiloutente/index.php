<?php
    include '../../functions.php';
    checkLogin ( studType,"../../../" );
    open_html ( "Profilo" );
    import("../../../");
    echo "<link href='css/profiloutente.css' rel='stylesheet' type='text/css'>";
    echo "<script src='js/profiloutente.js'></script>";
    
    $id_stud = $_SESSION ['userId'];
    $connessione = dbConnection ("../../../");
    
    $sql = "SELECT * FROM studente, utente WHERE id_studente=$id_stud AND id_utente=id_studente";
    $result = $connessione->query ( $sql );
    while ( $row = $result->fetch_assoc () ) {
        $nome = $row ['nome'];
        $cognome = $row ['cognome'];
        $citta = $row ['citta'];
        $email = $row ['email'];
        $telefono = $row ['telefono'];
        $username = $row ['username'];
    }
	$result = $connessione->query($sql);
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
                                        <td id="first" class="col-sm-5"><?php echo $nome;?></td>
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
                    <hr/>                        
                    <div class="row">
                        <div class="col col-sm-12">
                            <div class="table-responsive">
                            	<table id="preferencesTable" class="table table-bordered">
                                    <thead>
                                    	<tr>
                                            <th class="col-sm-8">Figura professionale</th>
                                            <th class="col-sm-2 centeredText">Priorità</th>
                                            <th class="col-sm-2 centeredText">Azioni</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col col-sm-12">
                            <div class="col col-sm-3">
                                <select id="selectFigura" class="form-control">
                                	<option>Seleziona un'opzione</option>
                                	<?php
                                		$query = "SELECT figura_professionale.id_figura_professionale, figura_professionale.nome
                                                	FROM figura_professionale, anno_scolastico, studente_attends_classe, classe, settore_has_figura_professionale
                                                	WHERE studente_attends_classe.studente_id_studente = $id_stud
                                                	AND studente_attends_classe.anno_scolastico_id_anno_scolastico = anno_scolastico.id_anno_scolastico
                                                	AND anno_scolastico.corrente = 1
                                                	AND studente_attends_classe.classe_id_classe = classe.id_classe
                                                	AND classe.settore_id_settore = settore_has_figura_professionale.settore_id_settore
                                                	AND settore_has_figura_professionale.figura_professionale_id_figura_professionale = figura_professionale.id_figura_professionale
                                                	AND figura_professionale.id_figura_professionale NOT IN (SELECT figura_professionale_id_figura_professionale
                                                																FROM studente_whises_figura_professionale
                                                																WHERE studente_whises_figura_professionale.studente_id_studente = $id_stud);";
    								    $result = $connessione->query ( $query );
    								    
    								    while ($result && $work_line = $result->fetch_assoc () ) {
    								    	$id_figura = $work_line ['id_figura_professionale'];
    								    	$nome_figura = $work_line ['nome'];
    								    	echo "<option value='$id_figura'>$nome_figura</option>";
        								}
                                	?>
                                </select>
                            </div>
                            <div class="col col-sm-3">
                                <button class="btn btn-success" onclick="addPreference();"><span class='glyphicon glyphicon-plus'></span>  Aggiungi</button>
                            </div>
                        </div>
                        <div class="col col-sm-12">
                        	<p>
                        		* Puoi indicare una preferenza come prioritaria o meno cliccando sull'apposita stella.
                        		** Solo una preferenza può essere impostata come prioritaria.
                        	</p>
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