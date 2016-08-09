<?php
    include '../../functions.php';
    checkLogin ( aztutType , "../../../" );
    open_html ( "Home" );
    import("../../../");
    $conn = dbConnection ("../../../");
    $id = $_POST ['idstudente']; // id studente
        
    /*
     * echo<<<HTML
     * <link href="includes/stile.css" rel="stylesheet" type="text/css">
     * <script src="script/js.js"></script>
     * HTML;
     */
?>
<body>
    <script src="js/scripts.js"> </script>
        
	<?php
        topNavbar ("../../../");
        titleImg ("../../../");
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">                    
                    <h1 id = "valuta">VALUTA</h1>
                        <?php
                            $sql = "select `visita_azienda` from `studente`  where `id_studente`=$id";
                            $Result = $conn->query ( $sql );
                            $row = $Result->fetch_assoc ();
                            $visita = $row ['visita_azienda'];
                            if ($visita == 0) {
echo <<<HTML
                                    <form method="POST" action="visita_ajax.php">                       
                                    <h3>Lo studente si e presentatato in azienda per un colloquio?</h3>
                                    <div class="row">
                                        <div class="col col-sm-4">
                                        </div>
                                            
                                             <div class="col col-sm-4">
                                            <div id="prima" align="center">
                                               <label style="height:35px; width:35px; vertical-align: middle;"><input style="height:35px; width:35px; vertical-align: middle;" type="radio" name="scelta" value="1"> Si</label>
                                               <label style="height:35px; width:35px; vertical-align: middle;"><input style="height:35px; width:35px; vertical-align: middle;" type="radio" name="scelta" value="0">  No</label> <br>
                                                <input type="hidden" name="id_studente" value=$id>
                                                <input type="hidden" name="page" value="1">
                                            </div>
                                        </div>
                                    </div>    
                                            <input type="submit" name="conferma_scelta" value="conferma" id="conferma_scelta" ><br>
                                        </form>
HTML;
                            } elseif ($visita == 1) {
                                echo <<<HTML
                                    <!-- <form id="form_studente" action="aggiornamento_valutazione.php" method="post"> -->
HTML;
                                $sql = "select `nome`,`cognome` from `studente` where `id_studente`='$id'";
                                $Result = $conn->query ( $sql );
                                while ( $row = $Result->fetch_assoc () ) {
                                    $nome = $row ['nome'];
                                    $cognome = $row ['cognome'];
                                        
                                    echo "<input type=\"hidden\" value = \"$nome\" id = \"nomestud\">";
                                    echo "<input type=\"hidden\" value = \"$cognome\" id = \"cognomestud\">";
                                    echo <<<HTML
                                        <h3></h3>
                                            
HTML;
                                    ?>
                    <script>
                        $('#valuta').append(' <i>'+$('#cognomestud').val()+' '+$('#nomestud').val()+'<i>');
                    </script>
 <?php
                                    $sql = "select `valutazione_studente_id_valutazione_studente` from studente where `id_studente`=  $id";
                                    echo <<<HTML
                                        <!-- <form id="form_studente" action="aggiornamento_valutazione.php" method="post"> -->
HTML;
                                    $Result = $conn->query ( $sql );
//                                    if ($Result) {
                                        //while ( $row = $Result->fetch_assoc () ) {
                                    $row = $Result->fetch_assoc ();
                                            if (isset($row ['valutazione_studente_id_valutazione_studente'])) {
                                                $valutazione_studente_id_valutazione_studente = $row ['valutazione_studente_id_valutazione_studente'];
                                                $sql = "SELECT `gestione_ambiente_spazio_lavoro`, `collaborazione_comunicazione`, `uso_strumenti`, `rispetta_norme_vigenti`, `rispetto_ambiente`, `puntualita`"
                                                        . ", `collaborazione_tutor`, `lavoro_requisiti`, `conoscenze_tecniche`, `acquisire_nuove_conoscenze` FROM `valutazione_studente` "
                                                        . "WHERE `id_valutazione_studente` =$valutazione_studente_id_valutazione_studente";
                                                $Result1 = $conn->query ( $sql );
                                                if ($Result1) {
                                                    while ( $row = $Result1->fetch_assoc () ) {
                                                        $gestione_ambiente_spazio_lavoro = $row ["gestione_ambiente_spazio_lavoro"];
                                                        $collaborazione_comunicazione = $row ['collaborazione_comunicazione'];
                                                        $uso_strumenti = $row ['uso_strumenti'];
                                                        $complessita_compito_atteggiamento = $row ['rispetta_norme_vigenti'];
                                                        $valutazione_gestione_sicurezza = $row ['rispetto_ambiente'];
                                                        $competenze_linguistiche = $row ['puntualita'];
                                                        $conoscenza_coerenza_approfondimento = $row ['collaborazione_tutor'];
                                                        $efficacia_esposizone = $row ['lavoro_requisiti'];
                                                        $qualita_processo = $row ['conoscenze_tecniche'];
                                                        $efficacia_prodotto = $row ['acquisire_nuove_conoscenze'];
                                                        echo "<div class=\"row\"> <div class=\"col col-sm-4\"></div> <div class=\"col col-sm-4\">";
                                                        outputSelect ( "Ha la capacita' di mantenere in ordine la postazione di lavoro", "gestione_ambiente_spazio_lavoro", $gestione_ambiente_spazio_lavoro );
                                                        outputSelect ( "Ha la capacita' di collaborare e comunicare correttamente", "collaborazione_comunicazione", $collaborazione_comunicazione );
                                                        outputSelect ( "Ha la capacita' di usare gli strumenti Harware e Software", "uso_strumenti", $uso_strumenti );
                                                        outputSelect ( "Rispetta le norme vigenti per la sicurezza nei luoghi di lavoro", "complessita_compito_atteggiamento", $complessita_compito_atteggiamento );
                                                        outputSelect ( "E' rispettoso dell'ambiente e dei colleghi di lavoro","rispetto_ambiente", $valutazione_gestione_sicurezza );
                                                        outputSelect ( "E' puntuale e presente sul lavoro", "competenze_linguistiche", $competenze_linguistiche );
                                                        outputSelect ( "Ha la capacita' di comunicare e relazionarsi", "conoscenza_coerenza_approfondimento", $conoscenza_coerenza_approfondimento );
                                                        outputSelect ( "Collbaora con il tutor aziendale", "efficacia_esposizone", $efficacia_esposizone );
                                                        outputSelect ( "Il lavoro svolto ha i requisiti richiesti", "qualita_processo", $qualita_processo );
                                                        outputSelect ( "Dimostra di avere idonee conoscenze tecniche", "efficacia_prodotto", $efficacia_prodotto );
                                                        
                                                        echo "</div>";
                                                            
                                                                                                        echo "<div class=\"col col-sm-4\">   
                                    <div id=\"div\" align=\"center\">
                                        <input class=\"btn btn-default\" type=\"button\" value=\"Aggiorna valutazione\" id=\"SalvaValutazione\" onclick=\"updateGrades()\">
                                    </div>
                                        </div>
                                        </div>";
                                                    }
                                                }
                                            } else {
                                            
                                                echo "<div class=\"row\"> <div class=\"col col-sm-4\"></div> <div class=\"col col-sm-4\">";
                                                    outputSelectNoValue ( "Ha la capacita' di mantenere in ordine la postazione di lavoro", "gestione_ambiente_spazio_lavoro" );
                                                    outputSelectNoValue ( "Ha la capacita' di collaborare e comunicare correttamente", "collaborazione_comunicazione" );
                                                    outputSelectNoValue ( "Ha la capacita' di usare gli strumenti Harware e Software", "uso_strumenti" );
                                                    outputSelectNoValue ( "Rispetta le norme vigenti per la sicurezza nei luoghi di lavoro", "complessita_compito_atteggiamento" );
                                                    outputSelectNoValue ( "E' rispettoso dell'ambiente e dei colleghi di lavoro","rispetto_ambiente" );
                                                    outputSelectNoValue ( "E' puntuale e presente sul lavoro", "competenze_linguistiche" );
                                                    outputSelectNoValue ( "Ha la capacita' di comunicare e relazionarsi", "conoscenza_coerenza_approfondimento" );
                                                    outputSelectNoValue ( "Collbaora con il tutor aziendale", "efficacia_esposizone" );
                                                    outputSelectNoValue ( "Il lavoro svolto ha i requisiti richiesti", "qualita_processo" );
                                                    outputSelectNoValue ( "Dimostra di avere idonee conoscenze tecniche", "efficacia_prodotto" );
                                                echo "</div>";
                                                    
                                                echo "<div class=\"col col-sm-4\">   
                                    <div id=\"div\" align=\"center\">
                                        <input class=\"btn btn-default\" type=\"button\" value=\"Inserisci valutazione\" id=\"SalvaValutazione\" onclick=\"insertGrades()\">
                                    </div>
                                        </div>
                                        </div>";
                                            
                                            }
                                        //}
//                                    } else {
//                                        echo ("Errore!! istruzione SQL");
                                    }
                                }
                                echo <<<HTML
                                <input type="hidden" name="id_studente" value="$id">
                                    <br>
                                <!-- </form> -->
HTML;
                            
                    ?>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html();
?>
    
<?php
    function outputSelect($selectTitle, $selectName, $selectedValue) {
        echo <<<HTML
                $selectTitle
                <select class="form-control" name="$selectName">
HTML;
        for($i = 1; $i <= 10; $i ++) {
            $output = "<option value='$i'";
            if ($i == $selectedValue) {
                $output = $output . " selected";
            }
            $output = $output . ">$i</option>";
            echo $output;
        }
            
        echo "</select><br>";
    }
    function outputSelectNoValue($selectTitle, $selectName) {
        echo <<<HTML
                $selectTitle
                <select class="form-control" name="$selectName">
HTML;
        for($i = 1; $i <= 10; $i ++) {
            $output = "<option value='$i'";
            if ($i == '1') {
                $output = $output . " selected";
            }
            $output = $output . ">$i</option>";
            echo $output;
        }
        echo "</select><br>";
    }
?>