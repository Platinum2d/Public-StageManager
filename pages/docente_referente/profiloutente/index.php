<?php
    include '../../functions.php';
    checkLogin ( docrefType , "../../../");
    open_html ( "Profilo" );
    import("../../../");
    $id_doc = $_SESSION ['userId'];
    echo "<script src='js/profiloutente.js'></script>";
    $connessione = dbConnection ("../../../");
    $sql = "SELECT nome, cognome, email, telefono, username 
    		FROM docente, utente 
    		WHERE id_docente=$id_doc
    		AND id_docente = id_utente;";
    $result = $connessione->query ( $sql );
    
    while ( $row = $result->fetch_assoc () ) {
        $nome = $row ['nome'];
        $cognome = $row ['cognome'];
        $email = $row ['email'];
        $telefono = $row ['telefono'];
        $username = $row ['username'];
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
                            <div class="table-responsive">
                            	<table id="myInformations" class="table table-striped" style="table-layout: fixed">
                                    <tr>
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