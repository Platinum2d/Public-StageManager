<?php
    include '../../functions.php';
    checkLogin ( ceoType , "../../../");
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
                                    <select name="email" id="destinatario">
                                        <option value="0" selected>Seleziona</option>
                                 		<?php
                                            $connessione = dbConnection ("../../../");
                                            $Query = "SELECT cognome, nome FROM studente WHERE azienda_id_azienda = ".$_SESSION['userId']." ORDER BY cognome";
                                            $result = $connessione->query($Query);
                                            if ($result->num_rows > 0)
                                            {
                                                while ($row = $result->fetch_assoc())
                                                {
                                                    echo "<option> Studente - ".$row['cognome']." ".$row['nome']."</option>";
                                                }
                                            }
                                            
                                            $Query = "SELECT cognome, nome FROM tutor WHERE azienda_id_azienda = ".$_SESSION['userId']." ORDER BY cognome";
                                            $result = $connessione->query($Query);
                                            if ($result->num_rows > 0)
                                            {
                                                while ($row = $result->fetch_assoc())
                                                {
                                                    echo "<option> Tutor - ".$row['cognome']." ".$row['nome']."</option>";
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
    close_html ();
?>