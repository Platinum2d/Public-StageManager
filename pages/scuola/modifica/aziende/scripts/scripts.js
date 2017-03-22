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
        alert("Sono insorti errori durante l'operazione richiesta");
    
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
                <label class='custlabel' id=\"userlabel"+numberId+"\"> Username </label><input type=\"text\" class=\"form-control\" id=\"username"+numberId+"\">\n\
                <label class='custlabel'>Password </label><input placeholder=\"Lasciare vuoto per nessuna modifica\" type=\"password\" class=\"form-control\" id=\"password"+numberId+"\">\n\
                <label class='custlabel'>Nome Azienda</label> <input type=\"text\" class=\"form-control\" id=\"nomeazienda"+numberId+"\">\n\
                <label class='custlabel'>Citta</label> <input type=\"text\" class=\"form-control\" id=\"cittaazienda"+numberId+"\"> \n\
                <label class='custlabel'>CAP</label> <input type=\"text\" class=\"form-control\" id=\"capazienda"+numberId+"\">\n\
                <label class='custlabel'>Indirizzo</label> <input type=\"text\" class=\"form-control\" id=\"indirizzoazienda"+numberId+"\"> \n\
            </div>\n\
            <div class=\"col col-sm-6\"> \n\
                Telefono <input type=\"text\" class=\"form-control\" id=\"telefonoazienda"+numberId+"\">\n\
                Email <input type=\"text\" class=\"form-control\" id=\"email"+numberId+"\"> \n\
                Sito Web <input type=\"text\" class=\"form-control\" id=\"sitoweb"+numberId+"\">\n\
                Nome Responsabile <input type=\"text\" class=\"form-control\" id=\"nomeresponsabile"+numberId+"\"> Cognome Responsabile <input type=\"text\" class=\"form-control\" id=\"cognomeresponsabile"+numberId+"\">\n\
                Telefono Responsabile <input type=\"text\" class=\"form-control\" id=\"telefonoresponsabile"+numberId+"\">\n\
                Email Responsabile <input type=\"text\" class=\"form-control\" id=\"emailresponsabile"+numberId+"\">\n\
                    <button class=\"btn btn-danger btn-sm rightAlignment margin buttonfix\" onclick=\"closeEdit("+numberId+")\"> <span class=\"glyphicon glyphicon-remove\"> </span> </button> \n\
                    <button class=\"btn btn-success btn-sm rightAlignment margin buttonfix\"  onclick=\" sendData("+idazienda+","+numberId+")\"> <span class=\"glyphicon glyphicon-ok\"> </span> </button>\n\
            </div>\n\
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
                        }
                        else
                        {
                            $("#userlabel"+numberId).css("color", "#828282");
                            $("#userlabel"+numberId).html("username");
                        }
                    }
                });
            });
        },
        error : function()
        {
            alert("errore")
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
    azienda.username = ''+$("#username"+numberId).val();
    azienda.password = ($("#password"+numberId).val().isEmpty()) ? 'immutato' : ''+$("#password"+numberId).val();
    azienda.nomeazienda = ''+$("#nomeazienda"+numberId).val();
    azienda.cittaazienda = ''+$("#cittaazienda"+numberId).val();
    azienda.capazienda = ''+$("#capazienda"+numberId).val();
    azienda.indirizzoazienda = ''+$("#indirizzoazienda"+numberId).val();
    azienda.telefonoazienda = ''+$("#telefonoazienda"+numberId).val();
    azienda.email = ''+$("#email"+numberId).val();
    azienda.sitoweb = ''+$("#sitoweb"+numberId).val();
    azienda.nomeresponsabile = ''+$("#nomeresponsabile"+numberId).val();
    azienda.cognomeresponsabile = ''+$("#cognomeresponsabile"+numberId).val();
    azienda.telefonoresponsabile = ''+$("#telefonoresponsabile"+numberId).val();
    azienda.emailresponsabile = ''+$("#emailresponsabile"+numberId).val();
    
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };
    
    if (!azienda.username.isEmpty() && !azienda.nomeazienda.isEmpty() && !azienda.cittaazienda.isEmpty() && !azienda.capazienda.isEmpty() && !azienda.indirizzoazienda.isEmpty())
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
}

function deleteAzienda(idAzienda)
{
    var confirmed = confirm("Confermare l'eliminazione di questa azienda?");
    if (confirmed)
    {
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerAzienda/ajaxElimina.php',
            data : {'idazienda' : idAzienda},
            success : function (msg)
            {
                if (msg === "ok")
                    location.reload();
                else
                    printError("Eliminazione non riuscita","Contattare l'amministratore");
            }
        });
    }
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