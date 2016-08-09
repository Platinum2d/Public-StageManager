<?php
    include '../../functions.php';
    checkLogin ( doctutType , "../../../");
    open_html ( "Studenti" );
    $conn = dbConnection ("../../../");
    import("../../../");
    
    $id_doc = $_SESSION ['userId'];

?>

<script> $("#selectvalutazione")[0].selectedIndex = 0; </script>
<script> $("#selectvalutazione").selectedIndex = 0; </script>

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
                                        $sql = "SELECT  `nome` ,  `cognome`, `id_studente`,`telefono`, `email`,`azienda_id_azienda`,`valutazione_stage_id_valutazione_stage`,`valutazione_studente_id_valutazione_studente`  FROM  `studente` where docente_id_docente=$id_doc";
                                        $Result = $conn->query ( $sql );
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
                                                <tr id="$id_doc">
                                                    <td id="first">$nome</td>
                                                    <td id="last">$cognome</td>
                                                    <td id="mail">$email</td>
                                                    <td id="phone">$telefono</td>
                                                    <td> <select id=\"selectvalutazione\" ONCHANGE="location = this.options[this.selectedIndex].value;"> 
                                                        <option value="index.php"> Visualizza.... </option>
                                                        <option id="optionstudente" value="valutazione_studente.php?id_studente=$id_valutazione_studente&nomestudente=$nome&cognomestudente=$cognome"> Valutazione dello studente </option>
                                                        <option id="optionazienda" value="valutazione_azienda.php?id_valutazione=$id_valutazione_azienda&nomestudente=$nome&cognomestudente=$cognome"> Valutazione dell'azienda </option>
                                                        </select> 
                                                        <input type="submit" name="registro_studente" value="Registro" onclick="window.location.href='registro.php?id_studente=$id_studente'"></td>
                                                </tr>
HTML;
                                            
                                             echo "<script> $(\"#selectvalutazione\")[0].selectedIndex = 0; </script>";
//                                            if(!isset($id_valutazione_studente) || empty($id_valutazione_studente))
//                                            {
//                                                echo "<script> $('#optionstudente').attr('value',''); </script>";                                            
//                                            }
                                            
//                                            if(!isset($id_valutazione_azienda) || empty($id_valutazione_azienda))
//                                            {
//                                                echo "<script> $('#optionazienda').attr('value',''); </script>";                                            
//                                            }
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
</body>
<?php 
    close_html();
?>








