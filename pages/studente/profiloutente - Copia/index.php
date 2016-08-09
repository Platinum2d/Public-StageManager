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
		//$preferenza = $row ['preferenza'];
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
                    <h1>Il mio profilo</h1>
                    <br>
                    <div class="row">
                        <div class="col col-sm-12">
                            <table id="myInformations" class="table table-striped">
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
                                <tr>
                                    <th>Preferenza</th>
                                    <td id="preference" contenteditable='false'> 
                                        <select id="preferenza" class = "form-control" style = "width : 200px">
											<?php
												$query = "select * from preferenza;";
												$result = $connessione->query($query);
												while($row = $result->fetch_assoc ()) {
													echo "<option>".$row['nome'];
													echo "</option>";
												}
												$query = "SELECT * FROM studente_has_preferenza WHERE studente_id_studente = ".$_SESSION['userId'];
												$result = $connessione->query($query);
												if($result->num_rows != 0) {
													$row = $result->fetch_assoc();
													$idpref = $row['preferenza_id_preferenza'];
													$query = "SELECT nome FROM preferenza WHERE id_preferenza = $idpref";
													$result = $connessione->query($query);
													$row = $result->fetch_assoc();
													$preferenzaEspressa = $row['nome'];
													echo "<input type=\"hidden\" id=\"preferenzaStudente\" value=\"$preferenzaEspressa\">";
													echo "<script>
															$('#preferenza > option').each(function() {
																if(this.text === $('#preferenzaStudente').val()) {
																	$('#preferenza').prop('selectedIndex', this.index);
																}
															}); 
															</script>";
												}	
											?>  
                                        </select> 
                                    </td>
                                </tr>
                                <script> 
                                    $('#preferenza').prop('disabled', true);
                                    $('#preferenza').css('color', '#828282');
                                </script>
                            </table>
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
</body>
<?php
    close_html ();
?>