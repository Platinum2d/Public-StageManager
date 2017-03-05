<?php
    include "../../pages/functions.php";
        
    $conn = dbConnection("../../");
    $email = $_POST['mail'];
    $messaggio = "SI PREGA DI NON RISPONDERE ALLA MAIL CHE SEGUE, GRAZIE          Salve. Se sta ricevendo questa mail, significa che sta cercando di ripristinare la password del suo profilo di www.leviws.it. In caso contrario, la preghiamo di ignorare questo messaggio. Clicchi su questo link per proseguire con il ripristino http://www.leviws.it/pages/login/forgottenpassword/replace/index.php";
    $tuttobene = false;
    $mittente = "postmaster@leviws.it";
    $headers .= "From: ".$mittente;
    
    $query = "SELECT * FROM docente WHERE email = '$email'";
    $result = $conn->query($query);
    if ($result->num_rows > 0)
    {
        $row = $result->fetch_assoc();
        //$messaggio .= "type=1&id=".$row['id_docente'];
        ?> <script> localStorage.setItem("authorized_replace_type_user", "1"); localStorage.setItem("authorized_replace_id", '<?php echo $row['id_docente']; ?>'); </script> <?php
        $tuttobene = (mail($email, "Ripristino Password per ".$row['cognome']." ".$row['nome'], $messaggio,$headers)) ? true : false;
    }
    else
    {
        $query = "SELECT * FROM studente WHERE email = '$email'";
        $result = $conn->query($query);
        if ($result->num_rows > 0)
        {
            $row = $result->fetch_assoc();
            //$messaggio .= "type=2&id=".$row['id_studente'];
            ?> <script> localStorage.setItem("authorized_replace_type_user", "2"); localStorage.setItem("authorized_replace_id", '<?php echo $row['id_studente']; ?>'); </script> <?php
            $tuttobene = (mail($email, "Ripristino Password per ".$row['cognome']." ".$row['nome'], $messaggio, $headers)) ? true : false;
        }
        else
        {
            $query = "SELECT * FROM tutor WHERE email = '$email'";
            $result = $conn->query($query);
            if ($result->num_rows > 0)
            {
                $row = $result->fetch_assoc();
                //$messaggio .= "type=3&id=".$row['id_tutor'];
                ?> <script> localStorage.setItem("authorized_replace_type_user", "3"); localStorage.setItem("authorized_replace_id", '<?php echo $row['id_tutor']; ?>'); </script> <?php
                $tuttobene = (mail($email, "Ripristino Password per ".$row['cognome']." ".$row['nome'], $messaggio, $headers)) ? true : false;
            }
            else
            {
                $query = "SELECT * FROM azienda WHERE email = '$email'";
                $result = $conn->query($query);
                if ($result->num_rows > 0)
                {
                    $row = $result->fetch_assoc();
                    //$messaggio .= "type=4&id=".$row['id_azienda'];
                    ?> <script> localStorage.setItem("authorized_replace_type_user", "4"); localStorage.setItem("authorized_replace_id", '<?php echo $row['id_azienda']; ?>'); </script> <?php
                    $tuttobene = (mail($email, "Ripristino Password per ".$row['cognome']." ".$row['nome'], $messaggio, $headers)) ? true : false;
                }
            }
        }
    }
    
if ($tuttobene)
    {
        open_html ( "Mail Inviata" );
        import("../../");
        topNavbar ("../../");
        titleImg ("../../");
        ?>
<body>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <div class="row">
                        <div class="alert alert-success">
                            E' stata inviata una mail di ripristino all'indirizzo indicato
                        </div>
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
        import("../../");
        topNavbar ("../../");
        titleImg ("../../");
        ?>
<body>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <div class="row">
                        <div class="alert alert-danger">
                            Qualcosa e' andato storto. Si prega di verificare che l'indirizzo mail sia lo stesso del suo utente
                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </div>
</body>
<?php        
    }            
    close_html("../../");
?>