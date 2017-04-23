$(document).ready(function (){
    $("#checkall").change(function (){
        if ($(this).prop("checked"))
            $(".singlecheck").prop("checked", true);
        else
            $(".singlecheck").prop("checked", false);
    });
});

function openEdit(numberId, id_scuola)
{
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerScuole/getData.php',
        cache : false,
        data : { 'id' : id_scuola },
        success : function (xml)
        {
            $("#modifica"+numberId).prop("disabled", true);
            var username = $(xml).find("scuola").find("username").text();
            var nome = $(xml).find("scuola").find("nome").text();
            var citta = $(xml).find("scuola").find("citta").text();
            var CAP = $(xml).find("scuola").find("CAP").text();
            var indirizzo = $(xml).find("scuola").find("indirizzo").text();
            var telefono = $(xml).find("scuola").find("telefono").text();
            var email = $(xml).find("scuola").find("email").text();
            var sitoweb = $(xml).find("scuola").find("sito_web").text();
            
            $("<tr id=\"edit"+numberId+"\"> \n\
                    <td></td><td>\n\
                        <div class=\"row\">\n\
                            <div class=\"col col-sm-12\">\n\
                                <div class=\"row\">\n\
                                    <div class=\"col col-sm-6\">\n\
                                        <label class='custlabel' id=\"userlabel"+numberId+"\">Username</label><input style='margin-bottom:5px' placeholder=\"Username\" type=\"text\" class=\"form-control\" id=\"username"+numberId+"\" value='"+username+"'>\n\
                                        Nome <input style='margin-bottom:5px' class=\"form-control\" id=\"nome"+numberId+"\" value=\""+nome+"\"\">\n\
                                        Città <input style='margin-bottom:5px' class=\"form-control\" id=\"citta"+numberId+"\" value=\""+citta+"\"\">\n\
                                        CAP <input style='margin-bottom:5px' class=\"form-control\" id=\"CAP"+numberId+"\" value=\""+CAP+"\"\">\n\
                                        Indirizzo <input class=\"form-control\" id=\"indirizzo"+numberId+"\" value=\""+indirizzo+"\"\">\n\
                                    </div>\n\
                                    <div style='margin-top:5px' class=\"col col-sm-6\">\n\
                                        Password <input style='margin-bottom:5px' placeholder=\"Password (lasciare vuoto per nessuna modifica)\" type=\"password\" class=\"form-control\" id=\"password"+numberId+"\">\n\
                                        Telefono <input style='margin-bottom:5px' class=\"form-control\" id=\"telefono"+numberId+"\" value=\""+telefono+"\"\">\n\
                                        E-Mail <input style='margin-bottom:5px' class=\"form-control\" id=\"email"+numberId+"\" value=\""+email+"\"\">\n\
                                        Sito Web <input style='margin-bottom:5px' class=\"form-control\" id=\"sitoweb"+numberId+"\" value=\""+sitoweb+"\"\">\n\
                                        Nome responsabile <input style='margin-bottom:5px' class=\"form-control\" id=\"nomeResponsabile"+numberId+"\">\n\
                                        Cognome responsabile <input style='margin-bottom:5px' class=\"form-control\" id=\"cognomeResponsabile"+numberId+"\">\n\
                                        Telefono responsabile <input style='margin-bottom:5px' class=\"form-control\" id=\"telefonoResponsabile"+numberId+"\">\n\
                                        Email responsabile <input style='margin-bottom:5px' class=\"form-control\" id=\"mailResponsabile"+numberId+"\"><br>\n\
                                        <button id=\"save"+numberId+"\" class=\"btn btn-success btn-sm rightAlignment margin buttonfix\" onclick=\"sendData("+numberId+", "+id_scuola+")\"><span class=\"glyphicon glyphicon-ok\"></span></button>\n\
                                        <button id=\"cancel"+numberId+"\" class=\"btn btn-danger btn-sm rightAlignment margin buttonfix\" onclick=\"closeEdit("+numberId+")\"><span class=\"glyphicon glyphicon-remove\"></span></button>\n\
                                    </div>\n\
                                </div>\n\
                            </div>\n\
                        </div>\n\
                    </td> \n\
               </tr>").insertAfter("#scuola"+numberId);
            setOnChangeEvents(numberId);
            $("#edit"+numberId).hide();
            $("#edit"+numberId).fadeIn("slow");
        }
    });    
}

function setOnChangeEvents(numberId)
{
    $("#username"+numberId).on ('input', function (e){ $(this).css('color','red'); });
    $("#password"+numberId).on ('input', function (e){ $(this).css('color','red'); });
    $("#nome"+numberId).on ('input', function (e){ $(this).css('color','red'); });
    $("#citta"+numberId).on ('input', function (e){ $(this).css('color','red'); });
    $("#CAP"+numberId).on ('input', function (e){ $(this).css('color','red'); });
    $("#indirizzo"+numberId).on ('input', function (e){ $(this).css('color','red'); });
    $("#telefono"+numberId).on ('input', function (e){ $(this).css('color','red'); });
    $("#email"+numberId).on ('input', function (e){ $(this).css('color','red'); });
    $("#sitoweb"+numberId).on ('input', function (e){ $(this).css('color','red'); });
}

function resetColors(numberId)
{
    $("#username"+numberId).css('color','#555');
    $("#password"+numberId).css('color','#555');
    $("#nome"+numberId).css('color','#555');
    $("#citta"+numberId).css('color','#555');
    $("#CAP"+numberId).css('color','#555');
    $("#indirizzo"+numberId).css('color','#555');
    $("#telefono"+numberId).css('color','#555');
    $("#email"+numberId).css('color','#555');
    $("#sitoweb"+numberId).css('color','#555');
}

function sendData(numberId, id_scuola)
{
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };
    
    tosend = {
        'id' : id_scuola,
        'username' : $("#username"+numberId).val(),
        'password' : $("#password"+numberId).val(),
        'nome' : $("#nome"+numberId).val(),
        'citta' : $("#citta"+numberId).val(),
        'CAP' : $("#CAP"+numberId).val(),
        'indirizzo' : $("#indirizzo"+numberId).val(),
        'telefono' : $("#telefono"+numberId).val(),
        'email' : $("#email"+numberId).val(),
        'sitoweb' : $("#sitoweb"+numberId).val()
    };
    
    tosend.password = ($("#password"+numberId).val().isEmpty()) ? "immutato" : $("#password"+numberId).val();
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerScuole/ajaxInvia.php',
        cache : false,
        data : tosend,
        success : function (msg)
        {
            if (msg === "ok")
                resetColors(numberId);
        }
    });
}

function deleteSchool(numberId, id_scuola)
{
    var confirmed = confirm("Confermare l'eliminazione della seguente scuola?");
    
    if (confirmed)
    {
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerScuole/ajaxElimina.php',
            cache : false,
            data : { 'id' : id_scuola },
            success : function (msg)
            {
                if (msg === "ok")
                    location.reload();
                else
                    printError("Eliminazione non riuscita",msg);
            }
        }); 
    }
}

function closeEdit(numberId)
{
    $("#edit"+numberId).remove();
    $("#modifica"+numberId).prop("disabled", false);
}