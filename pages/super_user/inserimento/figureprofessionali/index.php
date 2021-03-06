<?php
    include '../../../functions.php';
    checkLogin ( superUserType , "../../../../");
    open_html ( "Inserisci figure professionali" );
    $connection = dbConnection("../../../../");
    echo "<script src='../js/scripts.js?1'></script>";
    import("../../../../");
?>

<script>
    function updateSectors(){
        var current = $("#tipoScuola").find(":selected").text();
        
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerFiguraProfessionale/ajaxSettori.php',
            data : {'indirizzo' : current},
            cache : false,
            success : function (xml){
                $("#nomeSettore").html("");
                
                $(xml).find("settori").find("settore").each(function (){
                    $("#nomeSettore").append("<option value='"+$(this).find("id").text()+"'>"+$(this).find("nome").text()+"</option>");
                });                
            }
        });
    }
    
    $(document).ready(function (){
        String.prototype.isEmpty = function() {
            return (this.length === 0 || !this.trim());
        };      
        
        var check = setInterval(function(){
            if ($("#nomeFigura").val().isEmpty())
            {
                $("input[value=\"Invia\"]").prop("disabled",true);
            }
            else
            {
                $("input[value=\"Invia\"]").prop("disabled",false);
            }
        },1);
        
        updateSectors();
    });
    
</script>
<body>
    <?php
        topNavbar ("../../../../");
        titleImg ("../../../../");
    ?>
    <link rel="stylesheet" href="../InsertStyle.css">
    <div class="container">
        <div class="row">
            <div class="col col-sm-12">
                
                <div class="panel">
                    <h1>Inserimento figure professionali</h1>
                    <br>
                    <div class="row">
                        <form class="form-vertical">
                            <div class="col col-sm-6">
                                <b>Nome della figura professionale*</b> 
                                <div class="form-group"> <input class="form-control" id="nomeFigura"> </div>     
                                Figure professionali già presenti
                                <div class="form-group"> 
                                    <select onchange='$("#nomeFigura").val($(this).find(":selected").text())' class="form-control" id="figurePresenti">
                                        <option value="-1"></option>
                                        <?php
                                            $query = "SELECT * FROM figura_professionale";
                                            
                                            $result = $connection->query($query);
                                            if (is_object($result) && $result->num_rows > 0)
                                            {
                                                while ($row = $result->fetch_assoc())
                                                {
                                                    $id = $row['id_figura_professionale'];
                                                    $nome = $row['nome'];

                                                    echo "<option value='$id'>$nome</option>";
                                                }
                                            }
                                        ?>                                        
                                    </select>
                                </div>      
                                <br>
                                * Campo Obbligatorio
                                <br>
                                <br>
                                <input type="button" class="btn btn-primary" value="Invia" onclick="sendSingleData('figuraprofessionale');">
                            </div>
                            <div class="col col-sm-6"> 
                                <b>Tipo di scuola*</b>
                                <select id="tipoScuola" class="form-control" onchange="updateSectors()">
                                <?php
                                        $query = "SELECT DISTINCT indirizzo_studi FROM settore";
                                            
                                        $result = $connection->query($query);
                                        if ($result->num_rows > 0)
                                        {
                                            while ($row = $result->fetch_assoc())
                                            {
                                                echo "<option>".$row['indirizzo_studi']."</option>";
                                            }
                                        }
                                ?>
                                </select>
                                <br>
                                <b>Settore di studi*</b>   
                                <select id="nomeSettore" class="form-control">
                                    
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    close_html ("../../../../");
?>