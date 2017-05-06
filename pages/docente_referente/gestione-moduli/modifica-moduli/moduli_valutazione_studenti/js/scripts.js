var isEditing;

$(document).ready(function (){
    $("#redirectForm").find("input[name='modulo']").val("");
    isEditing = false;
});

function redirectToModule(id_modulo)
{
    if (!isEditing)
    {
        $("#redirectForm").find("input[name='modulo']").val(id_modulo);
        $("#redirectForm").submit();
    }
}

function openEdit(id_modulo, progressiv)
{
    $("tr[data-id='"+id_modulo+"']").find("td[name='nome']").html("<input type='text' class='form-control' value='"+$("tr[data-id='"+id_modulo+"']").find("td[name='nome']").text()+"'>");
    $("tr[data-id='"+id_modulo+"']").find("td[name='descrizione']").html("<textarea cols='9' rows='9' class='form-control'>"+$("tr[data-id='"+id_modulo+"']").find("td[name='descrizione']").text()+"</textarea>");
    $("#edit"+progressiv).html("<span class='glyphicon glyphicon-ok'></span> Conferma");
    $("#edit"+progressiv).attr("onclick", "sendData("+id_modulo+", "+progressiv+")");
    isEditing = true;
}

function sendData(id_modulo, progressiv)
{   
    tosend = {
        'id' : id_modulo,
        'nome' : $("tr[data-id='"+id_modulo+"']").find("td[name='nome']").find("input").val(),
        'descrizione' : $("tr[data-id='"+id_modulo+"']").find("td[name='descrizione']").find("textarea").val()
    };
    
    $.ajax({
        method : 'POST',
        url : 'ajaxOpsPerModuloStudenti/ajaxInvia.php',
        data : tosend,
        success : function (msg){
            if (msg === "ok")
            {
                $("tr[data-id='"+id_modulo+"']").find("td[name='nome']").html(tosend.nome);
                $("tr[data-id='"+id_modulo+"']").find("td[name='descrizione']").html(tosend.descrizione);
                isEditing = false;
            }
            else
                printError("Errore di aggiornamento", "<div align='center'>Si è verificato un errore in fase di aggiornamento.<br>Si prega di riprovare</div>");
        }
    });
    
    $("#edit"+progressiv).html("<span class='glyphicon glyphicon-edit'></span> Modifica");
    $("#edit"+progressiv).attr("onclick", "openEdit("+id_modulo+", "+progressiv+")")
}

function askForDeleteModule(id_modulo, progressiv)
{
    $("#SuperAlert").modal("show");
    var modal = $("#SuperAlert").find(".modal-body");
    $("#SuperAlert").find(".modal-title").html("ATTENZIONE");
    modal.html("<div align='center'><u>ATTENZIONE</u></div>\n\
                <br>\n\
                Eliminando questo modulo, si perderanno DEFINITIVAMENTE i seguenti dati:\n\
                <ul>\n\
                    <li>Tutte le valutazioni date dalle aziende sulla base di questo modulo</li>\n\
                    <li>Tutte le opzioni possibili per le colonne a risposta chiusa</li>\n\
                </ul>");
    $("#SuperAlert").find(".modal-footer").html("<div class='row'> \n\
                                                    <div class='col col-sm-6' align='left'><h3 style='display:inline'>Procedere?</h3></div>\n\
                                                    <div class='col col-sm-6'> \n\
                                                        <button class='btn btn-success' onclick='deleteModule("+id_modulo+")'>Si</button>\n\
                                                        <button class='btn btn-danger' data-dismiss='modal'>No</button>\n\
                                                    </div> \n\
                                                 </div>");
}

function deleteModule(id_modulo, progressiv)
{
    $.ajax({
        method : 'POST',
        url : 'ajaxOpsPerModuloStudenti/ajaxDelete.php',
        data : {'id' : id_modulo},
        success : function (msg){
            if (msg === "ok")
            {
                $("#SuperAlert").find(".modal-footer").html("<div class='row'> \n\
                                                    <div class='col col-sm-6' align='left'></div>\n\
                                                    <div class='col col-sm-6'> \n\
                                                        <button class='btn' data-dismiss='modal'>Chiudi</button>\n\
                                                    </div> \n\
                                                 </div>");
                
                printSuccess("Eliminazione riuscta", "<div align='center'>Il modulo è stato eliminato con successo</div>", function (){
                    $("tr[data-id = '"+id_modulo+"']").fadeOut("slow");
                });
            }
            else
                printError("Errore di eliminazione", "<div align='center'>"+msg+"</div>");
            //printError("Errore di eliminazione", "<div align='center'>Il modulo non è stato eliminato correttamente.<br>Si prega di riprovare</div>");
        }
    });
}