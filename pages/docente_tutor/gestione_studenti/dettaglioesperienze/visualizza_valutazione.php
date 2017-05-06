<?php
    include '../../../functions.php';
    checkLogin(doctutType, "../../../../");
    
    $shs = $_POST['shs'];
    $tb = $_POST['tb'];
    $title = ($tb === "stage") ? "Valutazione dell'azienda" : "Valutazione dello studente";
    
    open_html($title);
    import("../../../../");    
    echo "<script src=\"scripts.js?2\"> </script>";
    
    $conn = dbConnection("../../../../");
    $conn->set_charset("UTF8");
    
    $nomestudente = $conn->query("SELECT nome FROM studente_has_stage AS shs, studente AS s WHERE shs.studente_id_studente = s.id_studente AND shs.id_studente_has_stage = $shs")->fetch_assoc()['nome'];
    $cognomestudente = $conn->query("SELECT cognome FROM studente_has_stage AS shs, studente AS s WHERE shs.studente_id_studente = s.id_studente AND shs.id_studente_has_stage = $shs")->fetch_assoc()['cognome'];
    
    $nomeazienda = $conn->query("SELECT nome_aziendale AS nome FROM studente_has_stage AS shs, azienda AS a WHERE shs.azienda_id_azienda = a.id_azienda AND shs.id_studente_has_stage = $shs")->fetch_assoc()['nome'];
    
    $chs_result = $conn->query("SELECT classe_has_stage_id_classe_has_stage FROM studente_has_stage WHERE id_studente_has_stage = $shs");
    if (is_object($chs_result) && $chs_result->num_rows > 0) $chs = $chs_result->fetch_assoc()['classe_has_stage_id_classe_has_stage']; else $chs = null;
    
    ?>

<style>
    .margin_bottom_input{
        margin-bottom: 6px
    }
    
    .margin_bottom_label{
        margin-bottom: 0px
    }
</style>

<body>
    
    <?php
        topNavbar("../../../../");    
        titleImg("../../../../");
    ?>
    
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <?php 
                        if ($tb === "stage") 
                            echo "<h3>Valutazione dell'azienda <u><i>$nomeazienda</i></u> da parte dello studente <u><i>$nomestudente $cognomestudente</i></u></h3>";
                        else
                            echo "<h3>Valutazione dello studente <u><i>$nomestudente $cognomestudente</i></u> da parte dell'azienda <u><i>$nomeazienda</i></u></h3>";
                    ?>
                    <br><br>    
                    <table style='table-layout: fixed' id="mainTable" class="table table-bordered">
                        <thead style="background: #ddd">
                        <th style="width: 20%; background:white"></th>
                            <?php
                                $query_colonne = "SELECT id_colonna_modulo_$tb, cms.descrizione "
                                . "FROM classe_has_stage AS chs, modulo_valutazione_$tb AS mvs, colonna_modulo_$tb AS cms "
                                . "WHERE mvs.id_modulo_valutazione_$tb = chs.modulo_valutazione_".$tb."_id_modulo_valutazione_$tb "
                                . "AND cms.modulo_valutazione_".$tb."_id_modulo_valutazione_$tb = mvs.id_modulo_valutazione_$tb "
                                . "AND chs.id_classe_has_stage = $chs";
                                
                                $result_colonne = $conn->query($query_colonne);
                                if (is_object($result_colonne) && $result_colonne->num_rows > 0)
                                {
                                    while ($row = $result_colonne->fetch_assoc())
                                    {
                                        $descrizione = $row['descrizione'];
                                        
                                        echo "<th style='text-align:center'>$descrizione</th>";
                                    }
                                }                            
                            ?>
                        </thead>
                        
                        <tbody>
                            <?php
                                $query_righe = "SELECT rms.id_riga_modulo_$tb, rms.descrizione "
                                . "FROM classe_has_stage AS chs, modulo_valutazione_$tb AS mvs, riga_modulo_$tb AS rms "
                                . "WHERE mvs.id_modulo_valutazione_$tb = chs.modulo_valutazione_".$tb."_id_modulo_valutazione_$tb "
                                . "AND rms.modulo_valutazione_".$tb."_id_modulo_valutazione_$tb = mvs.id_modulo_valutazione_$tb "
                                . "AND chs.id_classe_has_stage = $chs";
                                
                                $result = $conn->query($query_righe);
                                if (is_object($result) && $result->num_rows > 0)
                                {                                    
                                    while ($row = $result->fetch_assoc())
                                    {
                                        $result_colonne->data_seek(0);
                                        $id = $row["id_riga_modulo_$tb"];
                                        $descrizione = $row['descrizione'];
                                        
                                        echo "<tr>";
                                        echo "<td align='center'>$descrizione</td>";                                        
                                            while ($rowcolonna = $result_colonne->fetch_assoc())
                                            {
                                                $idcolonna = $rowcolonna["id_colonna_modulo_$tb"];
                                                
                                                $query_risposta =  "SELECT risposta "
                                                                 . "FROM risposta_voce_modulo_$tb "
                                                                 . "WHERE riga_modulo_".$tb."_id_riga_modulo_$tb = $id "
                                                                 . "AND colonna_modulo_".$tb."_id_colonna_modulo_$tb = $idcolonna "
                                                                 . "AND studente_has_stage_id_studente_has_stage = $shs";
                                                
                                                $result_risposta = $conn->query($query_risposta);
                                                if (is_object($result_risposta) && $result_risposta->num_rows > 0)
                                                {
                                                    $risposta = $result_risposta->fetch_assoc()['risposta'];
                                                    echo "<td align='center'>$risposta</td>";
                                                }
                                                else
                                                    echo "<td align='center' style='color:red'>Nessuna risposta</td>";
                                                
                                            }
                                        echo "</tr>";
                                    }
                                }
                            ?>
                        </tbody>
                    </table>
                    <br>
                    <br>
                </div>
            </div>
        </div>
    </div>
</body>

<?php
    close_html("../../../../");
