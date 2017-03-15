<?php
    include '../../functions.php';
    checkLogin ( aztutType , "../../../" );
    checkEmail();
    open_html ( "Contatta" );
    import("../../../");
    $id_tutor = $_SESSION ['userId'];
?>
<link href='css/contatta.css' rel='stylesheet' type='text/css'>
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
                            <form action="sendmail.php" method="POST" class="contact" name="contactForm">
                                <div class="form-group">
                                    <label for="destinatario" class="select">Seleziona lo studente o il tutor che intendi contattare:</label>
                                    <br>
                                    <select class="form-control" style="width:250px" name="email" id="destinatario">
                                        <option value="0" selected>Seleziona</option>
                                 		<?php
                                            $connessione = dbConnection ("../../../");
                                            $sql1 = "select studente.nome as nome_studente, studente.cognome as cognome_studente, studente.email as email_studente 
                                                        from studente, studente_has_stage 
                                                        where studente_has_stage.tutor_id_tutor = $id_tutor 
                                                        AND studente_has_stage.studente_id_studente = studente.id_studente;";
                                            $result1 = $connessione->query ( $sql1 );
                                            while ( $row = $result1->fetch_assoc () ) {
                                                $nome_studente = $row ['nome_studente'];
                                                $cognome_studente = $row ['cognome_studente'];
                                                $email_studente = $row ['email_studente'];
                                                echo "<option value='$email_studente'>Studente - $cognome_studente $nome_studente</option>";
                                            }
                                            $sql2 = "SELECT docente.nome as nome_docente, docente.cognome as cognome_docente, docente.email as email_docente 
                                                        FROM docente, studente_has_stage 
                                                        WHERE studente_has_stage.tutor_id_tutor = $id_tutor 
														AND studente_has_stage.docente_tutor_id_docente_tutor = docente.id_docente;";
                                            $result2 = $connessione->query ( $sql2 );
                                            while ( $result2 && $row = $result2->fetch_assoc () ) {
                                                $nome_docente = $row ['nome_docente'];
                                                $cognome_docente = $row ['cognome_docente'];
                                                $email_docente = $row ['email_docente'];
                                                echo "<option value='$email_docente'>Docente tutor - $cognome_docente $nome_docente</option>";
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
                                    <input class="btn btn-primary" type="submit" name="send" value="Invia"></input>
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