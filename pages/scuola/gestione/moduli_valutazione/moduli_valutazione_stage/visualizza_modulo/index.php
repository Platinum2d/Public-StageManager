<?php
    include '../../../../../functions.php';
    checkLogin ( scuolaType , "../../../../../../");
        
    $conn = dbConnection("../../../../../../");
    $idmodulo = $_POST['modulo'];
    $nomemodulo = $conn->query("SELECT nome FROM modulo_valutazione_stage WHERE id_modulo_valutazione_stage = $idmodulo")->fetch_assoc()['nome'];
    open_html ( $nomemodulo );
    import("../../../../../../");
    echo "<script src='script.js?2'> </script>";
    echo "<meta http-equiv=\"Content-Type\" content=\"text/html;charset=utf-8\">";
    $conn->set_charset("UTF8");
?>
<body>
 	<?php
        topNavbar ("../../../../../../");
        titleImg ("../../../../../../");
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-14">
                <div class="panel">
                    <h1>Modifica il modulo: <i><?php echo $nomemodulo; ?></i></h1>
                    <br>
                    <table style="table-layout: fixed" class="table table-bordered">
                        <thead>
                        <th style="width: 4%; background: white">#</th>
                        <th style="width: 30%; background: white">Righe del modulo</th>
                            <?php 
                                $colonne_query = "  SELECT id_colonna_modulo_stage, descrizione, risposta_multipla, numero_voce 
                                                    FROM colonna_modulo_stage 
                                                    WHERE modulo_valutazione_stage_id_modulo_valutazione_stage = $idmodulo 
                                                    ORDER BY numero_voce, descrizione ASC";
                                                        
                                $result_colonne = $conn->query($colonne_query);
                                if (is_object($result_colonne) && $result_colonne->num_rows > 0)
                                {
                                    while ($row = $result_colonne->fetch_assoc())
                                    {
                                        $idcolonna = $row['id_colonna_modulo_stage'];
                                        $descrizionecolonna = $row['descrizione'];
                                        $numerovoce = $row['numero_voce'];
                                        $multipla = $row['risposta_multipla'];
                                        
                                        echo "<th data-role='numero_voce' style='text-align:center' data-multiple='$multipla' data-position='$numerovoce' data-id='$idcolonna'>#$numerovoce $descrizionecolonna <span onclick='openEditModuleColumn(this)' style='cursor:pointer; color:orange' class='glyphicon glyphicon-pencil'></span></th>";
                                    }
                                }
                            ?>
                        <th style="width: 5%" style="text-align: center">
                            <div align='center'>
                                <span onclick="openAddColumn(<?php echo $idmodulo; ?>)" style="color:green; cursor: pointer" class="glyphicon glyphicon-plus"></span>
                            </div>
                        </th>
                        </thead>
                            
                        <tbody>
                            <?php
                                $righe_query = "    SELECT id_riga_modulo_stage, descrizione, numero_voce 
                                                    FROM riga_modulo_stage 
                                                    WHERE modulo_valutazione_stage_id_modulo_valutazione_stage = $idmodulo 
                                                    ORDER BY numero_voce, descrizione ASC";
                                                        
                                $result_righe = $conn->query($righe_query);
                                if (is_object($result_righe) && $result_righe->num_rows > 0)
                                {
                                    while ($row = $result_righe->fetch_assoc())
                                    {
                                        $idriga = $row['id_riga_modulo_stage'];
                                        $descrizioneriga = $row['descrizione'];
                                        $numerovoce = $row['numero_voce'];
                                        
                                        echo "<tr data-position='$numerovoce' data-id='$idriga'>
                                                <td data-role='numero_voce'>$numerovoce</td><td class='riga-modulo'>$descrizioneriga</td>";
                                            
                                        $result_colonne->data_seek(0);
                                        while ($row_colonna = $result_colonne->fetch_assoc())
                                        {
                                            $multipla = $row_colonna['risposta_multipla'];
                                            $idcolonna = $row_colonna['id_colonna_modulo_stage'];
                                            if ($multipla === "1")
                                            {
                                                $possibili_risposte_query = "SELECT * 
                                                                             FROM possibile_risposta_colonna_stage 
                                                                             WHERE colonna_modulo_stage_id_colonna_modulo_stage = $idcolonna 
                                                                             ORDER BY numero_voce ASC";
                                                $possibili_risposte_result = $conn->query($possibili_risposte_query);
                                                
                                                echo "<td>";
                                                    echo "<select class='form-control'>";
                                                    while ($row_possibilita = $possibili_risposte_result->fetch_assoc())
                                                    {
                                                        $nomepossibilita = $row_possibilita['opzione'];
                                                        echo "<option>$nomepossibilita</option>";
                                                    }
                                                    echo "</select>";
                                                echo "</td>";
                                            }
                                            else
                                                echo "<td> </td>";
                                        }
                                        echo "<td> </td>";
                                        echo "</tr>";
                                            
                                    }
                                }
                                echo "<tr>
                                        <td>
                                            <div align='center'>
                                                <span onclick='openAddRow($idmodulo)' style='color:green; cursor: pointer' class='glyphicon glyphicon-plus'></span>
                                            </div>
                                        </td>";
                                        for ($i = 0; $i < $result_colonne->num_rows + 1; $i++)
                                            echo "<td> </td>";
                                
                                echo "</tr>";
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ("../../../../../../");
?>