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

function showAssignedStudents(id_doc, id_classe, id_anno)
{
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerClassiDocentiReferenti/ajaxStudentiAssegnati.php',
        cache : false,
        data : {'docente' : id_doc, 'classe' : id_classe, 'anno' : id_anno},
        success : function (xml)
        {
            $("#SuperAlert").modal("show");
            $("#SuperAlert").find(".modal-title").html("Studenti assegnati al professore");
            var modal = $("#SuperAlert").find(".modal-body");
            modal.html("<table class='table table-hover' id='studtable'>\n\
                            <thead>\n\
                                <th style='text-align:center'>Nome e cognome</th>\n\
                                <th style='text-align:center'>Azioni</th>\n\
                            </thead>\n\
                            <tbody>\n\
                            </tbody>\n\
                        </table>");
            
            $(xml).find("studenti").find("studente").each(function (){
                var id = $(this).find("id").text();
                var id_drhshs = $(this).find("id_drhshs").text();
                var nome = $(this).find("nome").text();
                var cognome = $(this).find("cognome").text();
                
                $("#studtable").find("tbody").append("<tr data-id='"+id+"'>\n\
                                                        <td align='center'><u style='cursor:pointer' onclick='userProfile("+id+", \"../../../\")'>"+nome+" "+cognome+"</u></td>\n\
                                                        <td align='center'><button onclick='disassegnaStudente("+id_drhshs+", this)' class='btn btn-danger'><span class='glyphicon glyphicon-trash'></span> Disassegna</button></td>\n\
                                                      </tr>");
            });
        }
    });
}

function disassegnaStudente(id_drhshs, btn)
{
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerClassiDocentiReferenti/ajaxDisassegnaStudente.php',
        cache : false,
        data : {'drhshs' : id_drhshs},
        success : function (msg)
        {
            if (msg === "ok")
            {
                $(btn).parents("tr").fadeOut();
            }
            else
            {
                printError("Errore", "<div align='center'>Errore durante l'eliminazione di questa assegnazione.<br>Si prega di segnalare il problema</div>");
            }
        }
    });
}