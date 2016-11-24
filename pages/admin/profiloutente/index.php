<?php
    include '../../functions.php';
   checkLogin ( superUserType , "../../../");
    import("../../../");
    open_html ( "Profilo" );
    $id_doc = $_SESSION ['userId'];
    echo "<script src='profiloutente.js'></script>";
    $connessione = dbConnection ("../../../");
    $sql = "SELECT username, nome, cognome, email, telefono FROM super_user, utente WHERE id_super_user = ".$_SESSION['userId'] . " AND id_utente = id_super_user";
    $result = $connessione->query ( $sql );
        
    while ( $row = $result->fetch_assoc () ) {
        $nome = $row ['nome'];
        $cognome = $row ['cognome'];
        $email = $row ['email'];
        $telefono = $row ['telefono'];
        $username = $row ['username']; 
    }
?>
<body>
    <?php    
   // printBadge("../../../");
        topNavbar ("../../../");
        titleImg ("../../../");          
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div id="mainpanel" class="panel">
                    <h1>Il mio profilo</h1>
                    <br>
                    <div class="row">
                        <div class="col col-sm-3" id='profilewrapper'>
                            <?php 
                            $query = "SELECT immagine_profilo_id_immagine_profilo AS profile FROM utente WHERE id_utente = ".$_SESSION['userId'];
                            $result = $connessione->query($query);
                            $row = ($result && $result->num_rows > 0) ? $result->fetch_assoc() : null;
                            if (!isset($row['profile']) || $row['profile'] === "-1")
                            {
                            ?>
                            <form enctype="multipart/form-data" method="post" action="ajaxOps/profileimageloader.php" name="uploadform">
                                Immagine del profilo
                                <br>
                                <br>
                                <input type="file" class="filestyle" data-buttonName="btn-primary" data-placeholder="File non inserito" name="profileimage">
                                <br>
                                <input type="submit" class="btn btn-primary" value="invia" name="invio">                                    
                            </form>
                            
                            <?php
                            }
                            else
                            {
                                $query = "SELECT id_immagine_profilo, URL FROM utente, immagine_profilo WHERE immagine_profilo_id_immagine_profilo = id_immagine_profilo AND id_utente = ".$_SESSION['userId'];
                                $result = $connessione->query($query);
                                $row = $result->fetch_assoc();
                                echo "<div align=\"center\"><img style=\"max-height : 255px; max-width : 255px\" id=\"profileimage\" src=\"../../../src/loads/profimgs/".$row['URL']."\"></div>";
                                echo "<a style=\"color: #828282\" href=\"javascript:changePicture()\">  <span id=\"editspan\" style=\"position:absolute; font-size: 15px\" class=\"glyphicon glyphicon-pencil\"></span></a>";
                            ?>
                            <form style="padding-top: 10px;" enctype="multipart/form-data" method="post" action="ajaxOps/ajaxReplaceProfileImage.php" name="uploadchangeform">
                                <input style="padding-right: 5px;" type="file" class="filestyle" data-buttonName="btn-primary" data-placeholder="File" name="profileimagechange">
                                <input type="hidden" name="oldpictureid" value="<?php echo $row['id_immagine_profilo']?>">
                                <input style="margin-top: 5px;" type="submit" class="btn btn-primary" value="invia" name="invio">
                                <input style="margin-top: 5px;" class="btn btn-danger" type="button" value="chiudi" onclick="removeChangeForm()">
                            </form>
                            <script>$("form[name=\"uploadchangeform\"]").hide();</script>
                            <?php
                            }
                            ?>
                        </div>
                        <div class="col col-sm-9">
                            <div class="table-responsive">
                                <table id="myInformations" class="table table-striped">
                                    <tr>
                                        <th class="col-sm-3">Username</th>
                                        <td id="username" class="col-sm-5"><?php echo $username; ?></td>
                                    </tr>
                                    <tr>
                                        <th class="col-sm-3">Password</th>
                                        <td id="password" class="col-sm-5"></td>
                                    </tr>
                                    <tr>
                                        <th class="col-sm-3">Nome</th>
                                        <td id="first" class="col-sm-5"><?php echo $nome; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Cognome</th>
                                        <td id="last"><?php echo $cognome; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Email</th>
                                        <td id="mail"><?php echo $email; ?></td>
                                    </tr>
                                    <tr>
                                        <th>Telefono</th>
                                        <td id="phone"><?php echo $telefono; ?></td>
                                    </tr>
                                </table>
                            </div>
                            <button id="editButton" class="btn btn-warning btn-sm rightAlignment margin buttonfix">
                                <span class="glyphicon glyphicon-edit"></span>
                            </button>
                            <button id="saveButton" class="btn btn-success btn-sm rightAlignment margin buttonfix">
                                <span class="glyphicon glyphicon-ok"></span>
                            </button>
                            <button id="cancelButton" class="btn btn-danger btn-sm rightAlignment margin buttonfix">
                                <span class="glyphicon glyphicon-remove"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $("#editspan").css("left", $("#profilewrapper").width() / 1.8);
        $("#editspan").css("top", $("#profilewrapper").height() / 2);
        $("#editspan").css("visibility" , "hidden");
        $("form[name=\"uploadform\"]").css("margin-top", $("#myInformations").height() / 4);        
        $("#profileimage").hover(function (){
            $("#editspan").css("visibility" , "visible");
            $("#profileimage").css("opacity", "0.2");
        })
        $("#profileimage").on("mouseout", function (){
            $("#editspan").css("visibility" , "hidden");              
            $("#profileimage").css("opacity", "1");
        });
        $("#editspan").hover(function (){
            $("#editspan").css("visibility" , "visible");
            $("#profileimage").css("opacity", "0.2");
        });
    </script>
</body>
<?php
    close_html ("../../../");
?>