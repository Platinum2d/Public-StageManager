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
        if (isset($_SESSION['email_sent']))
        {
            if ($_SESSION['email_sent'] === sent)
            {
                ?>
                    <script> printSuccess("Mail inviata correttamente", "<div align='center'>La mail è stata inviata correttamente.</div>");</script>
                <?php
            }
            else
            {
                ?>
                    <script> printError("Errore", "<div align='center'>Errore durante l'invio della mail. Si prega di riprovare.<br>Contattare un amministratore se il problema persiste.</div>");</script>
                <?php
            }
            unset($_SESSION['email_sent']);
        }
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
                                                                        <select style="width: 50%" class="form-control" name="email" id="destinatario">
    									<option value="0" selected>Seleziona</option>
                                 		<?php
                                            $connessione = dbConnection ("../../../");
                                            $sql1 = "SELECT id_studente, stud.nome, stud.cognome, stud.email 
                                                     FROM studente AS stud, studente_has_stage AS shs, classe_has_stage AS chs, anno_scolastico AS ass
                                                     WHERE stud.id_studente = shs.studente_id_studente 
                                                     AND shs.classe_has_stage_id_classe_has_stage = chs.id_classe_has_stage AND chs.anno_scolastico_id_anno_scolastico = ass.id_anno_scolastico 
                                                     AND shs.docente_tutor_id_docente_tutor = $id_docente 
                                                     AND ass.corrente = 1;";
                                            $result1 = $connessione->query ( $sql1 );
                                            if ($result1 && $result1->num_rows > 0)
                                            {
                                                while ( $row = $result1->fetch_assoc () ) 
                                                {
                                                    $nome_studente = $row ['nome'];
                                                    $cognome_studente = $row ['cognome'];
                                                    $email_studente = $row ['email'];
                                                    echo "<option value='$email_studente'>Studente - $cognome_studente $nome_studente</option>";
                                                }
                                            }
                                            
                                            $sql2 = "SELECT id_tutor, tut.nome, tut.cognome, tut.email 
                                                     FROM tutor AS tut, studente_has_stage AS shs, classe_has_stage AS chs, anno_scolastico AS ass
                                                     WHERE tut.id_tutor = shs.tutor_id_tutor 
                                                     AND shs.classe_has_stage_id_classe_has_stage = chs.id_classe_has_stage AND chs.anno_scolastico_id_anno_scolastico = ass.id_anno_scolastico 
                                                     AND shs.docente_tutor_id_docente_tutor = $id_docente 
                                                     AND ass.corrente = 1;";
                                            $result2 = $connessione->query ( $sql2 );
                                            if ($result2 && $result2->num_rows > 0)
                                            {
                                                while ( $row = $result2->fetch_assoc () ) 
                                                {
                                                    $nome_tutor = $row ['nome'];
                                                    $cognome_tutor = $row ['cognome'];
                                                    $email_tutor = $row ['email'];
                                                    echo "<option value='$email_tutor'>Tutor - $cognome_tutor $nome_tutor</option>";
                                                }
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