<html>
    <head>
        <title> Installazione! </title>
        <?php
            include "../pages/functions.php";
            import("../");
        ?>
        <link href="installStyle.css" rel="stylesheet">
        <script>
            function redirect()
            {
                location.href = "specifydatabase.php";
            }
        </script>
            
    </head>
        
    <body>
        <div class="container">
            <div class="row">
                <div class="col col-sm-12">
                    <div class="panel mainpanel" style="min-height: 0px">
                        <?php if (file_exists("../db.txt") && !file_exists("../okuser.txt")){ 
                            session_abort();?>
                        <div align = "center"> 
                            <h1 style="color:#ff3333"> BENVENUTO! </h1> <br>
                            Prima di iniziare ad usare la piattaforma, necessitiamo di alcune informazioni. Non temere: non e' nulla di preoccupante <br> <br>
                            <input type="button" class="btn btn-primary" value="Inizia l'installazione" onclick="redirect();">
                        </div>
                        <?php } elseif (!file_exists("../db.txt")) { ?>
                        <div align = "center"> 
                            <h1 style="color:#ff3333"> BENVENUTO! </h1> <br>
                            Prima di iniziare ad usare la piattaforma, necessitiamo di alcune informazioni. Non temere: non e' nulla di preoccupante <br> <br>
                            <input type="button" class="btn btn-primary" value="Inizia l'installazione" onclick="redirect();">
                        </div>
                        <?php 
                            }
                            else 
                            {
                        ?>
                        <div align = "center"> 
                            <h1 style="color:#ff3333"> SPIACENTE </h1> <br>
                            L'installazione e' gia' stata effettuata, pertanto non e' possibile replicarla <br> <br>
                            <input type="button" class="btn btn-primary" onclick="history.go(-1)" value="Torna Indietro">
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>