<?php
    include '../../functions.php'; //let's try
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
    
<style>
    .kv-avatar .file-preview-frame,.kv-avatar .file-preview-frame:hover {
        margin: 0;
        padding: 0;
        border: none;
        box-shadow: none;
        text-align: center;
    }
    .kv-avatar .file-input {
        display: table-cell;
        max-width: 220px;
    }
</style>
    
<body>
    <?php
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
                                echo <<<HTML
                                    
                                <form onsubmit = "return checkSubmit()" class="text-center" action="ajaxOps/avatar_uploader.php" method="post" enctype="multipart/form-data">
                                    <div class="kv-avatar center-block" style="width:200px">
                                        <input id="avatar-2" name="profileimage" type="file" class="file-loading">
                                    </div>
                                </form>
HTML;
                                ?>
                            <script>                                
                                $("#avatar-2").fileinput({
                                    maxFileSize: 5000,
                                    showClose: true,
                                    showCaption: false,
                                    showBrowse: false,
                                    browseOnZoneClick: true,
                                    removeLabel: 'Cancella',
                                    uploadLabel: "Carica",
                                    removeIcon: '<i class="glyphicon glyphicon-remove"></i>',
                                    msgErrorClass: 'alert alert-block alert-danger',
                                    defaultPreviewContent: '<img src="../../../src/img/default_avatar_male.jpg" alt="La tua immagine" style="width:160px"><h6 class="text-muted">Clicca per selezionare</h6>',
                                    allowedFileExtensions: ["jpg", "png", "gif"]
                                });
                            </script>
                                
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
                            <script>
                                $("#editspan").on("click", function (){
                                    $("#SuperAlert").modal("show");
                                    var modal = $("#SuperAlert").find(".modal-body");
                                    
                                    $("#SuperAlert").find(".modal-title").html("Cambia l'immagine del profilo");
                                    modal.html('<form class="text-center" action="ajaxOps/replace_avatar.php" method="post" enctype="multipart/form-data">\n\
                                                    <label class="control-label">Seleziona un\'immagine</label>\n\
                                                    <input id="input-file" name = "profileimagechange" type="file" accept="image/*" class="file-loading">\n\
                                                </form>');
                                    $("#input-file").fileinput({   
                                        maxFileSize: 5000,
                                        previewFileType: "image",
                                        browseClass: "btn btn-success",
                                        browseLabel: "Sfoglia...",
                                        browseIcon: "<i class=\"glyphicon glyphicon-picture\"></i> ",
                                        removeClass: "btn btn-danger",
                                        removeLabel: "Cancella",
                                        removeIcon: "<i class=\"glyphicon glyphicon-trash\"></i> ",
                                        uploadClass: "btn btn-info",
                                        uploadLabel: "Carica",
                                        uploadIcon: "<i class=\"glyphicon glyphicon-upload\"></i> ",                                        
                                        allowedFileExtensions: ["jpg", "png", "gif"]
                                    });
                                    $(".btn-primary > .hidden-xs").html("Seleziona...");
                                    modal.append("<br> <a> Oppure <a href=\"javascript:resetAvatar()\"> <u>ripristina l'avatar predefinito</u></a> </a>")
                                });
                                
                            </script>    
                            <?php
                            }
                            ?>
                        </div>
                        <div class="col col-sm-9">
                            <div class="table-responsive" >
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
        $('#SuperAlert').on('hidden.bs.modal', function () {
            $("#editspan").css("visibility" , "hidden");              
            $("#profileimage").css("opacity", "1");
        });
        $("#editspan").hover(function (){
            $("#editspan").css("visibility" , "visible");
            $("#profileimage").css("opacity", "0.2");
        });
        
        function resetAvatar()
        {
            $.ajax({
                type : 'POST',
                url : 'ajaxOps/ajaxResetAvatar.php',
                cache : false,
                success : function (msg)
                {
                    if (msg === "ok")
                    {
                        $("#SuperAlert").modal("hide");
                        location.reload();
                    }
                }
            });
        }
        
        function checkSubmit()
        {
            if ($(".file-default-preview").length > 0) return false;
        }
    </script>
</body>
<?php
    close_html ("../../../");
?>
