azienda = {
    'id' : '',
    'password' : '',
    'username' : '',
    'nomeazienda' : '',
    'cittaazienda' : '',
    'capazienda' : '',
    'indirizzoazienda' : '',
    'telefonoazienda' : '',
    'email' : '',
    'sitoweb' : '',
    'nomeresponsabile' : '',
    'cognomeresponsabile' : '',
    'telefonoresponsabile' : '',
    'emailresponsabile' : ''
}

$(function (){
    $("#actions").change(function (){
        
        switch ($("#actions").find(":selected").val())
        {
            case "4":
                var stile = "top=10, left=10, width=250, height=200, status=no, menubar=no, toolbar=no scrollbars=no";
                window.open("newhtml.html", stile);
                break;
            
            case "3":
                $("#actions").val("");
                getConfirmationForDeleteMultiple();
                break;
            
            case "2":
                $("#actions").val("");
                reduceMultiple(parseInt($("#recordperpagina").val()));
                break;
            
            case "1":
                $("#actions").val("");
                expandMultiple(parseInt($("#recordperpagina").val()));
                break;
        }
    }); 
    
    if ($(".active").length === 0)
        $("#pages").find("ul").children().first().addClass("active");
    
    $("select[name=\"naziende\"]").change(function (){
        $("#manualredirect").submit();
    });
    
    $("#customnum").keyup(function (e){
        if (e.which === 13)
        {
            if ($.isNumeric($("#customnum").val()))
                $("#manualcustomredirect").submit();
        }
    });
    
    $("#checkall").change(function (){
        if ($(this).prop("checked"))
            $(".singlecheck").prop("checked", true);
        else
            $(".singlecheck").prop("checked", false);
    });
    
    $("form[target=\"_blank\"]").height($("#modifica0").height());
});

function changePage(tupledastampare, offset, pagetounderline)
{
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerAzienda/ajaxGetTablePortion.php',
        data : { 'offset' : offset, 'tuple' : tupledastampare },
        cache : false,
        success : function (html)
        {
            $("#tableaziende").html("Caricamento....");
            $("#tableaziende").html("<thead style=\"background : #eee; font-color : white \"> <th><div align=\"center\"><input type=\"checkbox\" id=\"checkall\"></div> </th> <th style=\"text-align : center\"> Nome azienda, Username  </th> <th style=\"text-align : center\"> Azioni </th></thead> ");
            $("#tableaziende").append(html);                   
            $("#tableaziende").hide();
            $("#tableaziende").fadeIn();
            $("#pages").find("ul").find("li").each(function (){
                $(this).removeClass("active");
            });
            $("#"+pagetounderline).parent().addClass("active");
            $("form[target=\"_blank\"]").height($("#modifica0").height())
            $("#checkall").change(function (){
                if ($(this).prop("checked"))
                    $(".singlecheck").prop("checked", true);
                else
                    $(".singlecheck").prop("checked", false);
            });
        }
    })
}

function getConfirmationForDeleteMultiple()
{
    if(confirm("ATTENZIONE: Tutte le aziende selezionate verranno definitivamente cancellate.\nNON c'è modo di annullare l'azione.\nProcedere?"))
        deleteMultiple(parseInt($("#recordperpagina").val()));
}

function deleteMultiple(recordperpagina)
{
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };
    $("#actions").val("");
    
    var error = false;
    for (var I=0; I < recordperpagina; I++)
    {
        if($("#check"+I).prop("checked"))
        {
            $.ajax({
                url : 'ajaxOpsPerAzienda/ajaxElimina.php',
                type : 'POST',
                cache : false,
                async : false, //IMPORTANTE: BLOCCA LE RICHIESTE DI FILE PHP ASINCRONE. IL CODICE ANDRA' AVANTI FINCHE' TUTTE LE RICHIESTE NON VERRANNO PORTATE A TERMINE
                data : { 'idazienda' : $("#label"+I).attr("name") },
                success : function(msg)
                {
                    if (msg === "non ok")
                        error = true;
                    else
                    {
                        $("#riga"+I).fadeOut({
                            duration : 'slow',
                            complete : function (){
                                $("#riga"+I).remove();                                
                            }
                        });                        
                    }                    
                }
            });
        }
    }
    
    if (error)
        printError("Errore", "<div align='center'>Sono insorti errori durante l'operazione richiesta</div>");
    
    if ($("#tableaziende").find("tbody").html().trim().isEmpty())
    {
        var newhref = $(".active").next().find("a").attr("href");
        location.href = newhref;
    }
}

function expandMultiple(recordperpagina)
{
    for (var I=0; I < recordperpagina; I++)
    {
        if($("#check"+I).prop("checked"))
            $("#modifica"+I).trigger("click");
    }
}

