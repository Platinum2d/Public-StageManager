tutor = {
    'id' :       '',
    'password' :       '',
    'username' : '',
    'nome' :     '',
    'cognome' :  '',
    'telefono' : '',
    'mail' :     '',
    'azienda' : ''
}
$(document).ready(function (){
    $("#checkall").change(function (){
        if ($(this).prop("checked"))
            $(".singlecheck").prop("checked", true);
        else
            $(".singlecheck").prop("checked", false);
    });
});

function openEdit (id, idTutor)
{
    var numberId = id;
    
    $("#VisibleBox"+numberId).append("\
    <div id=\"HiddenBox"+numberId+"\">\n\
        <div class=\"row\">\n\
            <div class=\"col col-sm-12\">\n\
                <div class=\"row\">\n\
                    <div class=\"col col-sm-6\">\n\
                        <label id=\"userlabel"+numberId+"\">Username</label> <input placeholder=\"Username\" type=\"text\" class=\"form-control\" id=\"username"+numberId+"\">\n\
                        Password <input placeholder=\"Password (lasciare vuoto per nessuna modifica)\" type=\"password\" class=\"form-control\" id=\"password"+numberId+"\">\n\
                        Nome <input placeholder=\"Nome\" type=\"text\" class=\"form-control\" id=\"nome"+numberId+"\">\n\
                        Cognome <input placeholder=\"Cognome\" type=\"text\" class=\"form-control\" id=\"cognome"+numberId+"\">\n\
                     </div>\n\
                     <div class=\"col col-sm-6\">\n\
                        Telefono <input placeholder=\"Telefono\" type=\"text\" class=\"form-control\" id=\"telefono"+numberId+"\">\n\
                        E-mail <input placeholder=\"E-Mail\" type=\"text\" class=\"form-control\" id=\"email"+numberId+"\">\n\
                        Azienda <select id=\"azienda"+numberId+"\" class=\"form-control\"> <option value=\"-1\"></option> </select>\n\
                     </div>\n\
                </div>\n\
                        <button class=\"btn btn-danger btn-sm rightAlignment margin buttonfix\" onclick=\"closeEdit("+numberId+")\"> <span class=\"glyphicon glyphicon-remove\"> </span> </button>\n\
                        <button class=\"btn btn-success btn-sm rightAlignment margin buttonfix\"  onclick=\" sendData("+idTutor+","+numberId+")\"> <span class=\"glyphicon glyphicon-ok\"> </span> </button>\n\
            </div>\n\
        </div>\n\
    </div>");
    $("#modifica"+numberId).prop('disabled',true);
    $("#HiddenBox"+numberId).hide();
    setOnChangeEvents(numberId);
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerTutor/getData.php',
        data : {'idtutor' : idTutor},
        cache : false,
        success : function (xml)
        {
            $(xml).find('tutors').find('tutor').each(function(){
                $("#username"+numberId).val(($(this).find('username').text()));
                $("#username"+numberId).attr('name',$(xml).find('username').text());
                $("#nome"+numberId).val(($(this).find('nome').text()));
                $("#cognome"+numberId).val(($(this).find('cognome').text()));
                $("#telefono"+numberId).val(($(this).find('telefono').text()));
                $("#email"+numberId).val(($(this).find('email').text()));
                var idaz = $(this).find('id_azienda').text();
                var nomeaz = $(this).find('nome_azienda').text();
                $("#azienda"+numberId).attr('name',nomeaz)
                $.ajax({
                    type : 'POST',
                    url : 'ajaxOpsPerTutor/ajaxAzienda.php',
                    cache : false,
                    success : function (az)
                    {
                        $(az).find("aziende").find("azienda").each(function (){
                            $("#azienda"+numberId).append("<option value=\""+$(this).find("id").text()+"\"> "+$(this).find("nome").text()+" </option>");
                        });
                        var rightindex;
                        $("#azienda"+numberId+" > option").each(function() {
                            if (this.text === $("#azienda"+numberId).attr('name')) 
                                rightindex = this.index;
                        });
                        $("#azienda"+numberId).prop('selectedIndex', rightindex);
                    }
                });
                $("#username"+numberId).on("input", function (){
                    $.ajax({
                        type : 'POST',
                        url : 'ajaxOpsPerTutor/ajaxCheckUserExistence.php',
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
            });
        },
        error : function()
        {
            alert("errore")
        }
    });
    $("#HiddenBox"+numberId).fadeIn("slow");
    $("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() + $("#HiddenBox"+numberId).height());
}

function closeEdit (numberId)
{
    $("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() - $("#HiddenBox"+numberId).height());
    $( "#HiddenBox"+numberId ).remove();
    $("#modifica"+numberId).prop("disabled",false);
    $("#elimina"+numberId).prop("disabled",false);
    $("#registro"+numberId).prop("disabled",false);
}

function sendData(idTutor, numberId)
{
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };
    
    tutor.id = idTutor;
    tutor.username = $("#username"+numberId).val();
    tutor.password = ($("#password"+numberId).val().isEmpty()) ? "immutato" : $("#password"+numberId).val();
    tutor.nome = $("#nome"+numberId).val();
    tutor.cognome = $("#cognome"+numberId).val();
    tutor.telefono = $("#telefono"+numberId).val();
    tutor.mail = $("#email"+numberId).val();
    tutor.azienda = $("#azienda"+numberId+" option:selected").attr('value');
    
    if (!tutor.username.isEmpty() && !tutor.nome.isEmpty() && !tutor.nome.isEmpty() && !tutor.cognome.isEmpty() && !tutor.telefono.isEmpty() && !tutor.mail.isEmpty())
    {
        
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerTutor/ajaxInvia.php',
            data : tutor,
            success : function (msg)
            {
                if (msg === "Inserimento dei dati riuscito!")
                {
                    $("#label"+numberId).html($("#cognome"+numberId).val() + " " + $("#nome"+numberId).val() + " ("+$("#username"+numberId).val()+")");
                }
                resetColors(numberId);
            }
        });
    }
}

function deleteTutor(idTutor)
{
    var confirmed = confirm("Confermare l'eliminazione di questo tutor?");
    if (confirmed)
    {
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerTutor/ajaxElimina.php',
            data : {'idtutor' : idTutor},
            success : function ()
            {
                location.reload();
            }
        });
    }
}

function setOnChangeEvents(numberId)
{
    $("#username"+numberId).on('input', ((function (e){ $("#username"+numberId).css('color','red'); })));
    $("#nome"+numberId).on('input', ((function (e){ $("#nome"+numberId).css('color','red'); })));
    $("#password"+numberId).on('input', ((function (e){ $("#password"+numberId).css('color','red'); })));
    $("#cognome"+numberId).on('input', ((function (e){ $("#cognome"+numberId).css('color','red'); })));
    $("#email"+numberId).on('input', ((function (e){ $("#email"+numberId).css('color','red'); })));
    $("#telefono"+numberId).on('input', ((function (e){ $("#telefono"+numberId).css('color','red'); })));
    $("#azienda"+numberId).change(((function (e){ $("#azienda"+numberId).css('color','red'); })));
}

function resetColors(numberId)
{
    $("#username"+numberId).css('color','#555');
    $("#password"+numberId).css('color','#555');
    $("#nome"+numberId).css('color','#555');
    $("#cognome"+numberId).css('color','#555');
    $("#telefono"+numberId).css('color','#555');
    $("#email"+numberId).css('color','#555');
    $("#azienda"+numberId).css('color','#555');
}