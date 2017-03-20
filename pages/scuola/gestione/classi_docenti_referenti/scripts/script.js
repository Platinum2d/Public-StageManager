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

function deleteAssignment(id_doc, id_classe, id_anno)
{
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerClassiDocentiReferenti/ajaxDisassegna.php',
        cache : false,
        data : {'docente' : id_doc, 'classe' : id_classe, 'anno' : id_anno},
        success : function (msg)
        {
            if (msg === "ok")
                location.reload();
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