function reduceMultiple(recordperpagina){
    for (var I=0; I < recordperpagina; I++)
    {
        if($("#check"+I).prop("checked"))
            $("button[onclick=\"closeEdit("+I+")\"]").trigger("click");
    }
}

function openEdit (id, idazienda)
{
    var numberId = id;
    
    $("#VisibleBox"+numberId).append("<div id=\"HiddenBox"+numberId+"\"> </div>");
    $("#HiddenBox"+numberId).hide();
    $("#HiddenBox"+numberId).append(" \n\
    <div class=\"row\"> \n\
        <div class=\"col col-sm-12\"> \n\
            <div class=\"col col-sm-6\">\n\
                <label class='custlabel' style='margin-top:0px' id=\"userlabel"+numberId+"\"> Username </label><input type=\"text\" class=\"form-control\" id=\"username"+numberId+"\">\n\
                <label class='custlabel'>Password</label><input placeholder=\"Lasciare vuoto per nessuna modifica\" type=\"password\" class=\"form-control\" id=\"password"+numberId+"\">\n\
                <label class='custlabel'>Nome Azienda</label> <input style='margin-bottom:5px' type=\"text\" class=\"form-control\" id=\"nomeazienda"+numberId+"\">\n\
                Citta<input style='margin-bottom:5px' type=\"text\" class=\"form-control\" id=\"cittaazienda"+numberId+"\"> \n\
                CAP<input style='margin-bottom:5px' type=\"text\" class=\"form-control\" id=\"capazienda"+numberId+"\">\n\
                Indirizzo<input style='margin-bottom:5px' type=\"text\" class=\"form-control\" id=\"indirizzoazienda"+numberId+"\"> \n\
            </div>\n\
            <div style='margin-bottom:5px' class=\"col col-sm-6\"> \n\
                Telefono <input style='margin-bottom:5px' type=\"text\" class=\"form-control\" id=\"telefonoazienda"+numberId+"\">\n\
                Email <input style='margin-bottom:5px' type=\"text\" class=\"form-control\" id=\"email"+numberId+"\"> \n\
                Sito Web <input style='margin-bottom:5px' type=\"text\" class=\"form-control\" id=\"sitoweb"+numberId+"\">\n\
                Nome Responsabile <input style='margin-bottom:5px' type=\"text\" class=\"form-control\" id=\"nomeresponsabile"+numberId+"\"> \n\
                Cognome Responsabile <input style='margin-bottom:5px' type=\"text\" class=\"form-control\" id=\"cognomeresponsabile"+numberId+"\">\n\
                Telefono Responsabile <input style='margin-bottom:5px' type=\"text\" class=\"form-control\" id=\"telefonoresponsabile"+numberId+"\">\n\
                Email Responsabile <input style='margin-bottom:5px' type=\"text\" class=\"form-control\" id=\"emailresponsabile"+numberId+"\">\n\
                    <button class=\"btn btn-danger btn-sm rightAlignment margin buttonfix\" onclick=\"closeEdit("+numberId+")\"> <span class=\"glyphicon glyphicon-remove spanfix\"> </span> </button> \n\
                    <button class=\"btn btn-success btn-sm rightAlignment margin buttonfix\"  onclick=\" sendData("+idazienda+","+numberId+")\"> <span class=\"glyphicon glyphicon-ok spanfix\"> </span> </button>\n\
            </div>\n\
            <p class='left'><b>* Campo obbligatorio</b></p>\n\
        </div>\n\
    </div\n\
><br><br>");
    $("#modifica"+numberId).prop('disabled',true);
    setOnChangeEvents(numberId);
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerAzienda/getData.php',
        data : {'idazienda' : idazienda},
        cache : false,
        success : function (xml)
        {
            $(xml).find("aziende").find("azienda").each(function (){
                $("#username"+numberId).val($(this).find("username").text());
                $("#username"+numberId).attr('name',$(xml).find('username').text());
                $("#nomeazienda"+numberId).val($(this).find("nome_aziendale").text());
                $("#cittaazienda"+numberId).val($(this).find("citta").text());
                $("#capazienda"+numberId).val($(this).find("cap").text());
                $("#indirizzoazienda"+numberId).val($(this).find("indirizzo").text());
                $("#telefonoazienda"+numberId).val($(this).find("telefono_aziendale").text());
                $("#email"+numberId).val($(this).find("email_aziendale").text());
                $("#sitoweb"+numberId).val($(this).find("sito_web").text());
                $("#nomeresponsabile"+numberId).val($(this).find("nome_responsabile").text());
                $("#cognomeresponsabile"+numberId).val($(this).find("cognome_responsabile").text());
                $("#telefonoresponsabile"+numberId).val($(this).find("telefono_responsabile").text());
                $("#emailresponsabile"+numberId).val($(this).find("email_responsabile").text());               
            });
            
            $("#username"+numberId).keypress(function (e){
                if (e.which === 32) return false;
            }); 
            
            $("#username"+numberId).on("input", function (){
                $.ajax({
                    type : 'POST',
                    url : 'ajaxOpsPerAzienda/ajaxCheckUserExistence.php',
                    cache : false,
                    data : { 'user' : $("#username"+numberId).val(), 'original' : $("#username"+numberId).attr("name") },
                    success : function(msg){
                        if (msg === "trovato")
                        {                    
                            $("#userlabel"+numberId).css("color", "red");
                            $("#userlabel"+numberId).html("username (esiste gia')");
                            $("#HiddenBox"+numberId).find(".glyphicon-ok").parent().prop("disabled", true);
                        }
                        else
                        {
                            $("#userlabel"+numberId).css("color", "#828282");
                            $("#userlabel"+numberId).html("username");
                            $("#HiddenBox"+numberId).find(".glyphicon-ok").parent().prop("disabled", false);
                        }
                    }
                });                
            });
        }
    })
    $("#HiddenBox"+numberId).fadeIn("slow")
    $("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() + $("#HiddenBox"+numberId).height());
}

