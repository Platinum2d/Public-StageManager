docente = {
    'id' : '',
    'password' : '',
    'username' : '',
    'nome' : '',
    'cognome' : '',
    'telefono' : '',
    'email' : '',
    'tipo_utente' : ''
}

$(document).ready(function (){
    $("#checkall").change(function (){
        if ($(this).prop("checked"))
            $(".singlecheck").prop("checked", true);
        else
            $(".singlecheck").prop("checked", false);
    });
});

function openEdit (id, iddocente)
{
    var numberId = id;
    
    $("#VisibleBox"+numberId).append("<div id=\"HiddenBox"+numberId+"\"> </div>");
    $("#HiddenBox"+numberId).hide();
    $("#HiddenBox"+numberId).append("\
    <div class=\"row\">\n\
        <div class=\"col col-sm-12\">\n\
            <div class=\"row\">\n\
                <div class=\"col col-sm-6\">\n\
                        <label class='custlabel' id=\"userlabel"+numberId+"\">Username*</label><input style='margin-bottom:5px' placeholder=\"Username\" type=\"text\" class=\"form-control\" id=\"username"+numberId+"\">\n\
                        Password <input placeholder=\"Password (lasciare vuoto per nessuna modifica)\" type=\"password\" class=\"form-control\" id=\"password"+numberId+"\">\n\
                        <label class='custlabel' id=\"nomelabel"+numberId+"\">Nome*</label><input placeholder=\"Nome\" type=\"text\" class=\"form-control\" id=\"nome"+numberId+"\">\n\
                        <label class='custlabel' id=\"cognomelabel"+numberId+"\">Cognome*</label><input style='margin-bottom:5px' placeholder=\"Cognome\" type=\"text\" class=\"form-control\" id=\"cognome"+numberId+"\">\n\
                        Telefono <input style='margin-bottom:5px' placeholder=\"Telefono\" type=\"text\" class=\"form-control\" id=\"telefono"+numberId+"\">\n\
                        E-mail <input placeholder=\"E-Mail\" type=\"text\" class=\"form-control\" id=\"email"+numberId+"\">\n\
                        </div>\n\
                        <div class=\"col col-sm-6\"><div class=\"form-group\"><label id=\"docref\"> Docente Referente </label> <input type=\"checkbox\" class=\"form-control\" id=\"docentereferente"+numberId+"\"></div>\n\
                        <div class=\"form-group\"><label id=\"doctut\"> Docente Tutor </label> <input type=\"checkbox\" class=\"form-control\" id=\"docentetutor"+numberId+"\"></div>\n\
                    </div>\n\
                </div>\n\
            <button class=\"btn btn-danger btn-sm rightAlignment margin buttonfix\" onclick=\"closeEdit("+numberId+")\"> <span class=\"glyphicon glyphicon-remove\"> </span> </button> \n\
            <button class=\"btn btn-success btn-sm rightAlignment margin buttonfix\"  onclick=\" sendData("+iddocente+","+numberId+")\"> <span class=\"glyphicon glyphicon-ok\"> </span> </button>\n\
        <br><p class='left'><b>* Campo obbligatorio</b></p>\n\
        </div>\n\
    </div>");
    $("#modifica"+numberId).prop('disabled',true);
    setOnChangeEvents(numberId);
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerDocente/getData.php',
        data : {'iddocente' : iddocente},
        cache : false,
        success : function (xml)
        {
            $(xml).find("docenti").find("docente").each(function (){
                $("#username"+numberId).val($(this).find("username").text());
                $("#username"+numberId).attr('name',$(xml).find('username').text());
                $("#nome"+numberId).val($(this).find("nome").text());
                $("#cognome"+numberId).val($(this).find("cognome").text());
                $("#telefono"+numberId).val($(this).find("telefono").text());
                $("#email"+numberId).val($(this).find("email").text());     
                if ($(this).find("tipo_utente").text() === "3") $("#docentetutor"+numberId).attr('checked',true);
                if ($(this).find("tipo_utente").text() === "2") $("#docentereferente"+numberId).attr('checked',true);
                $("#username"+numberId).keypress(function (e){
                    if (e.which === 32) return false;
                }); 
                $("#username"+numberId).on("input", function (){
                    $.ajax({
                        type : 'POST',
                        url : 'ajaxOpsPerDocente/ajaxCheckUserExistence.php',
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
            });
        },
        error : function()
        {
            alert("errore")
        }
    })
    $("#HiddenBox"+numberId).fadeIn("slow");
    $("#ButtonBox"+numberId).animate({
        height : $("#ButtonBox"+numberId).height() + $("#HiddenBox"+numberId).height()
    }, 500)
}

function closeEdit (numberId)
{
    $("#ButtonBox"+numberId).height($("#VisibleBox"+numberId).height() - $("#HiddenBox"+numberId).height());
    $( "#HiddenBox"+numberId ).remove();
    $("#modifica"+numberId).prop("disabled",false);
    $("#elimina"+numberId).prop("disabled",false);
    $("#registro"+numberId).prop("disabled",false);
}

function sendData(iddocente, numberId)
{
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };
    docente.id = iddocente;
    docente.password = ($("#password"+numberId).val().isEmpty()) ? "immutato" : $("#password"+numberId).val().trim();
    docente.username = $("#username"+numberId).val().trim();
    docente.cognome = $("#cognome"+numberId).val().trim();
    docente.nome = $("#nome"+numberId).val().trim();
    docente.telefono = $("#telefono"+numberId).val().trim();
    docente.email = $("#email"+numberId).val().trim();
    docente.tipo_utente = ($("#docentereferente"+numberId).prop('checked') === true) ? "2" : "3";
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerDocente/ajaxInvia.php',
        cache : false,
        data : docente,
        success : function (msg)
        {
            if (msg === "ok")
            {
                resetColors(numberId);
                $("#label"+numberId).html($("#cognome"+numberId).val() + " " + $("#nome"+numberId).val() + " ("+$("#username"+numberId).val()+")");
            }
        }
    });
    
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };
    
}

