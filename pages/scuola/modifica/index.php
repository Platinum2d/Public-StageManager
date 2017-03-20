<?php
    include '../../functions.php';
    checkLogin ( scuolaType , "../../../");
    import("../../../");
    open_html ( "Modifica" );
    $connessione = dbConnection ("../../../");
        
?>
<body>
    <style>
        a{
            color : #555
        }
    </style>
    <?php    
   // printBadge("../../../");
        topNavbar ("../../../");
        titleImg ("../../../");
            
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1> Menù di modifica </h1><br>
                    <div class="row">
                        <div class="col col-sm-12"> 
                            <div align="center">
                                <table class="table table-hover">
                                    <tr> <td align="center"><h1> <a href="aziende/index.php">Aziende</a>  </h1></td> </tr>
                                    <tr> <td align="center"><h1> <a href="classi/index.php">Classi</a> </h1> </td> </tr>
                                    <tr> <td align="center"><h1> <a href="docenti/index.php">Docenti</a> </h1> </td> </tr>
                                    <tr> <td align="center"><h1> <a href="periodi_stage/index.php">Periodi di stage</a> </h1> </td> </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ("../../../");
?>