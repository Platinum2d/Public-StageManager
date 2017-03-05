<?php
    include '../../functions.php';
   checkLogin ( scuolaType , "../../../");
    import("../../../");
    open_html ( "Inserisci" );
    $connessione = dbConnection ("../../../");
        
?>
<body>
    <style>
        a{
            color : #555
        }
    </style>
    <?php
        topNavbar ("../../../");
        titleImg ("../../../");
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1> Menù </h1><br>
                    <div class="row">
                        <div class="col col-sm-12">
                            <div align="center">
                                <table class="table table-hover">
                                    <tr> <td align="center"><h1> <a href="inserimento/index.php">Inserimento</a>  </h1></td> </tr>
                                    <tr> <td align="center"><h1> <a href="visualizzazione/index.php">Visualizzazione</a> </h1> </td> </tr>
                                </table>
                            </div>
                        </div>
<!--                        <div class="col col-sm-6"> 
                            <div align="center">
                                <table class="table table-hover">
                                    
                                </table>
                            </div>
                        </div>-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ("../../../");
?>