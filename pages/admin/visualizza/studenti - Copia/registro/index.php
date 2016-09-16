<?php
    include '../../../../functions.php';
    checkLogin ( superUserType,"../../../../../" );
    open_html ( "Registro di" );
    import("../../../../../");
    $connessione = dbConnection ("../../../../../");
?>
<body>
       	<?php
        topNavbar ("../../../../../");
        titleImg ("../../../../../");
    ?>
    <!-- Begin Body -->
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    
                </div>
            </div>
        </div>
    </div>

</body>
<?php
    close_html ();
?>