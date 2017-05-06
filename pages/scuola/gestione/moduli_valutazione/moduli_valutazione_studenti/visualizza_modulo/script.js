$(document).ready(function (){
    $(".riga-modulo").each(function (){
        $(this).hover(function (){
            $(this).append("  <span onclick='openEditModuleRow(this)' style='color:orange; cursor:pointer' class='glyphicon glyphicon-pencil'></span>  ");
        }, function (){
            $(this).find("span").remove();
        });
    });
});

function openEditModuleRow(span)
{
    var idriga = $(span).parents("tr").attr("data-id");
    var nomeriga = $(span).parents("td").text().trim();
    var posizione = $(span).parents("tr").attr("data-position");
    
    $("#SuperAlert").modal("show");
    $("#SuperAlert").find(".modal-title").html("Modifica riga del modulo");
    var modal = $("#SuperAlert").find(".modal-body");
    
    modal.html("<div class='row'>\n\
                    <div class='col col-sm-12'> \n\
                        <div class='row'>\n\
                            <div class='col col-sm-6'>\n\
                                Nome della riga\n\
                                <textarea id='txtriga' data-id='"+idriga+"' class='form-control'>"+nomeriga+"</textarea>\n\
                            </div>\n\
                            <div class='col col-sm-6'>\n\
                                Numero della riga\n\
                                <input id='posizione' value='"+posizione+"' min='1' type='number' class='form-control'>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                </div>");
    
    $("#SuperAlert").find(".modal-footer").html("\
                            <div class='row'>\n\
                    <div class='col col-sm-12'> \n\
                        <div class='row'>\n\
                            <div align='left' class='col col-sm-6'>\n\
                                <button onclick='askForDeleteModuleRow("+idriga+")' data-dismiss='modal' class='btn btn-warning'><span class='glyphicon glyphicon-exclamation-sign'></span> Elimina questa riga</button>\n\
                            </div>\n\
                            <div align='right' class='col col-sm-6'>\n\
                                <button data-dismiss='modal' class='btn btn-danger'><span class='glyphicon glyphicon-remove'></span> Chiudi</button>\n\
                                <button onclick='editModuleRow("+idriga+")' data-dismiss='modal' class='btn btn-success'><span class='glyphicon glyphicon-ok'></span> Conferma modifiche</button>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                </div>\n\
                ");
    
    $("#txtriga").on("input", function (){
        $(this).css("color", "red");
    });
    
    $("#posizione").on("input", function (){
        $(this).css("color", "red");
    });
}

function editModuleRow(id_riga)
{
    tosend = {
        'id' : id_riga,
        'nome' : $("#txtriga").val(),
        'posizione' : $("#posizione").val()
    };
    
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerVisualizzaModuloStudente/ajaxEditRow.php',
        cache : false,
        data : tosend,
        success : function (msg)
        {
            if (msg === "ok")
            {
                if (parseInt(tosend.posizione) !== parseInt($("tr[data-id = '"+id_riga+"']").attr("data-position"))) location.reload();
                $("tr[data-id = '"+id_riga+"']").find(".riga-modulo").text(tosend.nome);
            }
        }
    });
}

function showOptionsTable(idcolonna)
{
    $("#rispostachiusa").addClass("active");
    $("#possibilita-wrapper").html("\n\
                                    <table id='opTable' class='table table-condensed'>\n\
                                            <thead>\n\
                                                <th style='text-align:center'>Opzioni</th>\n\
                                                <th style='text-align:center'>Ordine</th>\n\
                                                <th style='text-align:center; width:5%'></th>\n\
                                            </thead>\n\
                                            <tbody>\n\
                                            </tbody>\n\
                                        </table>");
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerVisualizzaModuloStudente/ajaxOpzioni.php',
        cache : false,
        data : {'colonna' : idcolonna},
        success : function (xml)
        {
            $(xml).find("opzioni").find("opzione").each(function (){
                var id = $(this).find("id").text();
                var descrizione = $(this).find("descrizione").text();
                var posizione = $(this).find("posizione").text();
                
                $("#opTable").find("tbody").append("<tr data-id='"+id+"'>\n\
                                                        <td data-role='description' contenteditable='true' align='center'>"+descrizione+"</td>\n\
                                                        <td data-role='optposition' contenteditable='true' align='center'>"+posizione+"</td>\n\
                                                        <td><span onclick='deleteOption("+id+")' style='color:red; cursor:pointer' class='glyphicon glyphicon-trash'></span></td>\n\
                                                    </tr>");
                $("td[data-role='optposition']").keypress(function (e){
                    if (e.which < 48 || e.which > 57) 
                        e.preventDefault();
                });
            });
            $("#opTable").find("tbody").append("<tr><td colspan='3'><div align='center'><span onclick='addRowForOption("+idcolonna+")' data-role='addOpt' style='color:green; cursor:pointer' class='glyphicon glyphicon-plus'></span></div></td></tr>");
            $("#opTable").find("tbody").find("tr").each(function (){
                $(this).find("td[data-role='description']").on("input", function (){
                    $(this).css("color", "red");
                });
                $(this).find("td[data-role='optposition']").on("input", function (){
                    $(this).css("color", "red");
                });
            });
        }
    });
}

