<?php
    include '../../../functions.php';
    checkLogin ( scuolaType , "../../../../");
    open_html ( "Visualizza classi" );
    import("../../../../");
    echo "<script src=\"scripts/scripts.js?0.01\"> </script>";
    $connessione = dbConnection ("../../../../");
        
?>
<body>
    <?php
        topNavbar ("../../../../");
        titleImg ("../../../../");
            
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1> Modifica Classi </h1>
                    <br>  
                    <div class="row">
                        <div class="col col-sm-4">
                            <div id="actionwrapper">Desidero visualizzare
                                <select class="form-control" id="actions">
                                    <option value="studenti"> Studenti </option>
                                    <option value="stage"> Periodi di stage </option>                                    
                                </select>
                            </div>
                        </div>
                        <div class="col col-sm-4">
                        </div>
                        <div class="col col-sm-4 rightAlignment">
                            <div align="right">Anno Scolastico</div>
                            <select class="form-control" id="anni">
                                <?php
                                    $result = $connessione->query("SELECT `id_anno_scolastico`, `nome_anno` FROM `anno_scolastico` ORDER BY `nome_anno` DESC");
                                    if ($result->num_rows > 0)
                                    {
                                        while ($row = $result->fetch_assoc())
                                        {
                                            $id = $row['id_anno_scolastico'];
                                            $nomeanno = $row['nome_anno'];
                                            
                                            echo "<option value='$id'>$nomeanno</option>";
                                        }
                                    }
                                ?>
                            </select>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div id="table">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ("../../../../");
?>