function deleteDocente(idDocente)
{
    var confirmed = confirm("Confermare l'eliminazione di questo docente?");
    if (confirmed)
    {
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerDocente/ajaxElimina.php',
            data : {'iddocente' : idDocente},
            success : function (msg)
            {
                if (msg === "ok")
                    location.reload();
                else
                    printError("Eliminazione non riuscita","<div align='center'>Controllare che il docente non sia più legato ad alcun contesto (insegnamento, associazione come docente referente ecc.)<br>Se l'errore persiste, contattare l'amministratore</div>");
            }
        });
    }
}

function setOnChangeEvents(numberId)
{
    $("#username"+numberId).on('input',((function (e){ $("#username"+numberId).css('color','red'); })));
    $("#password"+numberId).on('input',((function (e){ $("#password"+numberId).css('color','red'); })));
    $("#nome"+numberId).on('input',((function (e){ $("#nome"+numberId).css('color','red'); })));
    $("#cognome"+numberId).on('input',((function (e){ $("#cognome"+numberId).css('color','red'); })));
    $("#telefono"+numberId).on('input',((function (e){ $("#telefono"+numberId).css('color','red'); })));
    $("#email"+numberId).on('input',((function (e){ $("#email"+numberId).css('color','red'); })));
    $("#docentereferente"+numberId).change(((function (e){ 
        $("#docref").css("color","red"); 
        $("#docentetutor"+numberId).prop("checked", false);
    })));
    $("#docentetutor"+numberId).change(((function (e){ 
        $("#doctut").css("color","red"); 
        $("#docentereferente"+numberId).prop("checked", false);
    })));
}

function resetColors(numberId)
{
    $("#username"+numberId).css('color','#555');
    $("#password"+numberId).css('color','#555');
    $("#nome"+numberId).css('color','#555');
    $("#cognome"+numberId).css('color','#555');
    $("#telefono"+numberId).css('color','#555');
    $("#email"+numberId).css('color','#555');
    $("#docref").css("color","#555");
    $("#doctut").css("color","#555");
}