<?php
    include '../../functions.php';
    checkLogin ( aztutType , "../../../" );
    open_html ( "Studenti" );
    import("../../../");
//     echo "<link href='" . prj_pages . "/tutor/studenti/stile.css' rel='stylesheet' type='text/css'>";
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
                            <div class="table-responsive"><table id="mainTable" class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Nome</th>
                                            <th>Cognome</th>
                                            <th>Email</th>
                                            <th>Telefono</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        $sql = "SELECT studente.nome, studente.cognome, studente.id_studente, studente.telefono, studente.email, studente_has_stage.id_studente_has_stage 
												FROM studente, studente_has_stage 
												WHERE studente_has_stage.tutor_id_tutor = $id_tutor 
												AND studente_has_stage.studente_id_studente = studente.id_studente;";
                                        $Result = $conn->query ( $sql );
                                        $I=0;
                                        while ( $row = $Result->fetch_assoc () ) {
                                            //$id_studente = $row ['id_studente'];
                                            $id_studente_has_stage = $row ['id_studente_has_stage'];
                                            $nome = $row ['nome'];
                                            $cognome = $row ['cognome'];
                                            $email = $row ['email'];
                                            $telefono = $row ['telefono'];
                                            echo <<<HTML
                                                <tr id="$id_tutor">
                                                    <td id="first">$nome</td>
                                                    <td id="last">$cognome</td>
                                                    <td id="mail">$email</td>
                                                    <td id="phone">$telefono</td>
                                                    <td><form id="registroform$I" method="GET" action="registro.php"><input type="hidden" name="shs" value="$id_studente_has_stage"> </form>
                                                        <input type="button" name="registro_studente" value="Registro" onclick="redirectToRegistro($I)"></td>
                                                    <td><form id="valutazioneform$I" method="GET" action="valuta_studente.php"><input type="hidden" name="shs" value="$id_studente_has_stage"> </form>
                                                        <input type="submit" name="valuta_studente" value="Valuta" onclick="redirectToValutazione($I)"></td>
                                                </tr>
HTML;
                                            $I++;
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
        
    <script>
        function redirectToRegistro(progressiv){
            $("#registroform"+progressiv).submit();
        }
        
        function redirectToValutazione(progressiv){
            $("#valutazioneform"+progressiv).submit();
        }
    </script>
</body>
<?php 
    close_html();
?>