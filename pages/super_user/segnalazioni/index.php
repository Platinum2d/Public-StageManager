<?php
    include '../../functions.php';
    checkLogin ( superUserType , "../../../");
    import("../../../");
    echo "<script src='scripts/script.js'> </script>";
    open_html ( "Segnalazioni di problemi" );
    $connessione = dbConnection ("../../../");
    $risolto = $_GET['ris'];
?>
<style>
    .segnalation{
        cursor: pointer;
        text-align: center;
    }
</style>

<body>
    <?php
        topNavbar ("../../../");
        titleImg ("../../../");
            
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1> <?php if ($risolto === "0") echo "Segnalazioni da risolvere"; else echo "Segnalazioni risolte";?> </h1><br>
                        
                    <table class="table table-hover">
                        <thead>
                        <th style="text-align: center">Categoria</th>
                        <th style="text-align: center">Oggetto</th>
                        <th style="text-align: center">Data</th>
                        <th style="text-align: center">Ora</th>
                        <th style="text-align: center">Utente</th>
                        <th style="text-align: center">Tipo di utenza</th>
                        </thead>
                            
                            
                    <?php
                        $query = "SELECT id_utente, id_segnala_problema, categoria, oggetto, data, ora, username, tipo_utente FROM segnala_problema AS sp, utente AS u WHERE sp.utente_id_utente = u.id_utente AND risolto = $risolto ORDER BY data DESC";
                        $result = $connessione->query($query);
                            
                        if ($result->num_rows > 0)
                        {
                            while ($row = $result->fetch_assoc())
                            {
                                $utente = $row['id_utente'];
                                $id = $row['id_segnala_problema'];
                                $categoria = $row['categoria'];
                                $oggetto = $row['oggetto'];
                                $data = date("d-m-Y", strtotime($row['data']));
                                $ora = $row['ora'];                                
                                $username = $row['username'];
                                switch(intval($row['tipo_utente'])) { case 1: $tipo = "Scuola"; break; case 2: $tipo = "Docente referente"; break;case 3: $tipo = "Docente tutor"; break;case 4: $tipo = "Azienda"; break;
                                                                      case 5: $tipo = "Tutor aziendale"; break;case 6: $tipo = "Studente"; break;}
                                                                      
                                echo "<tr class=\"segnalation\" name=\"$id\">";
                                    echo "<td>$categoria</td>";
                                    echo "<td>$oggetto</td>";
                                    echo "<td>$data</td>";
                                    echo "<td>$ora</td>";
                                    echo "<td name='$utente' class='userCell'>$username</td>";
                                    echo "<td>$tipo</td>";
                                echo "</tr>";
                            }
                        }
                    ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ("../../../");
?>