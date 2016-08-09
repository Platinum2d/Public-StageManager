<?php
    include '../../functions.php';
    checkLogin ( aztutType , "../../../" );
    checkEmail();
    open_html ( "Contatta" );
    import("../../../");
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
                    <h1>Contatta</h1>
                    <br>
                    <div class="row">
                        <div class="col col-sm-10">
                            <form action="Sendmail.php" method="POST" class="contact" name="contactForm">
                                <div class="form-group">
                                    <label for="destinatario" class="select">Seleziona lo studente o il tutor che intendi contattare:</label>
                                    <br>
                                    <select class="form-control" style="width:250px" name="email" id="destinatario">
                                        <option value="0" selected>Seleziona</option>
                                 		<?php
                                            $connessione = dbConnection ("../../../");
                                            $sql1 = "select distinct studente.nome as nome_studente, studente.cognome as cognome_studente, studente.email as email_studente
                                                        from studente, tutor
                                                        where tutor.id_tutor = $id_tutor
                                                        AND tutor.id_tutor = studente.tutor_id_tutor;";
                                            $result1 = $connessione->query ( $sql1 );
                                            while ( $row = $result1->fetch_assoc () ) {
                                                $nome_studente = $row ['nome_studente'];
                                                $cognome_studente = $row ['cognome_studente'];
                                                $email_studente = $row ['email_studente'];
                                                echo "<option value='$email_studente'>Studente - $cognome_studente $nome_studente</option>";
                                            }
                                            $sql2 = "select distinct docente.nome as nome_docente, docente.cognome as cognome_docente, docente.email as email_docente
                                                        from studente, docente, tutor
                                                        where tutor.id_tutor = $id_tutor
                                                        AND tutor.id_tutor = studente.tutor_id_tutor
                                                        AND studente.docente_id_docente = docente.id_docente;";
                                            $result2 = $connessione->query ( $sql2 );
                                            while ( $row = $result2->fetch_assoc () ) {
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
    close_html ();
?>