function deleteOption(id_opzione)
{
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerVisualizzaModuloStudente/ajaxDeleteOption.php',
        cache : false,
        data : {'opzione' : id_opzione},
        success : function (msg)
        {
            if (msg === "ok")
            {
                $("#opTable").find("tbody").find("tr[data-id='"+id_opzione+"']").remove();
                $("option[data-id='"+id_opzione+"']").remove();
            }
                
        }
    });
}

function addRowForOption()
{
    $("#opTable").find("span[data-role='addOpt']")
    
    $("<tr data-new='true'>\n\
        <td style='color:red' data-role='description' contenteditable='true' align='center'></td>\n\
        <td style='color:red' data-role='optposition' contenteditable='true' align='center'></td>\n\
        <td></td>\n\
       </tr>").insertBefore($("#opTable").find("span[data-role='addOpt']").parents("tr"));
    
    $("td[data-role='optposition']").keypress(function (e){
        if (e.which < 48 || e.which > 57) 
            e.preventDefault();
    });
}

function openEditModuleColumn(span)
{
    $("#SuperAlert").modal("show");
    $("#SuperAlert").find(".modal-title").html("Modifica colonna del modulo");
    var modal = $("#SuperAlert").find(".modal-body");
    var posizione = $(span).parents("th").attr("data-position");
    var idcolonna = $(span).parents("th").attr("data-id");
    var nomecolonna = $(span).parents("th").text().replace("#"+posizione, "").trim();
    var multipla = $(span).parents("th").attr("data-multiple");
    
    modal.html("<div class='row'>\n\
                    <div class='col col-sm-12'> \n\
                        <div class='row'>\n\
                            <div class='col col-sm-6'>\n\
                                Nome della colonna\n\
                                <input style='margin-bottom:5px' id='nomecolonna' value='"+nomecolonna+"' type='text' class='form-control'>\n\
                                Numero della colonna\n\
                                <input style='margin-bottom:5px' id='posizione' value='"+posizione+"' min='1' type='number' class='form-control'>\n\
                                Tipo risposta\n\
                                <div class='list-group' style='cursor:pointer'>\n\
                                    <a onclick='$(this).addClass(\"active\"); $(\"#rispostaaperta\").removeClass(\"active\"); showOptionsTable("+idcolonna+")' id='rispostachiusa' class=\"list-group-item\">Risposta chiusa</a>\n\
                                    <a onclick='$(this).addClass(\"active\"); $(\"#rispostachiusa\").removeClass(\"active\"); $(\"#possibilita-wrapper\").html(\"\")' id='rispostaaperta' class=\"list-group-item\">Risposta aperta</a>\n\
                                </div>\n\
                                \n\
                            </div>\n\
                            <div id='possibilita-wrapper' class='col col-sm-6'>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                </div>");
    if (multipla === "1")
    {
        showOptionsTable(idcolonna);
    }
    else
        $("#rispostaaperta").addClass("active");    
    
    $("#SuperAlert").find(".modal-footer").html("\
                            <div class='row'>\n\
                    <div class='col col-sm-12'> \n\
                        <div class='row'>\n\
                            <div align='left' class='col col-sm-6'>\n\
                                <button onclick='askForDeleteColumn("+idcolonna+")' data-dismiss='modal' class='btn btn-warning'><span class='glyphicon glyphicon-exclamation-sign'></span> Elimina questa colonna </button>\n\
                            </div>\n\
                            <div align='right' class='col col-sm-6'>\n\
                                <button data-dismiss='modal' class='btn btn-danger'><span class='glyphicon glyphicon-remove'></span> Chiudi</button>\n\
                                <button onclick='editColumn("+idcolonna+")' data-dismiss='modal' class='btn btn-success'><span class='glyphicon glyphicon-ok'></span> Conferma modifiche</button>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                </div>");
    
    $("#nomecolonna").on("input", function (){
        $(this).css("color", "red");
    });
    
    $("#posizione").on("input", function (){
        $(this).css("color", "red");
    });
}

