<?php
    include '../../../functions.php';
    checkLogin ( superUserType , "../../../../");
    import("../../../../");
    echo "<script src=\"scripts/scripts.js\"> </script>";
    open_html ( "Visualizza classi" );
    $connessione = dbConnection ("../../../../");
        
?>
<body>
    <?php    
   // printBadge("../../../");
        topNavbar ("../../../../");
        titleImg ("../../../../");
            
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1> Visualizza Classi </h1>
                    <div class="row">
                        <div class="col col-sm-4"></div>
                        <div class="col col-sm-4">
                            Scuola<select class="form-control" id="classes">
                                <option value="-1"> </option>
                            </select>
                        </div>
                    </div>
                    <br>
                    <div id="table">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ();
?>