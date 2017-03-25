<?php
    include '../../../functions.php';
    checkLogin ( scuolaType , "../../../../");
    import("../../../../");
    echo "<script src=\"scripts/scripts.js\"> </script>";
    open_html ( "Visualizza classi" );
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
                    <!--                    <div class="row" id="viewoptions">
                                            <div class="col col-sm-4">
                                                <div align="left">
                                                    <p style="display: inline">Cerca</p> <input style="display: inline" class="form-control" type="text">
                                                </div>
                                            </div>
                                            <div class="col col-sm-4">
                                                Azione<div align="center">
                                                    <select class="form-control" id="actions">
                                                        <option>  </option>                                    
                                                        <option value="1"> Espandi </option>
                                                        <option value="2"> Riduci </option>
                                                        <option value="3"> Elimina </option>
                                                    </select>
                                                </div>
                                            </div>
                            
                                            <div class="col col-sm-4"> 
                                                Filtra righe<div align="right">
                                                    <input class="form-control" type="number" min="1" id="customnum" name="customaz" value="<?php //echo $recordperpagina ?>">
                                                </div>
                                            </div>
                                        </div>    -->
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