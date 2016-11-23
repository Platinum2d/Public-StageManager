<?php
    include '../../../../functions.php';
    checkLogin ( superUserType,"../../../../../" );
    open_html ( "Registro di ".$_POST['cognome']." ".$_POST['nome'] );
    $idstud = $_POST['idstudente'];
    import("../../../../../");
    $connessione = dbConnection ("../../../../../");
    $result = $connessione->query("SELECT `data`, `descrizione` FROM `lavoro_giornaliero` WHERE `studente_id_studente` = $idstud ORDER BY `data` ASC");
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
                    <h1> Registro di  <?php echo $_POST['cognome'] . " " . $_POST['nome'] ?></h1>
                    <table class="table">
                        <thead> <th> Data </th> <th> Descrizione</th> </thead>
                        <?php
                            while ($row = $result->fetch_assoc())
                            {
                                echo "<tr> <td style=\"width:15%\"> ".$row['data']." </td> <td> ".$row['descrizione']." </td> </tr>";
                            }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>

</body>
<?php
    close_html ("../../../../../");
?>