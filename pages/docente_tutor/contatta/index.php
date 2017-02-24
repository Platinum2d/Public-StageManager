<?php
    include '../../functions.php';
    checkLogin(doctutType , "../../../");
    open_html ( "Contatta" );
    import("../../../");
    $id_docente = $_SESSION ['userId'];
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
					<h1>Contatta</h1>
					<br>
					<div class="row">
						<div class="col col-sm-10">
							<form action="Sendmail.php" method="POST" class="contact" name="contactForm">
								<div class="form-group">
									<label for="destinatario" class="select">Seleziona lo studente o il tutor che intendi contattare:</label>
									<br>
									<select name="email" id="destinatario">
    									<option value="0" selected>Seleziona</option>
                                 		<?php
                                            $connessione = dbConnection ("../../../");
                                            $sql1 = "select distinct studente.nome as nome_studente, studente.cognome as cognome_studente, studente.email as email_studente
                                                        from studente, docente
                                                        where docente.id_docente = $id_docente
                                                        AND docente.id_docente = studente.docente_id_docente;";
                                            $result1 = $connessione->query ( $sql1 );
                                            while ( $row = $result1->fetch_assoc () ) {
                                                $nome_studente = $row ['nome_studente'];
                                                $cognome_studente = $row ['cognome_studente'];
                                                $email_studente = $row ['email_studente'];
                                                echo "<option value='$email_studente'>Studente - $cognome_studente $nome_studente</option>";
                                            }
                                            $sql2 = "select distinct tutor.nome as nome_tutor, tutor.cognome as cognome_tutor, tutor.email as email_tutor
                                                        from studente, docente, tutor
                                                        where docente.id_docente = $id_docente
                                                        AND docente.id_docente = studente.docente_id_docente
                                                        AND studente.tutor_id_tutor = tutor.id_tutor;";
                                            $result2 = $connessione->query ( $sql2 );
                                            while ( $row = $result2->fetch_assoc () ) {
                                                $nome_tutor = $row ['nome_tutor'];
                                                $cognome_tutor = $row ['cognome_tutor'];
                                                $email_tutor = $row ['email_tutor'];
                                                echo "<option value='$email_tutor'>Tutor - $cognome_tutor $nome_tutor</option>";
                                            }                            
                                        ?>
                       				</select>
								</div>
            					<div class="form-group">
        							<label for="obj">Oggetto:</label>
        							<input type="text" name="object" class="form-control" id="obj">
        						</div>
        						<div class="form-group">
        							<label for="comment">Messaggio:</label>
        							<textarea name="message" class="form-control" rows="5" id="comment"></textarea>
        							<br>
        							<input class="btn btn-default" type="submit" name="send" value="Invia"></input>
        						</div>
        					</form>
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