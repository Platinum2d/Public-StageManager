<?php
?>
<html>
    <head>
        <title> Tutto a posto! </title>
        <?php
            include "../pages/functions.php";
            import("../");
        ?>
        <style>
            .mainpanel{
                margin-top: 100px;
                min-height: 1px;
            }
            
            .paddedDiv{
                padding: 20px;
            }
        </style>
        <script>
            function redirect()
            {
                location.href = "../index.php";
            }
        </script>
        
    </head>
    
    <body>
        <div class="container">
            <div class="row">
                <div class="col col-sm-12">
                    <div class="panel mainpanel" style="min-height: 0px">
                        <div align = "center"> 
                            <h1 style="color:#ff3333"> Tutto a posto! </h1> <br>
                            L'installazione e' stata completata correttamente! Ti aspettavi piu' passaggi? Prova un altro software ;) <br> <br>
                            <input type="button" class="btn btn-primary" value="Vai alla Home Page" onclick="redirect();">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>