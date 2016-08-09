<?php
    include '../../functions.php';
    checkLogin ( studType , "../../../");
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
    
    <script src="script.js"></script>
    
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Contatta</h1>
                    <br>
                    <div class="row">
                        <div class="col col-sm-10">
                            <div class="form-group">
                                <label for="destinatario" class="select">Seleziona il docente o il tutor che intendi contattare:</label>
                                <br>
                                <select name="email" id="destinatario" class="form-control" style="width: 400px">
                                    <option value="0" selected>Seleziona</option>
                                    <?php 
                                        $Query = "SELECT tutor.cognome, tutor.nome, tutor.email FROM studente, tutor WHERE id_studente = ".$_SESSION['userId']." AND id_tutor = tutor_id_tutor";
                                        $connessione = dbConnection("../../../");
                                        $result = $connessione->query($Query);
                                        if ($result->num_rows > 0)
                                        {
                                            while ($row = $result->fetch_assoc())
                                            {
                                                echo "<option value=\"".$row['email']."\"> Tutor aziendale - ".$row['cognome']." ".$row['nome']." </option>";
                                            }
                                        }
                                        
                                        $Query = "SELECT docente.nome, docente.cognome, docente.email FROM docente, studente WHERE id_studente = ".$_SESSION['userId']." AND id_docente = docente_id_docente";
                                        $result = $connessione->query($Query);
                                        if ($result->num_rows > 0)
                                        {
                                            while ($row = $result->fetch_assoc())
                                            {
                                                echo "<option value=\"".$row['email']."\"> Docente scolastico - ".$row['cognome']." ".$row['nome']." </option>";
                                            }
                                        }
                                    ?>
                                    
                                    
                                </select>
                                <br><br>
                            <div class="form-group">
                                <label for="obj">Oggetto:</label>
                                <input type="text" name="object" class="form-control" id="obj">
                            </div>
                            <div class="form-group">
                                <label for="comment">Messaggio:</label>
                                <textarea name="message" class="form-control" rows="5" id="comment"></textarea>
                                <br>
                                <input class="btn btn-primary" type="button" name="send" value="Invia" onclick="sendMail()">
                            </div>
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