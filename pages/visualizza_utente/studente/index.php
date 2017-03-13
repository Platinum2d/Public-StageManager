<?php
    include '../../functions.php';
    $conn = dbConnection ("../../../");  
    $id_stud = $_POST['user'];
        
    if (! isset ( $_SESSION ['type'] )) 
    {
        header ( "location: ../../../index.php" );
    }
            
    $result = $conn->query("SELECT * FROM utente, studente WHERE id_studente = id_utente AND id_studente = $id_stud")->fetch_assoc();
    $nome_stud = $result['nome'];
    $cognome_stud = $result['cognome'];
    $username = $result['username'];
    $email = $result['email'];    
    $telefono = $result['telefono'];
        
    open_html ( "$nome_stud $cognome_stud" );
    import("../../../");
    //echo "<script src='js/scripts_studenti.js'></script>";
        
?>
<body>
   	<?php
        topNavbar ("../../../");
        titleImg ("../../../");
    ?>
    <div class="container">  
        <div class="panel">
            <div class="row">
                <div class="col col-sm-12">
                    
                    <h1>Profilo Utente di <?php echo "$nome_stud $cognome_stud"; ?></h1><br>
                    <div class="col col-sm-3" id='profilewrapper'>
                        <?php
                            $query = "SELECT URL FROM utente, immagine_profilo WHERE immagine_profilo_id_immagine_profilo = id_immagine_profilo "
                                    . "AND id_utente = $id_stud";
                            $result = $conn->query($query)->fetch_assoc();
                            if (isset($result['URL']))
                            {
                                echo "<div align='center'><img id='profileimage' style=\"max-height : 255px; max-width : 255px\" src = '../../../media/loads/profimgs/".$result['URL']."'></div>";
                            }
                            else
                            {
                                echo "<div align='center'><img id='profileimage' src = '../../../media/img/default_avatar_male.jpg'></div><br>";
                                ?>     
                                    <script>$("#profileimage").css("margin-top", $("#profilewrapper").height() / 4);</script>
                                <?php
                            }
                        ?>
                    </div>
                    <div class="col col-sm-9">
                        <div class="table-responsive">
                            <table id="myInformations" class="table table-striped" style="table-layout: fixed; height: 255px">
                                <tr>
                                    <th class="col-sm-5">Username</th>
                                    <td id="username" class="col-sm-5"><?php echo $username; ?></td>
                                </tr>
                                <tr>
                                    <th >Nome</th>
                                    <td id="first" ><?php echo $nome_stud; ?></td>
                                </tr>
                                <tr>
                                    <th>Cognome</th>
                                    <td id="last"><?php echo $cognome_stud; ?></td>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php 
    close_html("../../../");
?>