function askForDeleteColumn(id_colonna)
{
    $("#SuperAlert").modal("show");
    var modal = $("#SuperAlert").find(".modal-body");
    $("#SuperAlert").find(".modal-title").html("ATTENZIONE");
    modal.html("<div align='center'><u>ATTENZIONE</u></div>\n\
                <br>\n\
                Eliminando questa colonna di questo modulo, si perderanno DEFINITIVAMENTE i seguenti dati:\n\
                <ul>\n\
                    <li>Tutte le risposte corrispondenti alla colonna fornite fino ad ora dagli studenti</li>\n\
                    <li>Se a risposta chiusa, tutte le opzioni possibili</li>\n\
                </ul>");
    $("#SuperAlert").find(".modal-footer").html("<div class='row'> \n\
                                                    <div class='col col-sm-6' align='left'><h3 style='display:inline'>Procedere?</h3></div>\n\
                                                    <div class='col col-sm-6'> \n\
                                                        <button class='btn btn-success' onclick='deleteModuleColumn("+id_colonna+")'>Si</button>\n\
                                                        <button class='btn btn-danger' data-dismiss='modal'>No</button>\n\
                                                    </div> \n\
                                                 </div>");
}

function deleteModuleColumn(id_colonna)
{
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerVisualizzaModuloStudente/ajaxDeleteColumn.php',
        cache : false,
        data : { 'colonna' : id_colonna },
        success : function (msg)
        {
            if (msg === "ok") 
                location.reload();
            else
                printError("Errore di eliminazione", "<div align='center'>L'eliminazione della colonna è fallito.<br>Si prega di riprovare</div>")
        }
    });
}

function editColumn(idcolonna)
{
    var nomecolonna = $("#nomecolonna").val().trim();
    var posizione = $("#posizione").val();
    var tiporisposta = ($("#rispostachiusa").hasClass("active")) ? 1 : 0;
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerVisualizzaModuloStudente/ajaxEditColumn.php',
        cache : false,
        data : 
                {
                    'id' : idcolonna,
            'nome' : nomecolonna,
            'posizione' : posizione,
            'risposta' : tiporisposta
        },
        success : function (msg)
        {
            if (msg === "ok")
            {
                if ($("#rispostachiusa").hasClass("active")) editOptions(idcolonna);
                else
                {
                    var spanhtml = " <span onclick='openEditModuleColumn(this)' style='cursor:pointer; color:orange' class='glyphicon glyphicon-pencil'></span>";
                    $("th[data-id = '"+idcolonna+"']").html("#" + posizione + " " + nomecolonna + spanhtml);
                }
                location.reload();
            }
        }
    });
}

function editOptions(id_colonna)
{    
    $("#opTable").find("tr").each(function (){
        if (typeof($(this).attr("data-id")) !== "undefined")
        {
            $.ajax({
                async : false,
                type : 'POST',
                url : 'ajaxOpsPerVisualizzaModuloStudente/ajaxEditOption.php',
                data : 
                        {
                            'id' : $(this).attr("data-id"),
                    'posizione' : $(this).find("td[data-role='optposition']").text(),
                    'opzione' : $(this).find("td[data-role='description']").text().trim()
                },
                success : function (msg)
                {
                    if (msg !== "ok") return false;
                }
            });
        }
        else
        {
            if (typeof($(this).attr("data-new")) !== "undefined")
            {
                $.ajax({
                    async : false,
                    type : 'POST',
                    url : 'ajaxOpsPerVisualizzaModuloStudente/ajaxAddOption.php',
                    data : 
                            {
                                'posizione' : $(this).find("td[data-role='optposition']").text(),
                        'opzione' : $(this).find("td[data-role='description']").text().trim(),
                        'colonna' : id_colonna
                    },
                    success : function (msg)
                    {
                    }
                });
            }
        }
    });
}

function openAddColumn(id_modulo)
{
    
    $("#SuperAlert").modal("show");
    $("#SuperAlert").find(".modal-title").html("Aggiungi colonna al modulo");
    var modal = $("#SuperAlert").find(".modal-body");
    var preferredpos = parseInt($("th[data-role='numero_voce']").last().attr("data-position")) + 1;
    
    modal.html("<div class='row'>\n\
                    <div class='col col-sm-12'> \n\
                        <div class='row'>\n\
                            <div class='col col-sm-2'>\n\
                            </div>\n\
                            <div class='col col-sm-8'>\n\
                                Nome della nuova colonna\n\
                                <input style='margin-bottom:5px' class='form-control' id='nomeNuovaColonna'>\n\
                                Numero della nuova colonna\n\
                                <input value='"+preferredpos+"' style='margin-bottom:5px' type='number' min='1' class='form-control' id='numeroNuovaColonna'>\n\
                                Tipo risposta\n\
                                <div class='list-group' style='cursor:pointer'>\n\
                                    <a onclick='$(this).addClass(\"active\"); $(\"#rispostaaperta\").removeClass(\"active\")' id='rispostachiusa' class=\"list-group-item\">Risposta chiusa</a>\n\
                                    <a onclick='$(this).addClass(\"active\"); $(\"#rispostachiusa\").removeClass(\"active\")' id='rispostaaperta' class=\"list-group-item active\">Risposta aperta</a>\n\
                                </div>\n\
                            </div>\n\
                            <div class='col col-sm-2'>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                </div>");
    
    $("#SuperAlert").find(".modal-footer").html("<button data-dismiss='modal' class='btn btn-danger'><span class='glyphicon glyphicon-remove'></span> Chiudi</button>\n\
                                                 <button onclick='addColumn("+id_modulo+")' data-dismiss='modal' class='btn btn-success'><span class='glyphicon glyphicon-ok'></span> Aggiungi</button>");
}

