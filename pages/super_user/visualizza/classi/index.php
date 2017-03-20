<?php
    include '../../../functions.php';
    checkLogin ( superUserType , "../../../../");
    import("../../../../");
    echo "<script src=\"scripts/scripts.js\"> </script>";
    open_html ( "Visualizza classi" );
    $connessione = dbConnection ("../../../../");
        
?>
<body>
    <?php    
   // printBadge("../../../");
        topNavbar ("../../../../");
        titleImg ("../../../../");
            
    ?>
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                <div class="panel">
                    <h1> Visualizza Classi </h1>
                    <div class="row">
                        <div class="col col-sm-4"></div>
                        <div class="col col-sm-4">
                            Scuola<select data-style="btn-info" class="form-control selectpicker" data-live-search = "true"  id="classes">
                                <option style="font-color : white" value="-1" selected disabled> Selezionare </option>
                                <?php
                                $query = "SELECT `id_scuola`, `nome`, `username` FROM `scuola`, `utente` WHERE `id_scuola` = `id_utente`";
                                $result = $connessione->query($query);
                                
                                while ($row = $result->fetch_assoc())
                                {
                                    $idscuola = $row['id_scuola'];
                                    $nome = $row['nome'];
                                    $username = $row['username'];
                                    
                                    echo "<option value=\"$idscuola\"> $nome (username: $username) </option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col col-sm-4">
                            <div id="actionwrapper">Desidero visualizzare<select class="form-control" id="action">
                                    <option value="studenti"> Studenti </option>
                                    <option value="stage"> Periodi di stage </option>                                    
                                </select>     
                            </div>
                        </div>
                    </div>
                    <br>                     
                    <div class="row" id="viewoptions">
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
                                <input class="form-control" type="number" min="1" id="customnum" name="customaz" value="<?php echo $recordperpagina ?>">
                            </div>
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