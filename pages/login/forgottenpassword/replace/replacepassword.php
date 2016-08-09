<?php
    include '../../../functions.php';
    $conn = dbConnection();
        
    $id = $_POST['userid'];
    $tabella = $_POST['tabella'];
    $nuovapassword = md5($_POST['password']);
        
    $query = "UPDATE $tabella SET password = '$nuovapassword' WHERE id_$tabella = $id";
    $tuttobene = ($conn->query($query)) ? true : false;
    if ($tuttobene)
    {
        open_html ( "Ripristino Completato" );
        topNavbar ();
        titleImg ();
        ?>
<body>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <div class="row">
                        <div class="alert alert-success">
                            <strong>Tutto ok!</strong> La tua password e' stata correttamente reimpostata
                        </div>
                    </div>
                </div>
            </div>
        </div>    
</body>
        <?php 
    }
    else
    {
        open_html ( "Errore" );
        topNavbar ();
        titleImg ();
        ?>
<body>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <div class="row">
                        <div class="alert alert-danger">
                            Qualcosa è andato storto. Si prega di ritentare
                        </div>
                    </div>
                </div>
            </div>
        </div>    
</body>
        <?php        
    }            
    close_html();
        
        