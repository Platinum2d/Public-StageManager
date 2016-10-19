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
                                        $sql = "SELECT  `nome` ,  `cognome`, `id_studente`,`telefono`, `email`   FROM  `studente` where tutor_id_tutor=$id_tutor";
                                        $Result = $conn->query ( $sql );
                                        $I=0;
                                        while ( $row = $Result->fetch_assoc () ) {
                                            $id_studente = $row ['id_studente'];
                                            $nome = $row ['nome'];
                                            $cognome = $row ['cognome'];
                                            $email = $row ['email'];
                                            $telefono = $row ['telefono'];
                                            echo <<<HTML
                                            <form id="registroform$I" method="POST" action="registro.php"><input type="hidden" name="idstudente" value="$id_studente"> </form>
                                            <form id="valutazioneform$I" method="POST" action="valuta_studente.php"><input type="hidden" name="idstudente" value="$id_studente"> </form>
                                                <tr id="$id_tutor">
                                                    <td id="first">$nome</td>
                                                    <td id="last">$cognome</td>
                                                    <td id="mail">$email</td>
                                                    <td id="phone">$telefono</td>
                                                    <td>
                                                        <input type="button" name="registro_studente" value="Registro" onclick="redirectToRegistro($I)"></td>
                                                    <td>
                                                        <input type="button" name="valuta_studente" value="Valuta" onclick="redirectToValutazione($I)"></td>
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