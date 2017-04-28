function loadValidClasses(id_anno)
{
    var id_doc = $("#addGestioneDocenteRef").val();
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerClassiDocentiReferenti/ajaxClassiNonGestite.php',
        cache : false,
        data : {'docente' : id_doc, 'anno' : id_anno},
        success : function (xml)
        {
            $("#addGestioneClasse").html("");
            
            $(xml).find("classi_valide").find("classe_valida").each(function ()
            {
                var id = $(this).find("id").text();
                var nome_classe = $(this).find("nome").text();
                
                $("#addGestioneClasse").append("<option value='"+id+"'>"+nome_classe+"</option>");
            });
        }
    });
}

function askForDeleteAssignment(progressiv, id_drhchs, id_anno)
{
    $("#SuperAlert").modal("show");
    var modal = $("#SuperAlert").find(".modal-body");
    $("#SuperAlert").find(".modal-title").html("ATTENZIONE");
    modal.html("<div align='center'><h2> Procedere con l'eliminazione della seguente assegnazione? </h2></div>");
    $("#SuperAlert").find(".modal-footer").html("<div class='row'> \n\
                                                    <div class='col col-sm-6' align='left'></div>\n\
                                                    <div class='col col-sm-6'> \n\
                                                        <button class='btn btn-success' onclick=\"deleteAssignment("+progressiv+", "+id_drhchs+", "+id_anno+")\" data-dismiss='modal'>Si</button>\n\
                                                        <button class='btn btn-danger' data-dismiss='modal'>No</button>\n\
                                                    </div> \n\
                                                 </div>");
}

function deleteAssignment(progressiv, id_drhchs, id_anno)
{
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerClassiDocentiReferenti/ajaxDisassegna.php',
        cache : false,
        data : {'drhchs' : id_drhchs},
        success : function (msg)
        {
            if (msg === "ok")
            {
                $("#riga"+progressiv).fadeOut("slow");
                loadValidClasses(id_anno);
            }
        }
    });
}

function assignDocToClass(id_anno)
{
    var id_doc = $("#addGestioneDocenteRef").val();
    var id_classe = $("#addGestioneClasse").val();
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerClassiDocentiReferenti/ajaxInvia.php',
        cache : false,
        data : {'docente' : id_doc, 'classe' : id_classe, 'anno' : id_anno},
        success : function (msg)
        {
            if (msg === "ok")
                location.reload();
        }
    });
}