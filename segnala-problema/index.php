<?php
    include '../pages/functions.php';
    if (!isset($_SESSION ['type'])){
        header ("Location:../index.php");
    }
    open_html ( "Segnala un problema" );
    import("../");
?>
<body>
    <?php
        topNavbar ("../");
        titleImg ("../");
    ?>    
    <script src="js/script.js"></script>    
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1>Segnalaci un problema</h1>
                    <br>
                    <div class="row">
                        <div class="col col-sm-10">
                        	<form onsubmit="sendAdvice(); return false;">
                            	<div class="form-group">
                                    <label for="categoria">Seleziona il tipo di problema che vuoi segnalarci:</label>
                                    <select id="categoria" class="form-control" style="width: 400px" required>
                                        <option value="bug" selected>Malfunzionamento/Errore non previsto</option>
                                        <option value="miglioria">Suggerimento migliorativo</option>
                                        <option value="funzionalita mancante">Funzionalità mancante</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="oggetto">Oggetto:</label>
                                    <input type="text" class="form-control" id="oggetto" required>
                                </div>
                                <div class="form-group">
                                    <label for="messaggio">Messaggio:</label>
                                    <textarea class="form-control" rows="6" id="messaggio" required></textarea>
                                </div>
                                <button class="btn btn-primary" type="submit">Invia</button>
                            </form>
                        </div>
                    </div>
            	</div>
        	</div>
        </div>
    </div>
</body>    
<?php
    close_html ("../");
?>