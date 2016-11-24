<?php
    include '../../functions.php';
    checkLogin ( doctutType , "../../../");
    open_html ( "Studenti" );
    $conn = dbConnection ("../../../");
    echo "<script src=\"script/script.js\"> </script>";
    import("../../../");   
    $id_doc = $_SESSION ['userId'];

?>

<body>
   	<?php
        topNavbar ("../../../");
        titleImg ("../../../");
        printChat("../../..");
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>I miei studenti</h1> <br>
                    <div class="row">
                        <div class="col col-sm-12">
                            <!--<div class="table-responsive">--><table id="mainTable" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Nome</th>
                                        <th>Cognome</th>
                                        <th>Email</th>
                                        <th>Telefono</th>
                                        <th>Azioni</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $sql = "SELECT  `nome` ,  `cognome`, `id_studente`,`telefono`, `email`,`azienda_id_azienda`,`valutazione_stage_id_valutazione_stage`,`valutazione_studente_id_valutazione_studente`  FROM  `studente` WHERE docente_id_docente=$id_doc";
                                        $Result = $conn->query ( $sql );
                                        $I=0;
                                        while ( $row = $Result->fetch_assoc () ) {
                                            $id_studente = $row ['id_studente'];
                                            $nome = $row ['nome'];
                                            $cognome = $row ['cognome'];
                                            $email = $row ['email'];
                                            $telefono = $row ['telefono'];
                                            $id_azienda = $row ['azienda_id_azienda'];
                                            $id_valutazione_studente = $row ['valutazione_stage_id_valutazione_stage'];
                                            $id_valutazione_azienda = $row ['valutazione_studente_id_valutazione_studente']; 
                                            echo <<<HTML
                                            <form action="registro.php" method="POST" id="registro$I" style="height:0px">
                                                            <input type="hidden" value="$id_studente" name="id_studente">
                                                            <input type="hidden" value="$nome" name="nome_studente">
                                                            <input type="hidden" value="$cognome" name="cognome_studente">
                                            </form>
                                            <tr id="$I">
                                                <td id="first">$nome</td>
                                                <td id="last">$cognome</td>
                                                <td id="mail">$email</td>
                                                <td id="phone">$telefono</td>
                                                <td> 
                                                <select class = "selectpicker" onchange="redirect($I, 
HTML;
                                            if (!isset($id_valutazione_studente)) echo "-1,";
                                            else echo "$id_valutazione_studente,";
                                            
                                            if (!isset($id_valutazione_azienda)) echo "-1)\" id=\"select$I\">";
                                            else echo "$id_valutazione_azienda)\" id=\"select$I\">";
                                            
                                            echo <<<HTML
                                                            <option selected disabled> Visualizza </option>
                                                            <optgroup>
                                                                <option value = "registro"> Registro </option>
                                                            </optgroup>
                                                            <optgroup>
                                                                <option value = "valutazioneazienda"> Valutazione dell'azienda </option>
                                                                <option value = "valutazionestudente"> Valutazione dello studente </option>
                                                            </optgroup>
                                                        </select> 
                                                    </td>
HTML;
                                            $I++;
                                        }
                                    ?>
                                </tbody>
                            </table><!--</div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php 
    close_html("../../../");
?>








