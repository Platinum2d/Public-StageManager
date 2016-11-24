<script>
    if (typeof(localStorage.authorized_replace_id) === "undefined" || typeof(localStorage.authorized_replace_type_user) === "undefined")
    {
        location.href = "http://www.leviws.it/index.php";
    }
</script>
    
<?php
	include "../../../functions.php";
	open_html ( "Ripristino Password" );
        import("../../../../");
//        $type = $_GET['type'] + 0;
//        $id = $_GET['id'];
//        switch ($type)
//        {
//            case 1:
//                $tabella = "docente";
//                
//            break;
//                
//            case 2:
//                $tabella = "studente";        
//            break;
//                
//            case 3:
//                $tabella = "tutor";        
//            break;
//                
//            case 4:
//                $tabella = "azienda";        
//            break;
//        }
?>
    
<body>
<!--    <script> alert(localStorage.authorized_replace_id + " " + localStorage.authorized_replace_type_user) </script>-->
    <?php
    topNavbar ("../../../../");
    titleImg ("../../../../");
    ?>
        
    <!-- Begin Body -->
    <script> 
        //alert(typeof(localStorage.authorized_replace_type_user));
        setInterval(function()
        { 
            var email = ""+$("input[name=password]").val();
            var confermamail = ""+$("input[name=confermapassword]").val();
            if (email !== confermamail || !email.trim() || !confermamail.trim()) document.getElementById("send").disabled = true;
            else document.getElementById("send").disabled = false;
        }, 1);
    </script>
        
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <div class="row">
                        <h2 class="form-signin-heading centeredText">REIMPOSTA LA TUA PASSWORD</h2>
                        <form action="replacepassword.php" method="POST">    
                            <div class="col col-sm-6">
                                Nuova Password <input type="password" class="form-control" name="password"><br>
                                <input type="submit" class="btn btn-primary" value="Invia" id="send">  
                                <?php 
//                                        echo "<input type=\"hidden\" value=\"$tabella\" name=\"tabella\">";
//                                        echo "<input type=\"hidden\" value=\"$id\" name=\"userid\">";
                                ?>
                            </div>
                            
                            <div class="col col-sm-6">
                                Conferma Nuova Password <input type="password" class="form-control" name="confermapassword">
                            </div> 
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        switch (localStorage.authorized_replace_type_user){
            case "1":
                $("<input type=\"hidden\" value=\"docente\" name=\"tabella\">").insertAfter("#send");
                break;
            case "2":
                $("<input type=\"hidden\" value=\"studente\" name=\"tabella\">").insertAfter("#send");
                break;
            case "3":
                $("<input type=\"hidden\" value=\"tutor\" name=\"tabella\">").insertAfter("#send");
                break;
            case "4":
                $("<input type=\"hidden\" value=\"azienda\" name=\"tabella\">").insertAfter("#send");
                break;
            }
            $("<input type=\"hidden\" value=\""+localStorage.authorized_replace_id+"\" name=\"userid\">").insertAfter("input[name=\"tabella\"]")
    </script>
</body>
<?php
	close_html ("../../../../");
?>