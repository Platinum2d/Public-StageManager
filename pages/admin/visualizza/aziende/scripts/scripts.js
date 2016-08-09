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

function openEdit (id, idazienda)
{
    var numberId = id;
    
    $("#VisibleBox"+numberId).append("<div id=\"HiddenBox"+numberId+"\"> </div>");
    $("#HiddenBox"+numberId).hide();
    $("#HiddenBox"+numberId).append(" <div class=\"row\"> <div class=\"col col-sm-12\"> <div class=\"col col-sm-6\"> Username <input type=\"text\" class=\"form-control\" id=\"username"+numberId+"\">Nome Azienda <input type=\"text\" class=\"form-control\" id=\"nomeazienda"+numberId+"\">\n\
        Citta <input type=\"text\" class=\"form-control\" id=\"cittaazienda"+numberId+"\"> CAP <input type=\"number\" class=\"form-control\" id=\"capazienda"+numberId+"\">\n\
        Indirizzo <input type=\"text\" class=\"form-control\" id=\"indirizzoazienda"+numberId+"\"> Telefono <input type=\"text\" class=\"form-control\" id=\"telefonoazienda"+numberId+"\">\n\
        </div> <div class=\"col col-sm-6\"> Password <input type=\"password\" class=\"form-control\" id=\"password"+numberId+"\">  Email <input type=\"text\" class=\"form-control\" id=\"email"+numberId+"\"> Sito Web <input type=\"text\" class=\"form-control\" id=\"sitoweb"+numberId+"\">\n\
        Nome Responsabile <input type=\"text\" class=\"form-control\" id=\"nomeresponsabile"+numberId+"\"> Cognome Responsabile <input type=\"text\" class=\"form-control\" id=\"cognomeresponsabile"+numberId+"\">\n\
        Telefono Responsabile <input type=\"text\" class=\"form-control\" id=\"telefonoresponsabile"+numberId+"\">\n\
        Email Responsabile <input type=\"text\" class=\"form-control\" id=\"emailresponsabile"+numberId+"\">\n\
        <button class=\"btn btn-danger btn-sm rightAlignment margin buttonfix\" onclick=\"closeEdit("+numberId+")\"> <span class=\"glyphicon glyphicon-remove\"> </span> </button> \n\
        <button class=\"btn btn-success btn-sm rightAlignment margin buttonfix\"  onclick=\" sendData("+idazienda+","+numberId+")\"> <span class=\"glyphicon glyphicon-ok\"> </span> </button>\n\
        </div></div></div><br><br>");
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

function sendData(idazienda, numberId)
{
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };
    azienda.id = idazienda;
    azienda.username = $("#username"+numberId).val();
    azienda.password = ($("#password"+numberId).val().isEmpty()) ? 'immutato' : $("#password"+numberId).val();
    azienda.nomeazienda = $("#nomeazienda"+numberId).val();
    azienda.cittaazienda = $("#cittaazienda"+numberId).val();
    azienda.capazienda = $("#capazienda"+numberId).val();
    azienda.indirizzoazienda = $("#indirizzoazienda"+numberId).val();
    azienda.telefonoazienda = $("#telefonoazienda"+numberId).val();
    azienda.email = $("#email"+numberId).val();
    azienda.sitoweb = $("#sitoweb"+numberId).val();
    azienda.nomeresponsabile = $("#nomeresponsabile"+numberId).val();
    azienda.cognomeresponsabile = $("#cognomeresponsabile"+numberId).val();
    azienda.telefonoresponsabile = $("#telefonoresponsabile"+numberId).val();
    azienda.emailresponsabile = $("#emailresponsabile"+numberId).val();
    
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
                else
                    alert(msg)
            },
            error : function () {
                alert();
            }
        });
    }
}

function deleteAzienda(idAzienda)
{
    var confirmed = confirm("Confermare la cancellazione di questa azienda?");
    if (confirmed)
    {
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerAzienda/ajaxElimina.php',
            data : {'idazienda' : idAzienda},
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