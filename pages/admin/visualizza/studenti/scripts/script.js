studente = {
    'id'            : '',
    'password'      : '',
    'username'      : '',
    'nome'          : '',
    'cognome'       : '',
    'citta'         : '',
    'mail'          : '',
    'telefono'      : '',
    'iniziostage'   : '',
    'duratastage   ': '0',
    'visitaazienda' : false,
    'classe'        : '',
    'azienda'       : '',
    'docente'       : '',
    'tutor'         : ''
};

function openEdit(id, idStudente)
{
    id = id+'';
    var numberId = id.replace('VisibleBox','');
    //alert(numberId)
    
    $("#modifica"+numberId).prop("disabled",true);
    $("#registro"+numberId).prop("disabled",true);
    $('#'+id).append("<div id=\"HiddenBox"+numberId+"\">\n\
<div class=\"row\">\n\
 <div class=\"col col-sm-12\">\n\
 <div class=\"row\"> \n\
<div class=\"col col-sm-6\"> \n\
                username <input placeholder=\"Username\" class=\"form-control\" name=\"nc\" type=\"text\" id=\"username"+numberId+"\">\n\
                nome <input  placeholder=\"Nome\" class=\"form-control\" type=\"text\" id=\"nome"+numberId+"\"> \n\
                cognome <input placeholder=\"Cognome\" class=\"form-control\" type=\"text\" id=\"cognome"+numberId+"\">\n\
                citta <input placeholder=\"Citta'\" class=\"form-control\" type=\"text\" id=\"citta"+numberId+"\">\n\
                e-mail <input placeholder=\"E-Mail\" class=\"form-control\" type=\"text\" id=\"email"+numberId+"\"> \n\
                telefono <input placeholder=\"Telefono\" class=\"form-control\" type=\"number\" id=\"telefono"+numberId+"\">\n\
                inizio stage <input placeholder=\"Data di inizio stage\" data-provide=\"datepicker\" class=\"form-control\" type=\"text\" id=\"iniziostage"+numberId+"\">\n\
                durata stage <input placeholder=\"Data di fine stage\" class=\"form-control\" type=\"number\" min=\"1\" id=\"duratastage"+numberId+"\">\n\
                <div align=\"center\" style=\"padding-top:5px\"><input type=\"checkbox\" id=\"visitaazienda"+numberId+"\"> <label id=\"visitalabel"+numberId+"\"> azienda visitata </label></div></div>\n\
<div class=\"col col-sm-6\">\n\
                password <input placeholder=\"Password (lasciare vuoto per nessuna modifica)\" type=\"password\" class=\"form-control\" id=\"password"+numberId+"\">\n\
                classe <select placeholder=\"Classe\" class=\"form-control\" id=\"classe"+numberId+"\"> </select>\n\
                preferenze <br><input style=\"display:block\" disabled=\"true\" onkeydown=\"return false\" id=\"preferenze"+numberId+"\" class=\"form-control\" type=\"text\" value=\"\" data-role=\"tagsinput\" /> \n\
                <br>azienda <select placeholder=\"Azienda\" class=\"form-control\" id=\"azienda"+numberId+"\"> </select>\n\
                docente <select class=\"form-control\" id=\"docente"+numberId+"\"> </select>\n\
                tutor <select class=\"form-control\" id=\"tutor"+numberId+"\"></select> </div>");
    
    $("#HiddenBox"+numberId).hide();
    $("#HiddenBox"+numberId).append("<button class=\"btn btn-danger btn-sm rightAlignment margin buttonfix\" onclick=\"closeEdit("+numberId+")\"> <span class=\"glyphicon glyphicon-remove\"> </span> </button> <button class=\"btn btn-success btn-sm rightAlignment margin buttonfix\"  onclick=\" sendData("+idStudente+","+numberId+")\"> <span class=\"glyphicon glyphicon-ok\"> </span> </button> </div></div></div></div><br><br><br>");
    $("#iniziostage"+numberId).datepicker({ dateFormat: 'yy-mm-dd' });    
    setOnChangeEvents(numberId);
    
    
    $.ajax(
            {
        type : 'POST',
        url : 'ajaxOpsPerStudente/getData.php',
        data : { 'id' : idStudente},
        success : function (xml)
        {
            
            $("#username"+numberId).attr('value',$(xml).find('username').text());
            $("#nome"+numberId).attr('value',$(xml).find('nome').text());
            $("#cognome"+numberId).attr('value',$(xml).find('cognome').text());
            $("#citta"+numberId).attr('value',$(xml).find('citta').text());
            $("#email"+numberId).attr('value',$(xml).find('email').text());
            $("#telefono"+numberId).attr('value',$(xml).find('telefono').text());
            $("#iniziostage"+numberId).attr('value',$(xml).find('inizio_stage').text());
            $("#duratastage"+numberId).attr('value',$(xml).find('durata_stage').text());
            var idazienda = $(xml).find('id_azienda').text() + '';
            
            if ($(xml).find('visita_azienda').text() === "0") $("#visitaazienda"+numberId).attr('checked',false); else $("#visitaazienda"+numberId).attr('checked',true);
            
            String.prototype.isEmpty = function() {
                return (this.length === 0 || !this.trim());
            }; 
            $.ajax({
                url : 'ajaxOpsPerStudente/ajaxClasse.php',
                success : function (classi)
                {
                    $(classi).find('classi').find('classe').each(function (){
                        $("#classe"+numberId).append("<option value = \""+ $(this).find('id').text()+"\"> "+ $(this).find('nome').text() +" </option>");
                    });
                    
                    var classe = $(xml).find('classe').text() + '';
                    if (!classe.isEmpty())
                    {
                        var rightindex = 1;
                        $("#classe"+numberId+" > option").each(function() {
                            if (this.text === $(xml).find('classe').text()) 
                                rightindex = this.index;
                            
                            $("#classe"+numberId).prop('selectedIndex', rightindex);
                        });
                    }
                }
            });
            
            
            $.ajax({
                url : 'ajaxOpsPerStudente/ajaxAzienda.php',
                success : function (aziende)
                {
                    $("#azienda"+numberId).append("<option value=\"-1\"> </option>");
                    $(aziende).find('aziende').find('azienda').each(function (){
                        $("#azienda"+numberId).append("<option value=\""+$(this).find('id').text()+"\"> "+ $(this).find('nome').text() +" </option>");
                    });
                    
                    var azienda = $(xml).find('azienda').text() + '';
                    var rightindex = 1;
                    if (!azienda.isEmpty())
                    {                            
                        $("#azienda"+numberId+" > option").each(function() {
                            if (this.text === $(xml).find('azienda').text()) 
                            {
                                rightindex = this.index;
                                $("#azienda"+numberId).attr('name',$(this).attr('value'));
                                $("#azienda"+numberId).prop('selectedIndex', rightindex);
                            }
                        });
                    }
                }
            });
            
            $.ajax({
                url : 'ajaxOpsPerStudente/ajaxDocente.php',
                
                success : function (docenti)
                {
                    $("#docente"+numberId).append("<option value=\"-1\"> </option>");
                    $(docenti).find('docenti').find('docente').each(function (){
                        $("#docente"+numberId).append("<option value=\""+$(this).find('id').text()+"\"> "+ $(this).find('cognome').text() +" "+ $(this).find('nome').text()+" </option>");
                    });
                    
                    var docente = $(xml).find('docente').text() + '';
                    if (!docente.isEmpty())
                    {
                        var rightindex = 1;
                        $("#docente"+numberId+" > option").each(function() {
                            if (this.text === $(xml).find('docente').text()) 
                                rightindex = this.index;
                            
                            $("#docente"+numberId).prop('selectedIndex', rightindex);
                        });
                    }
                }
            });    
            
            if (!idazienda.isEmpty())
            {
                az = {
                    'idazienda' : idazienda
                };
                
                $.ajax({
                    type : 'POST',
                    data : az,
                    url : 'ajaxOpsPerStudente/ajaxTutorPerAzienda.php',
                    cache : false,
                    success : function (tut)
                    {
                        $("#tutor"+numberId).append("<option value=\"-1\"> </option>");
                        $(tut).find('tutors').find('tutor').each(function (){
                            $("#tutor"+numberId).append("<option value=\""+$(this).find('id').text()+"\"> "+ $(this).find('cognome').text() +" "+$(this).find('nome').text()+" </option>");
                        });
                        
                        var tutor = $(tut).find('tutor').text() + '';
                        if (!tutor.isEmpty())
                        {
                            var rightindex = 1;
                            
                            $("#tutor"+numberId+" > option").each(function() {
                                if (this.text === $(xml).find('tutor').text())
                                {
                                    rightindex = this.index;
                                }                            
                            });
                            $("#tutor"+numberId).prop('selectedIndex', rightindex);
                        }
                    }
                });
            }
            else
                $("#tutor"+numberId).append("<option value=\"-1\"> </option>");
            
            var first = true;
            $(xml).find("preferenze").find("preferenza").each(function (){
                if (first) {$("#preferenze"+numberId).tagsinput('add', ''+$(this).text()); first = false;}
                $("#preferenze"+numberId).tagsinput('add', ''+$(this).text());
            });
            $("span[data-role=\"remove\"]").css("visibility","hidden");
        }
    });  
    
    $("#nome"+numberId).keypress(function (event){
        if (event.which === 13) sendData(idStudente, numberId);
    });
    
    $("#HiddenBox"+numberId).fadeIn("slow")
    $("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() + $("#HiddenBox"+numberId).height())
//        $("#ButtonBox"+numberId).animate({
//        height : $("#ButtonBox"+numberId).height() + $("#HiddenBox"+numberId).height()
//    }, 500)
}

function sendData(idStudente, numberId)
{
    String.prototype.isEmpty = function() {
        return (this.length === 0 || !this.trim());
    };
    studente.id = idStudente;
    studente.username = $("#username"+numberId+"").val();
    studente.nome = $("#nome"+numberId+"").val();
    studente.cognome = $("#cognome"+numberId+"").val();
    studente.citta = $("#citta"+numberId+"").val();
    studente.mail = $("#email"+numberId+"").val();
    studente.telefono = $("#telefono"+numberId+"").val();
    studente.iniziostage = $("#iniziostage"+numberId+"").val();
    studente.duratastage = $("#duratastage"+numberId+"").val();
    studente.visitaazienda = $("#visitaazienda"+numberId).prop('checked');
    
    var appoggio = $("#classe"+numberId+"").find(':selected').attr('value') + '';
    studente.classe = (!appoggio.isEmpty()) ? $("#classe"+numberId+"").find(':selected').attr('value') : '';
    
    appoggio = $("#azienda"+numberId+"").find(':selected').attr('value');
    studente.azienda = (!appoggio.isEmpty() && appoggio !== "-1") ? $("#azienda"+numberId+"").find(':selected').attr('value') : 'disassegna';
    
    appoggio = $("#docente"+numberId+"").find(':selected').attr('value');
    studente.docente = (!appoggio.isEmpty() && appoggio !== "-1") ? $("#docente"+numberId+"").find(':selected').attr('value') : 'disassegna';
    
    appoggio = $("#tutor"+numberId+"").find(':selected').attr('value');
    studente.tutor = (!appoggio.isEmpty() && appoggio !== "-1") ? $("#tutor"+numberId+"").find(':selected').attr('value') : 'disassegna';
    
    studente.password = ($("#password"+numberId).val().isEmpty()) ? 'immutato' : $("#password"+numberId).val();
    
    if (!studente.username.isEmpty() && !studente.nome.isEmpty() && !studente.cognome.isEmpty() && !studente.citta.isEmpty() && !studente.mail.isEmpty())
    {
        
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerStudente/ajaxInvia.php',
            data : studente,
            success : function (xml)
            {      
//                var nome     = $(xml).find("nome").text();
//                var cognome  = $(xml).find("cognome").text();
//                var username = $(xml).find("user").text();
                var query    = $(xml).find("query").text();
                $("#label"+numberId).html(studente.cognome + " " + studente.nome + " ("+studente.username+")");
                resetColors(numberId);
            },
            error : function ()
            {
                alert("errore")
            }
        })
    }
}

