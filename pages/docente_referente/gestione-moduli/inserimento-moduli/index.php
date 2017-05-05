<?php
    include '../../../functions.php';
    checkLogin ( docrefType , "../../../../");
    open_html ( "Inserisci Moduli i valutazione" );
    import("../../../../");
    echo "<script src='js/scripts.js'></script>";
?>
    
<body>
    <?php
        topNavbar ("../../../../");
        titleImg ("../../../../");
    ?>
    
    
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                
                <div class="panel">
                    <h1>Inserimento Moduli di valutazione</h1>
                    <br>
                    <div class="row">
                        <div class="col col-sm-6">
                            <b>Nome del modulo*</b>  
                            <input class="form-control" id="nomeModulo"><br>
                            Descrizione modulo  
                            <textarea cols="4" rows="4" class="form-control" id="descrizioneModulo"></textarea>
                            <br>
                            * Campo Obbligatorio
                            <br>
                            <br>
                            <input disabled="disabled" type="button" class="btn btn-primary" value="Invia" onclick="sendData();">
                        </div>
                        <div class="col col-sm-6">
                            <b>Questo modulo verrà usato per valutare:</b>
                            <div class="list-group">
                                <a style="cursor: pointer" onclick="$(this).addClass('active'); $('#valutaaziende').removeClass('active'); check();" id='valutastudenti' class="list-group-item">Gli studenti</a>
                                <a style="cursor: pointer" onclick="$(this).addClass('active');$('#valutastudenti').removeClass('active'); check();" id='valutaaziende' class="list-group-item">Le aziende</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ("../../../../");
?>