function closeEdit (numberId)
{
    $("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() - $("#HiddenBox"+numberId).height())
    $( "#HiddenBox"+numberId ).remove();
    $("#modifica"+numberId).prop("disabled",false);
    $("#elimina"+numberId).prop("disabled",false);
    $("#registro"+numberId).prop("disabled",false);
    
    //$("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() - $("#HiddenBox"+numberId).height());
}

function sendData(idazienda, numberId)
{
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };
    azienda.id = idazienda;
    azienda.username = ''+$("#username"+numberId).val().trim();
    azienda.password = ($("#password"+numberId).val().isEmpty()) ? 'immutato' : ''+$("#password"+numberId).val();
    azienda.nomeazienda = ''+$("#nomeazienda"+numberId).val().trim();
    azienda.cittaazienda = ''+$("#cittaazienda"+numberId).val().trim();
    azienda.capazienda = ''+$("#capazienda"+numberId).val().trim();
    azienda.indirizzoazienda = ''+$("#indirizzoazienda"+numberId).val().trim();
    azienda.telefonoazienda = ''+$("#telefonoazienda"+numberId).val().trim();
    azienda.email = ''+$("#email"+numberId).val().trim();
    azienda.sitoweb = ''+$("#sitoweb"+numberId).val().trim();
    azienda.nomeresponsabile = ''+$("#nomeresponsabile"+numberId).val().trim();
    azienda.cognomeresponsabile = ''+$("#cognomeresponsabile"+numberId).val().trim();
    azienda.telefonoresponsabile = ''+$("#telefonoresponsabile"+numberId).val().trim();
    azienda.emailresponsabile = ''+$("#emailresponsabile"+numberId).val().trim();
    
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };
    
    if (!azienda.username.isEmpty() && !azienda.nomeazienda.isEmpty())
    {
        $.ajax({
            type : 'POST',
            url  : 'ajaxOpsPerAzienda/ajaxInvia.php',
            data : azienda,
            success : function (msg)
            {      
                if (msg === "Inserimento dei dati riuscito!")
                {
                    $("#label"+numberId).html($("#nomeazienda"+numberId).val() + " ("+$("#username"+numberId).val()+")");
                    resetColors(numberId);
                }
            }
        });
    }
    else {
    	printError ("Dati mancanti", "Alcuni dei campi obbligatori sono stati lasciati vuoti.")
    }
}

function askForDeleteAzienda(id_azienda, progressiv)
{
    $("#SuperAlert").modal("show");
    var modal = $("#SuperAlert").find(".modal-body");
    $("#SuperAlert").find(".modal-title").html("ATTENZIONE");
    modal.html("<div align='center'><u>ATTENZIONE</u></div>\n\
                <br>\n\
                Eliminando questa azienda, si perderanno DEFINITIVAMENTE i seguenti dati:\n\
                <ul>\n\
                    <li>Tutti i tutor della suddetta</li>\n\
                    <li>Tutte le preferenze espresse riguardo le figure professionali</li>\n\
                    <li><input type='checkbox' id='deleteRegistro' > Tutti i registri di lavoro </li>\n\
                    <li><input type='checkbox' id='deleteNote' > Tutte le note dei docenti </li>\n\
                    <li><input type='checkbox' id='deleteValutazioneStudente' > Tutte valutazioni dell'azienda verso gli studenti </li>\n\
                    <li><input type='checkbox' id='deleteValutazioneStage' > Tutte le valutazioni degli studenti verso l'azienda </li>\n\
                </ul>");
    $("#SuperAlert").find(".modal-footer").html("<div class='row'> \n\
                                                    <div class='col col-sm-6' align='left'><h3 style='display:inline'>Procedere?</h3></div>\n\
                                                    <div class='col col-sm-6'> \n\
                                                        <button class='btn btn-success' onclick=\"deleteAzienda("+id_azienda+", "+progressiv+")\">Si</button>\n\
                                                        <button class='btn btn-danger' data-dismiss='modal'>No</button>\n\
                                                    </div> \n\
                                                 </div>");
}

