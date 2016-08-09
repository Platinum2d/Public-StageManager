<?php
    include '../../functions.php';
    checkLogin(doctutType , "../../../");
    $idstud = $_GET['id_studente'];
    $nomestudente = $_GET['nomestudente'];
    $cognomestudente = $_GET['cognomestudente'];
    open_html ( "Valutazione Studente" );
    $conn = dbConnection ("../../../");
    import("../../../");
    $query = "SELECT * FROM valutazione_stage WHERE id_valutazione_stage = $idstud";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0)
        $row = $result->fetch_assoc();    
    
    topNavbar ("../../../");
    titleImg ("../../../");
    printChat("../../..");
    ?>

<body>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                     <a href = "index.php"> Indietro </a>
                    <h1>  ESPERIENZA DA STAGISTA DI <i> <?php echo $cognomestudente." " ?> <?php echo $nomestudente ?> </i></h1> <br><br>
                    <div class="row">
                        <div class="col col-sm-6">
                            <h3> VOTO EMESSO : <?php if ($result && $result->num_rows > 0) echo $row['voto'] ?> </h3>
                        </div>
                        
                        <div class="col col-sm-6">
                            DESCRIZIONE<textarea class="form-control" style="min-height: 180px"> <?php if ($result && $result->num_rows > 0) echo $row['descrizione'] ?> </textarea>
                        </div>
                                               
                    </div>
                   
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ();
?>
