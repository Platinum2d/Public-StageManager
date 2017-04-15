<?php
    include '../../pages/functions.php';
    if (!isset($_SESSION ['type'])){
        header ("Location:../../index.php");
    }
    open_html ( "Le mie segnalazioni" );
    import("../../");
    $connessione = dbConnection ("../../");
    $id_utente = $_SESSION ['userId'];
    echo "<link href='css/styles.css' rel='stylesheet' type='text/css'>";
    echo "<script src='scripts/script.js'> </script>";
?>

<body>
    <?php
        topNavbar ("../../");
        titleImg ("../../");
            
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Le mie segnalazioni</h1><br>
                        
                    <table class="table table-hover">
                        <thead>
                        	<tr>
		                        <th style="text-align: center">Categoria</th>
		                        <th style="text-align: center">Oggetto</th>
		                        <th style="text-align: center">Data</th>
		                        <th style="text-align: center">Ora</th>
		                        <th style="text-align: center">Stato</th>
	                        </tr>
                        </thead>
                            
                            
                    <?php
                        $query = "SELECT id_segnala_problema, categoria, oggetto, data, ora, risolto 
                        			FROM segnala_problema AS sp
                        			WHERE sp.utente_id_utente = $id_utente
                        			ORDER BY data DESC;";
                        $result = $connessione->query($query);
                            
                        if ($result && $result->num_rows > 0)
                        {
                            while ($row = $result->fetch_assoc())
                            {
                                $id = $row['id_segnala_problema'];
                                $categoria = $row['categoria'];
                                $oggetto = $row['oggetto'];
                                $data = date("d-m-Y", strtotime($row['data']));
                                $ora = $row['ora'];
                                $risolto = intval ($row ['risolto']);
                                
                                if ($risolto) {
                                	$risolto_class = "success";
                                	$risolto = "Risolto";
                                }
                                else {
                                	$risolto_class = "danger";
                                	$risolto = "Non risolto";
                                }
                                                                      
                                echo "<tr class=\"segnalation $risolto_class\" name=\"$id\">";
                                    echo "<td>$categoria</td>";
                                    echo "<td>$oggetto</td>";
                                    echo "<td>$data</td>";
                                    echo "<td>$ora</td>";
                                    echo "<td>$risolto</td>";
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
    close_html ("../../");
?>