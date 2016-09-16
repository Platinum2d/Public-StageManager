<?php
    include '../../../functions.php';
    checkLogin ( superUserType , "../../../../");    
    import("../../../../");
    echo "<script src=\"scripts.js\"> </script>";
    open_html ( "Impostazioni - Database" );
    $connessione = dbConnection ("../../../../");
    $recoveredData = file_get_contents("../../../../db.txt");
    $database = unserialize($recoveredData);
    $host = $database["host"];
    $user = $database["user"];
    $name = $database["name"];
    $password = $database["password"];
?>
<body>
    <?php    
        topNavbar ("../../../../");
        titleImg ("../../../../");
        printChat("../../../../");            
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div id="mainpanel" class="panel">
                    <h1>Credenziali del Database</h1>
                    <br><br>
                        
                    <div class="table-responsive">
                        <table id="databaseInfo" class="table table-striped" >
                            <tr>
                                <th class="col-sm-3">Host del server</th>
                                <td id="host" class="col-sm-5"><?php echo $host; ?></td>
                            </tr>
                            <tr>
                                <th class="col-sm-3">Utente</th>
                                <td id="user" class="col-sm-5"><?php echo $user ?></td>
                            </tr>
                            <tr>
                                <th class="col-sm-3">Nome del database</th>
                                <td id="name" class="col-sm-5"><?php echo $name; ?></td>
                            </tr>
                            <tr>
                                <th class="col-sm-3">Password</th>
                                <td id="password" class="col-sm-5">
                                    
                                </td>
                            </tr>
                        </table>
                    </div>
                    <br>
                    <button id="editButton" class="btn btn-warning btn-sm rightAlignment margin buttonfix" onclick="openEdit()">
                        <span class="glyphicon glyphicon-edit"></span>
                    </button>
                    <button disabled="true" id="saveButton" class="btn btn-success btn-sm rightAlignment margin buttonfix" onclick="editAccess()">
                        <span class="glyphicon glyphicon-ok"></span>
                    </button>
                    <button id="cancelButton" class="btn btn-danger btn-sm rightAlignment margin buttonfix" onclick="closeEdit()">
                        <span class="glyphicon glyphicon-remove"></span>
                    </button>
                    <br><br>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ();
?>