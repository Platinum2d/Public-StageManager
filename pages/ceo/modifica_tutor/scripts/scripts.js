tutor = {
    'id' : '',
    'username' : '',
    'nome' : '',
    'cognome' : '',
    'telefono' : '',
    'mail' : ''
}

function openEdit (id, idTutor)
{
    var numberId = id;
    
    $("#VisibleBox"+numberId).append("<div id=\"HiddenBox"+numberId+"\"> </div>");
    $("#HiddenBox"+numberId).hide();
    $("#HiddenBox"+numberId).append("Username <input type=\"text\" class=\"form-control\" id=\"username"+numberId+"\">");
    $("#HiddenBox"+numberId).append("Nome <input type=\"text\" class=\"form-control\" id=\"nome"+numberId+"\">");
    $("#HiddenBox"+numberId).append("Cognome <input type=\"text\" class=\"form-control\" id=\"cognome"+numberId+"\">");
    $("#HiddenBox"+numberId).append("Telefono <input type=\"text\" class=\"form-control\" id=\"telefono"+numberId+"\">");
    $("#HiddenBox"+numberId).append("Email <input type=\"text\" class=\"form-control\" id=\"email"+numberId+"\">");
    $("#HiddenBox"+numberId).append("<button class=\"btn btn-danger btn-sm rightAlignment margin buttonfix\" onclick=\"closeEdit("+numberId+")\"> <span class=\"glyphicon glyphicon-remove\"> </span> </button> <button class=\"btn btn-success btn-sm rightAlignment margin buttonfix\"  onclick=\" sendData("+idTutor+","+numberId+")\"> <span class=\"glyphicon glyphicon-ok\"> </span> </button><br><br><br>");
    $("#modifica"+numberId).prop('disabled',true);
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
                $("#nome"+numberId).val(($(this).find('nome').text()));
                $("#cognome"+numberId).val(($(this).find('cognome').text()));
                $("#telefono"+numberId).val(($(this).find('telefono').text()));
                $("#email"+numberId).val(($(this).find('email').text()));
            });
        },
        error : function()
        {
            alert("errore")
        }
    })
    
//    $("#HiddenBox"+numberId).hide();
//    $("#HiddenBox"+numberId).fadeIn("slow");
//    $("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() + $("#HiddenBox"+numberId).height());
    $("#HiddenBox"+numberId).fadeIn("slow")
    $("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() + $("#HiddenBox"+numberId).height());
//    $("#ButtonBox"+numberId).animate({
//        height : $("#ButtonBox"+numberId).height() + $("#HiddenBox"+numberId).height()
//    }, 500)
}

function closeEdit (numberId)
{
//    $("#ButtonBox"+numberId).animate({
//        height : $("#ButtonBox"+numberId).height() - $("#HiddenBox"+numberId).height()
//    }, 500)
    $("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() - $("#HiddenBox"+numberId).height())
    $( "#HiddenBox"+numberId ).remove();
    
    //$( "#VisibleBox"+numberId).append('<br><br>');
    //$( "#HiddenBox"+numberId ).remove();
    
    $("#modifica"+numberId).prop("disabled",false);
    $("#elimina"+numberId).prop("disabled",false);
    $("#registro"+numberId).prop("disabled",false);
    
    //$("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() - $("#HiddenBox"+numberId).height());
}

function sendData(idTutor, numberId)
{
    tutor.id = idTutor;
    tutor.username = $("#username"+numberId).val();
    tutor.nome = $("#nome"+numberId).val();
    tutor.cognome = $("#cognome"+numberId).val();
    tutor.telefono = $("#telefono"+numberId).val();
    tutor.mail = $("#email"+numberId).val();
    
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };
    
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
    var confirmed = confirm("Confermare la cancellazione di questo tutor?");
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
    $("#username"+numberId).on('input',((function (e){ $("#username"+numberId).css('color','red'); })));
    $("#nome"+numberId).on('input',((function (e){ $("#nome"+numberId).css('color','red'); })));
    $("#cognome"+numberId).on('input',((function (e){ $("#cognome"+numberId).css('color','red'); })));
    $("#email"+numberId).on('input',((function (e){ $("#email"+numberId).css('color','red'); })));
    $("#telefono"+numberId).on('input',((function (e){ $("#telefono"+numberId).css('color','red'); })));
}

function resetColors(numberId)
{
    $("#username"+numberId).css('color','#555');
    $("#nome"+numberId).css('color','#555');
    $("#cognome"+numberId).css('color','#555');
    $("#telefono"+numberId).css('color','#555');
    $("#email"+numberId).css('color','#555');
}