function deleteData(idClasse, idStudente)
{
    var confirmed = confirm("Confermare l'eliminazione dello studente?");
    if (confirmed)
    {
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerStudente/ajaxCancella.php',
            data : {'id' : idStudente},
            success : function (msg)
            {
                location.href = "index.php?idclasse="+idClasse;
            }
        });
    }
}

function closeEdit(numberId)
{
//    $("#ButtonBox"+numberId).animate({
//        height : $("#VisibleBox"+numberId).height() - $("#HiddenBox"+numberId).height() 
//    }, 500);
    $("#ButtonBox"+numberId).height($("#VisibleBox"+numberId).height() - $("#HiddenBox"+numberId).height());

    $( "#HiddenBox"+numberId ).remove("br");
    $( "#HiddenBox"+numberId ).remove();
    
    //$( "#VisibleBox"+numberId).append('<br><br>');
    //$( "#HiddenBox"+numberId ).remove();
    
    $("#modifica"+numberId).prop("disabled",false);
    $("#elimina"+numberId).prop("disabled",false);
    $("#registro"+numberId).prop("disabled",false);
    
    //$("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() - $("#HiddenBox"+numberId).height());
}

function setOnChangeEvents(numberId)
{
    $("#username"+numberId).on('input',((function (e){ $("#username"+numberId).css('color','red'); })));
    $("#password"+numberId).on('input',((function (e){ $("#password"+numberId).css('color','red'); })));
    $("#nome"+numberId).on('input',((function (e){ $("#nome"+numberId).css('color','red'); })));
    $("#cognome"+numberId).on('input',((function (e){ $("#cognome"+numberId).css('color','red'); })));
    $("#citta"+numberId).on('input',((function (e){ $("#citta"+numberId).css('color','red'); })));
    $("#email"+numberId).on('input',((function (e){ $("#email"+numberId).css('color','red'); })));
    $("#telefono"+numberId).on('input',((function (e){ $("#telefono"+numberId).css('color','red'); })));
    $("#iniziostage"+numberId).change((function (e){ $("#iniziostage"+numberId).css('color','red'); }));
    $("#duratastage"+numberId).on('input',((function (e){ $("#duratastage"+numberId).css('color','red'); })));
    $("#visitaazienda"+numberId).click(((function (e){ $("#visitalabel"+numberId).css('color','red'); })));
    $("#classe"+numberId).change('input',((function (e){ $("#classe"+numberId).css('color','red'); })));
    $("#azienda"+numberId).change('input',((function (e){ $("#azienda"+numberId).css('color','red'); 
        idazienda = {
            'idazienda' : ''+$("#azienda"+numberId).find(":selected").attr('value')
        };
        $("#tutor"+numberId).html('<option value = "-1"></option>');
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerStudente/ajaxTutorPerAzienda.php',
            data : idazienda,
            cache : false,
            success : function (xml)
            {
                
                $(xml).find('tutors').find('tutor').each(function () {
                   var nome = $(this).find('nome').text();
                   var cognome = $(this).find('cognome').text();
                   var id = $(this).find('id').text();
                   $("#tutor"+numberId).append("<option value="+id+"> "+cognome+" "+nome+" </option>");
                });
            }
        })
    })));
    $("#docente"+numberId).change(((function (e){ $("#docente"+numberId).css('color','red'); })));
    $("#tutor"+numberId).change(((function (e){ $("#tutor"+numberId).css('color','red'); })));
}

