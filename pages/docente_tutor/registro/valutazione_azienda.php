<?php
    include '../../functions.php';
    checkLogin(doctutType , "../../../");
    open_html ( "Valutazione Studente" );
    import("../../../");
    $idval = $_GET['id_valutazione'];
    $nomestudente = $_GET['nomestudente'];
    $cognomestudente = $_GET['cognomestudente'];
    $conn = dbConnection ("../../../");  
    $query = "SELECT * FROM valutazione_studente WHERE id_valutazione_studente = $idval";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        $totale = intval($row['gestione_ambiente_spazio_lavoro']) + intval($row['collaborazione_comunicazione']) + intval($row['uso_strumenti']) + intval($row['rispetto_ambiente']) + intval($row['puntualita']) + intval($row['collaborazione_tutor'])
                + intval($row['lavoro_requisiti']) + intval($row['conoscenze_tecniche']) + intval($row['acquisire_nuove_conoscenze']) + intval($row['rispetta_norme_vigenti']);

        $media = $totale / 10;
    }
    topNavbar ("../../../");
    titleImg ("../../../");
    printChat("../../..");
    ?>

<body>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel"> 
                    <div class="row">
                        <a href="index.php"> Indietro </a>
                        <h2> VALUTAZIONE DELL'AZIENDA DI <i> <?php echo $cognomestudente." ".$nomestudente ?> </i></h2><br>
                        <div class="col col-sm-4">
                            Gestione ambiente e spazio lavoro <input id="example" class="form-control" type="text" value="<?php if ($result && $result->num_rows > 0) echo $row['gestione_ambiente_spazio_lavoro']; ?>">
                            Collaborazione e comunicazione <input class="form-control" type="text" value="<?php if ($result && $result->num_rows > 0) echo $row['collaborazione_comunicazione']; ?>">
                            Uso degli strumenti <input class="form-control" type="text" value="<?php if ($result && $result->num_rows > 0) echo $row['uso_strumenti']; ?>">
                            
                        </div>
                        
                        <div class="col col-sm-4">
                            Rispetto dell'ambiente <input class="form-control" type="text" value="<?php if ($result && $result->num_rows > 0) echo $row['rispetto_ambiente']  ?>">
                            Puntalita' <input class="form-control" type="text" value="<?php if ($result && $result->num_rows > 0) echo $row['puntualita'] ?>">
                            Collaborazione con il tutor aziendale <input class="form-control" type="text" value="<?php if ($result && $result->num_rows > 0) echo $row['collaborazione_tutor'] ?>">
                        </div>
                        
                        <div class="col col-sm-4">
                            Requisiti lavorativi <input class="form-control" type="text" value="<?php if ($result && $result->num_rows > 0) echo  $row['lavoro_requisiti'] ?>">
                            Conoscenza tecniche <input class="form-control" type="text" value="<?php if ($result && $result->num_rows > 0) echo $row['conoscenze_tecniche'] ?>">
                            Capacita' di acquisire nuove conoscenze <input class="form-control" type="text" value="<?php if ($result && $result->num_rows > 0) echo $row['acquisire_nuove_conoscenze'] ?>">
                            Rispetta le norme vigenti <input class="form-control" type="text" value="<?php if ($result && $result->num_rows > 0) echo $row['rispetta_norme_vigenti']  ?>">
                        </div>
                        <?php if ($result && $media >= 6 && $result->num_rows > 0) echo "<h3 style=\"color: green\"> Media della valutazione : $media</h3>"; else if ($result) echo "<h3 style=\"color: red\"> Media della valutazione : $media</h3>";?>
                        <script> $("h3").css("padding",$("#example").css("padding")) </script>
                    </div>
                    
                    
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ();
?>