function addColumn(id_modulo)
{
    tosend = {
        'modulo' : id_modulo,
        'nome' : $("#nomeNuovaColonna").val(),
        'posizione' : $("#numeroNuovaColonna").val(),
        'risposta_multipla' : 0
    };
    
    tosend.risposta_multipla = $("#rispostachiusa").hasClass("active") ? 1 : 0;
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerVisualizzaModuloStudente/ajaxAddColumn.php',
        cache : false,
        data : tosend,
        success : function (msg)
        {
            if (msg === "ok") location.reload();
            
            printError("Errore di inserimento", "<div>L'inserimento della colonna è fallito.<br>Si prega di riprovare</div>")
        }
    });
}

function openAddRow(id_modulo)
{
    
    $("#SuperAlert").modal("show");
    $("#SuperAlert").find(".modal-title").html("Aggiungi riga al modulo");
    var modal = $("#SuperAlert").find(".modal-body");
    var preferredpos = parseInt($("td[data-role='numero_voce']").last().text()) + 1;
    
    modal.html("<div class='row'>\n\
                    <div class='col col-sm-12'> \n\
                        <div class='row'>\n\
                            <div class='col col-sm-2'>\n\
                            </div>\n\
                            <div class='col col-sm-8'>\n\
                                Nome della nuova riga\n\
                                <input style='margin-bottom:5px' class='form-control' id='nomeNuovaRiga'>\n\
                                Numero della nuova riga\n\
                                <input value='"+preferredpos+"' style='margin-bottom:5px' type='number' min='1' class='form-control' id='numeroNuovariga'>\n\
                            </div>\n\
                            <div class='col col-sm-2'>\n\
                            </div>\n\
                        </div>\n\
                    </div>\n\
                </div>");
    
    $("#SuperAlert").find(".modal-footer").html("<button data-dismiss='modal' class='btn btn-danger'><span class='glyphicon glyphicon-remove'></span> Chiudi</button>\n\
                                                 <button onclick='addRow("+id_modulo+")' data-dismiss='modal' class='btn btn-success'><span class='glyphicon glyphicon-ok'></span> Aggiungi</button>");
}

function addRow(id_modulo)
{
    tosend = {
        'modulo' : id_modulo,
        'nome' : $("#nomeNuovaRiga").val(),
        'posizione' : $("#numeroNuovariga").val()
    };
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerVisualizzaModuloStudente/ajaxAddRow.php',
        cache : false,
        data : tosend,
        success : function (msg)
        {
            if (msg === "ok") 
                location.reload();
            else
                printError("Errore di inserimento", "<div>L'inserimento della riga è fallito.<br>Si prega di riprovare</div>")
        }
    });
}

function askForDeleteModuleRow(id_riga)
{
    $("#SuperAlert").modal("show");
    var modal = $("#SuperAlert").find(".modal-body");
    $("#SuperAlert").find(".modal-title").html("ATTENZIONE");
    modal.html("<div align='center'><u>ATTENZIONE</u></div>\n\
                <br>\n\
                Eliminando questa riga di questo modulo, si perderanno DEFINITIVAMENTE i seguenti dati:\n\
                <ul>\n\
                    <li>Tutte le risposte a tale riga fornite fino ad ora dagli studenti</li>\n\
                </ul>");
    $("#SuperAlert").find(".modal-footer").html("<div class='row'> \n\
                                                    <div class='col col-sm-6' align='left'><h3 style='display:inline'>Procedere?</h3></div>\n\
                                                    <div class='col col-sm-6'> \n\
                                                        <button class='btn btn-success' onclick='deleteModuleRow("+id_riga+")'>Si</button>\n\
                                                        <button class='btn btn-danger' data-dismiss='modal'>No</button>\n\
                                                    </div> \n\
                                                 </div>");
}

function deleteModuleRow(id_riga)
{
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerVisualizzaModuloStudente/ajaxDeleteRow.php',
        cache : false,
        data : { 'riga' : id_riga },
        success : function (msg)
        {
            if (msg === "ok") 
                location.reload();
            else
                printError("Errore di eliminazione", "<div align='center'>L'eliminazione della riga è fallito.<br>Si prega di riprovare</div>")
        }
    });
}