function resetColors(numberId)
{
    $("#username"+numberId).css('color','#555');
    $("#password"+numberId).css('color','#555');
    $("#nome"+numberId).css('color','#555');
    $("#cognome"+numberId).css('color','#555');
    $("#citta"+numberId).css('color','#555');
    $("#telefono"+numberId).css('color','#555');
    $("#email"+numberId).css('color','#555');
    $("#iniziostage"+numberId).css('color','#555');
    $("#duratastage"+numberId).css('color','#555');
    $("#visitaazienda"+numberId).css('color','#555');
    $("#classe"+numberId).css('color','#555');
    $("#azienda"+numberId).css('color','#555');
    $("#docente"+numberId).css('color','#555');
    $("#tutor"+numberId).css('color','#555');
    $("#username"+numberId).css('color','#555');
}

function openRegistro(id, idStudente)
{
    id = id+'';
    var numberId = id.replace('registro','');
    $("#modifica"+numberId).prop("disabled",true);
    $("#registro"+numberId).prop("disabled",true);
    
    $('#VisibleBox'+numberId).append("<div id=\"RegistroBox"+numberId+"\"> </div>");    
    
    idstudente = {
        'studente' : idStudente
    }
    
     //$("#RegistroBox"+numberId).append("Loading... <br><br>");
    
    $.ajax({
        url : 'ajaxOpsPerStudente/ajaxRegistro.php',
        type : 'POST',
        cache : false,
        data : idstudente,
        success : function (xml)
        {
            $("#RegistroBox"+numberId).html('');
            $("#RegistroBox"+numberId).append("<table class=\"table\" id=\"table"+numberId+"\"> <thead><th style=\"min-width : 100px\"> Data </th> <th> Descrizione </th> </thead> </table>");
            $(xml).find('registro').find('lavorogiornaliero').each(function (){
                var data = $(this).find('data').text();
                var descrizione = $(this).find('descrizione').text();
                $("#table"+numberId).append("<tr> <td> "+data+" </td> <td> "+descrizione+" </td> </tr>");
            });
            $("#table"+numberId).hide();
            $("#table"+numberId).fadeIn("slow")
            $("#RegistroBox"+numberId).append("<button class=\"btn btn-danger btn-sm rightAlignment margin buttonfix\" onclick=\"closeRegistro("+numberId+")\"> <span class=\"glyphicon glyphicon-remove\"> </span> </button> <br><br><br>")            
            $("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() + $("#RegistroBox"+numberId).height());
            
//            $("#ButtonBox"+numberId).animate({
//                height : ($("#ButtonBox"+numberId).height() + $("#RegistroBox"+numberId).height())
//            }, 500)
        }
    });
}

function closeRegistro (numberId)
{
//    $("#ButtonBox"+numberId).animate({
//        height : $("#ButtonBox"+numberId).height() - $("#RegistroBox"+numberId).height()
//    }, 500)
    $("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() - $("#RegistroBox"+numberId).height())
    $( "#RegistroBox"+numberId ).remove();
    
    //$( "#VisibleBox"+numberId).append('<br><br>');
    //$( "#HiddenBox"+numberId ).remove();
    
    $("#modifica"+numberId).prop("disabled",false);
    $("#elimina"+numberId).prop("disabled",false);
    $("#registro"+numberId).prop("disabled",false);
    
    //$("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() - $("#HiddenBox"+numberId).height());
}