function deleteAzienda(idAzienda, progressiv)
{    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerAzienda/ajaxElimina.php',
        data : 
                {
                    'idazienda' : idAzienda, 
            'deleteRegistro' : $("#deleteRegistro").prop("checked"),
            'deleteNote' : $("#deleteNote").prop("checked"),
            'deleteValutazioneStudente' : $("#deleteValutazioneStudente").prop("checked"),
            'deleteValutazioneStage' : $("#deleteValutazioneStage").prop("checked")
        },
        success : function (msg)
        {
            if (msg === "ok")
            {
                printSuccess("Eliminazione riuscita", "<div align='center'>L'azienda è stata eliminata correttamente!</div>", function (){
                    $("#riga"+progressiv).fadeOut("slow");
                });
                $("#SuperAlert").find(".modal-footer").html("<button type='button' class='btn btn-default' data-dismiss='modal'>Chiudi</button>");
            }
            else
            {
                printError("Errore in fase di eliminazione", "<div align='center'>"+msg+"</div>")
            }
        }
    });
}

function setOnChangeEvents(numberId)
{
    $("#username"+numberId).on('input',((function (e){ $("#username"+numberId).css('color','red'); })));
    $("#password"+numberId).on('input',((function (e){ $("#password"+numberId).css('color','red'); })));
    $("#nomeazienda"+numberId).on('input',((function (e){ $("#nomeazienda"+numberId).css('color','red'); })));
    $("#cittaazienda"+numberId).on('input',((function (e){ $("#cittaazienda"+numberId).css('color','red'); })));
    $("#capazienda"+numberId).on('input',((function (e){ $("#capazienda"+numberId).css('color','red'); })));
    $("#indirizzoazienda"+numberId).on('input',((function (e){ $("#indirizzoazienda"+numberId).css('color','red'); })));
    $("#telefonoazienda"+numberId).on('input',((function (e){ $("#telefonoazienda"+numberId).css('color','red'); })));
    $("#email"+numberId).on('input',((function (e){ $("#email"+numberId).css('color','red'); })));
    $("#sitoweb"+numberId).on('input',((function (e){ $("#sitoweb"+numberId).css('color','red'); })));
    $("#nomeresponsabile"+numberId).on('input',((function (e){ $("#nomeresponsabile"+numberId).css('color','red'); })));
    $("#cognomeresponsabile"+numberId).on('input',((function (e){ $("#cognomeresponsabile"+numberId).css('color','red'); })));
    $("#telefonoresponsabile"+numberId).on('input',((function (e){ $("#telefonoresponsabile"+numberId).css('color','red'); })));
    $("#emailresponsabile"+numberId).on('input',((function (e){ $("#emailresponsabile"+numberId).css('color','red'); })));
    $("#telefonoazienda"+numberId).on('input',((function (e){ $("#telefonoazienda"+numberId).css('color','red'); })));
    $("#telefonoazienda"+numberId).on('input',((function (e){ $("#telefonoazienda"+numberId).css('color','red'); })));
}

function resetColors(numberId)
{
    $("#username"+numberId).css('color','#555');
    $("#password"+numberId).css('color','#555');
    $("#nomeazienda"+numberId).css('color','#555');
    $("#cittaazienda"+numberId).css('color','#555');
    $("#capazienda"+numberId).css('color','#555');
    $("#indirizzoazienda"+numberId).css('color','#555');
    $("#telefonoazienda"+numberId).css('color','#555');
    $("#email"+numberId).css('color','#555');
    $("#sitoweb"+numberId).css('color','#555');
    $("#nomeresponsabile"+numberId).css('color','#555');
    $("#cognomeresponsabile"+numberId).css('color','#555');
    $("#telefonoresponsabile"+numberId).css('color','#555');
    $("#emailresponsabile"+numberId).css('color','#555');
    $("#telefonoazienda"+numberId).css('color','#555');
    $("#telefonoazienda"+numberId).css('color','#555');
}