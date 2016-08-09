<?php
    include '../../functions.php';
    checkLogin ( studType,"../../../" );
    open_html ( "Voto" );
    import("../../../");
    echo "<link href='style.css' rel='stylesheet' type='text/css'>";
?>
<script type="text/javascript" src="script.js">
</script>
<body>
	<?php
        topNavbar ("../../../");
        titleImg ("../../../");
    ?>
        
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Voto azienda</h1>
    <?php
        $connection = dbConnection("../../../");
        $Query = "SELECT azienda_id_azienda FROM studente WHERE id_studente = ".$_SESSION['userId']." AND azienda_id_azienda IS NOT NULL";
        $result = $connection->query($Query);
            
        if ($result->num_rows > 0)
        {
            $Query = "SELECT valutazione_stage_id_valutazione_stage FROM studente WHERE id_studente = ".$_SESSION['userId']." AND valutazione_stage_id_valutazione_stage IS NULL";
            $result = $connection->query($Query);
            if ($result->num_rows > 0)
            {
    ?>
                    <!-- Begin Body -->                    
                    <br>
                    <div class="row">
                        <div class="col col-sm-8">
                            <h2>Dai un voto alla tua azienda:</h2>
                            <div id="voto">
<!--                                <form action="Invia.php" method="post">-->
                                    <div class="">
                                        <select style = "width : 80px" name="voto" id="selectVoto" class="form-control">
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                            <option value="7">7</option>
                                            <option value="8">8</option>
                                            <option value="9">9</option>
                                            <option value="10">10</option>
                                        </select>
                                    </div>
                                    <br>
                                    <h2>Dai una descrizione del tuo lavoro svolto:</h2>                     
                                    <textarea style="resize:none;" rows="7" cols="70" name="descrizione" id="styled" class="form-control"></textarea>
                                    <br>
                                    <br>
                                    <input type= "button" value="Invia" class="btn btn-primary" onclick="sendGrade()">
<!--                                </form>-->
                            </div>                           
                        </div>
                    </div>
    <?php
            }
            else
            {
                $Query = "SELECT valutazione_stage_id_valutazione_stage FROM studente WHERE id_studente = ".$_SESSION['userId']." AND valutazione_stage_id_valutazione_stage IS NOT NULL";
                $result = $connection->query($Query);
                $row = $result->fetch_assoc(); 
                $idValutazione = $row['valutazione_stage_id_valutazione_stage'];
                    
                $Query = "SELECT voto,descrizione FROM valutazione_stage WHERE id_valutazione_stage = $idValutazione";
                $result = $connection->query($Query); $row = $result->fetch_assoc();
                $voto = $row['voto'];
                $descrizione = $row['descrizione'];                
                    
//                $row = $result->fetch_assoc();
//                $Query = "SELECT descrizione,voto FROM valutazione_stage WHERE id_valutazione_stage ".$row['valutazione_stage_id_valutazione_stage'];
//                $result = $connection->query($Query);
//                $row = $result->fetch_assoc();
//                $voto = $row['voto'];
//                $descrizione = $row['descrizione'];
    
                       echo " <div class=\"row\"> 
                        <div class=\"col col-sm-8\">
                            <h2>Modifica il voto precedentemente rilasciato: </h2>
                            <div id=\"voto\">
                                <!-- <form action=\"Invia.php\" method=\"post\"> -->
                                    <div class=\"\">
                                    <input type=\"hidden\" id=\"hiddenVoto\" value=\"$voto\">
                                        <select style=\"width: 80px\" name=\"voto\" id=\"selectVoto\" class=\"form-control\">
                                            <option value=\"1\">1</option>
                                            <option value=\"2\">2</option>
                                            <option value=\"3\">3</option>
                                            <option value=\"4\">4</option>
                                            <option value=\"5\">5</option>
                                            <option value=\"6\">6</option>
                                            <option value=\"7\">7</option>
                                            <option value=\"8\">8</option>
                                            <option value=\"9\">9</option>
                                            <option value=\"10\">10</option>
                                        </select>
                                    </div>
                                    <br>
                                    <h2>Modifica la descrizione precedentemente fornita:</h2>                     
                                    <textarea style = \"height:40%\" cols=\"70\" name=\"descrizione\" id=\"styled\" class=\"form-control\">$descrizione</textarea>
                                    <br>
                                    <br>
                                    <input type= \"button\" value=\"Invia\" class=\"btn btn-primary\" onclick=\"sendGrade()\">
                               <!-- </form> -->
                            </div>
                        </div>
                    </div> ";                       
    ?>
                    <script type="text/javascript">
                        var voto = parseInt($('#hiddenVoto').val());
                        $("#selectVoto").prop('selectedIndex', voto - 1);                        
                    </script>                    
            <?php            
            } 
        }
        else
        {
            ?>
                    <div align="center">
                        <h1 class="alert-warning"> Non sei assegnato a nessuna azienda </h1>
                    </div>
                        
                </div>
            </div>
        </div>
    </div>
    <?php
        }
    ?>
</body>
<?php
    //close_html();
?>