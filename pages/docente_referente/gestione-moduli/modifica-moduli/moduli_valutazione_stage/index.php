<?php
    include '../../../../functions.php';
    checkLogin ( docrefType , "../../../../../");
    open_html ( "Moduli stage" );
    import("../../../../../");
    echo "<script src='js/scripts.js'> </script>";
    
    $conn = dbConnection("../../../../../");
    $id_docente = $_SESSION['userId'];
    
    $query_scuola = "SELECT scuola_id_scuola
    FROM docente
    WHERE docente.id_docente = $id_docente;";
    if ($result = $conn->query($query_scuola)) {
        if ( $row = $result->fetch_assoc()) {
            $idscuola = $row ['scuola_id_scuola'];
        }
    }
?>
<body>
 	<?php
        topNavbar ("../../../../../");
        titleImg ("../../../../../");
    ?>
    <form id="redirectForm" method="POST" action="visualizza_modulo/index.php">
        <input name="modulo" type="hidden" value="">
    </form>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1> Moduli di valutazione degli stage</h1>
                    <br>
                    <div align="center">
                        <h4><u>Fare click su una riga per visualizzare il modulo contenuto</u></h4>
                    </div>
                    <br>
                    <table class="table table-hover table-responsive">
                        <thead>
                            <tr>
                                <th class="col-sm-3 text-center">
                                    Nome del modulo
                                </th>
                                <th class="col-sm-6 text-center">
                                    Descrizione del modulo
                                </th>
                                <th class="col-sm-3 text-center">
                                    Azioni
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $query = "SELECT *
                                      FROM modulo_valutazione_stage 
                                      WHERE scuola_id_scuola = $idscuola";
                                          
                            $result = $conn->query($query);
                                
                            if (is_object($result) && $result->num_rows > 0)
                            {
                                $i = 0;
                                while ($row = $result->fetch_assoc())
                                {
                                    $idmodulo = $row['id_modulo_valutazione_stage'];
                                    $nomemodulo = $row['nome'];
                                    $descrizionemodulo = $row['descrizione'];
                                        
                                    echo "<tr data-progressiv='$i' data-id='$idmodulo'>
                                            <td onclick='redirectToModule($idmodulo)' style='cursor:pointer;' name='nome' align='center'>$nomemodulo</td>
                                            <td onclick='redirectToModule($idmodulo)' style='cursor:pointer; text-align: justify; text-justify: inter-word;' name='descrizione'>$descrizionemodulo</td>
                                            <td align='center'>
                                                <button id='edit$i' onclick='openEdit($idmodulo, $i)' class='btn btn-success'><span class='glyphicon glyphicon-edit'></span> Modifica</button>
                                                <button onclick='askForDeleteModule($idmodulo, $i)' class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span> Elimina</button>    
                                            </td>
                                          </tr>";
                                    $i++;
                                }
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ("../../../../../");
?>