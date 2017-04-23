studente = {
    'id'            : '',
    'password'      : '',
    'username'      : '',
    'nome'          : '',
    'cognome'       : '',
    'citta'         : '',
    'mail'          : '',
    'telefono'      : '',
    'classe'        : ''
};

$(document).ready(function (){
    $(".buttonText").html("        Sfoglia");
    $(".icon-span-filestyle").remove();
    $("#checkall").change(function (){
        if ($(this).prop("checked"))
            $(".singlecheck").prop("checked", true);
        else
            $(".singlecheck").prop("checked", false);
    });
});

function openEdit(id, idStudente, classe, anno)
{
    id = id+'';
    var numberId = id.replace('VisibleBox','');
    //alert(numberId)
    
    $("#modifica"+numberId).prop("disabled",true);
    $("#registro"+numberId).prop("disabled",true);
    $('#'+id).append("\
    <div id=\"HiddenBox"+numberId+"\">\n\
        <div class=\"row\">\n\
            <div class=\"col col-sm-12\">\n\
                <div class=\"row\"> \n\
                    <div class=\"col col-sm-6\"> \n\
                        <label class='custlabel' id=\"userlabel"+numberId+"\">username*</label> <input placeholder=\"Username\" class=\"form-control\" type=\"text\" id=\"username"+numberId+"\">\n\
                        <label class='custlabel'>nome*</label><input placeholder=\"Nome\" class=\"form-control\" type=\"text\" id=\"nome"+numberId+"\"> \n\
                        <label class='custlabel'>cognome*</label><input placeholder=\"Cognome\" class=\"form-control\" type=\"text\" id=\"cognome"+numberId+"\">\n\
                    </div>\n\
                    <div class=\"col col-sm-6\" style=\"margin-top:5px\">\n\
                        password <input style=\"margin-bottom:5px\" placeholder=\"Password (lasciare vuoto per nessuna modifica)\" type=\"password\" class=\"form-control\" id=\"password"+numberId+"\">\n\
                        e-mail <input style=\"margin-bottom:5px\" placeholder=\"E-Mail\" class=\"form-control\" type=\"text\" id=\"email"+numberId+"\">\n\
                        telefono <input style=\"margin-bottom:5px\" placeholder=\"Telefono\" class=\"form-control\" type=\"number\" id=\"telefono"+numberId+"\">\n\
                        città <input placeholder=\"Citta'\" class=\"form-control\" type=\"text\" id=\"citta"+numberId+"\">\n\
                        <br>  \n\
                            <form method=\"POST\" action=\"dettagliostage/index.php\">\n\
                                <div align=\"center\"><input type=\"submit\" class=\"btn btn-info\" value=\"Vai al dettaglio delle esperienze\" /></div> \n\
                                <input type=\"hidden\" value=\""+idStudente+"\" name=\"studente\">\n\
                                <input type=\"hidden\" value=\""+classe+"\" name=\"classe\">\n\
                                <input type=\"hidden\" value=\""+anno+"\" name=\"anno_scolastico\">\n\
                            </form>\n\
                    </div>\n\
                </div>\n\
                <br><p class='left'><b>* Campo obbligatorio</b></p>\n\
            </div>\n\
        </div>\n\
    </div>");
    
    $("#HiddenBox"+numberId).hide();
    $("#HiddenBox"+numberId).append("<button class=\"btn btn-danger btn-sm rightAlignment margin buttonfix\" onclick=\"closeEdit("+numberId+")\"> <span class=\"glyphicon glyphicon-remove\"> </span> </button> <button class=\"btn btn-success btn-sm rightAlignment margin buttonfix\"  onclick=\" sendData("+idStudente+","+numberId+", "+classe+")\"> <span class=\"glyphicon glyphicon-ok\"> </span> </button> </div></div></div></div><br><br><br>");
    $("#iniziostage"+numberId).datepicker({ dateFormat: 'yy-mm-dd' });    
    setOnChangeEvents(numberId);
    toget = {
        'id' : idStudente,
        'idanno' : anno,
        'idclasse' : classe
    };
    
    $.ajax(
            {
                type : 'POST',
        url : 'ajaxOpsPerStudente/getData.php',
        data : toget,
        success : function (xml)
        {
            $("#username"+numberId).attr('value',$(xml).find('username').text());
            $("#username"+numberId).attr('name',$(xml).find('username').text());
            $("#nome"+numberId).attr('value',$(xml).find('nome').text());
            $("#cognome"+numberId).attr('value',$(xml).find('cognome').text());
            $("#citta"+numberId).attr('value',$(xml).find('citta').text());
            $("#email"+numberId).attr('value',$(xml).find('email').text());
            $("#telefono"+numberId).attr('value',$(xml).find('telefono').text());
            var idazienda = $(xml).find("azienda").find('id').text() + '';
            
            if ($(xml).find('visita_azienda').text() === "0") $("#visitaazienda"+numberId).attr('checked',false); else $("#visitaazienda"+numberId).attr('checked',true);
            
            String.prototype.isEmpty = function() {
                return (this.length === 0 || !this.trim());
            }; 
            $.ajax({
                type : 'POST',
                data : { 'classe' : classe },
                url : 'ajaxOpsPerStudente/ajaxClasse.php',
                success : function (classi)
                {
                    $(classi).find('classi').find('classe').each(function (){
                        $("#classe"+numberId).append("<option value = \""+ $(this).find('id').text()+"\"> "+ $(this).find('nome').text() +" </option>");
                    });
                    
                    var rightindex = 0;
                    $("#classe"+numberId+" > option").each(function() {
                        if (this.value === classe) 
                            rightindex = this.index;
                        
                        $("#classe"+numberId).prop('selectedIndex', rightindex);
                    });
                }
            });
            
            var first = true;
            $(xml).find("preferenze").find("preferenza").each(function (){
                if (first) {$("#preferenze"+numberId).tagsinput('add', ''+$(this).text()); first = false;}
                $("#preferenze"+numberId).tagsinput('add', ''+$(this).text());
            });
            $("span[data-role=\"remove\"]").css("visibility","hidden");
        }
    });  
    
    $("#username"+numberId).keypress(function (e){
        if (e.which === 32) return false;
    }); 
    
    $("#username"+numberId).on("input", function (){
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerStudente/ajaxCheckUserExistence.php',
            cache : false,
            data : { 'user' : $("#username"+numberId).val(), 'original' : $("#username"+numberId).attr("name") },
            success : function(msg){
                if (msg === "trovato")
                {                    
                    $("#userlabel"+numberId).css("color", "red");
                    $("#userlabel"+numberId).html("username (esiste gia')*");
                    $("#HiddenBox"+numberId).find(".glyphicon-ok").parent().prop("disabled", true);
                }
                else
                {
                    $("#userlabel"+numberId).css("color", "#828282");
                    $("#userlabel"+numberId).html("username*");
                    $("#HiddenBox"+numberId).find(".glyphicon-ok").parent().prop("disabled", false);
                }
            }
        });
    });
    
    $("#nome"+numberId).keypress(function (event){
        if (event.which === 13) sendData(idStudente, numberId);
    });
    
    $("#HiddenBox"+numberId).fadeIn("slow")
    $("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() + $("#HiddenBox"+numberId).height());
}

function sendData(idStudente, numberId, id_classe)
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
    studente.classe = id_classe;
    
    studente.password = ($("#password"+numberId).val().isEmpty()) ? 'immutato' : $("#password"+numberId).val();
    
    if (!studente.username.isEmpty() && !studente.nome.isEmpty() && !studente.cognome.isEmpty())
    {
        
        $.ajax({
            type : 'POST',
            url : 'ajaxOpsPerStudente/ajaxInvia.php',
            data : studente,
            success : function (xml)
            {
                var query = $(xml).find("query").text();
                $("#label"+numberId).html(studente.cognome + " " + studente.nome + " ("+studente.username+")");
                resetColors(numberId);
            }
        });
    }
}

function askForDeleteStudent(progressiv, id_studente, id_classe, id_anno)
{
    $("#SuperAlert").modal("show");
    var modal = $("#SuperAlert").find(".modal-body");
    $("#SuperAlert").find(".modal-title").html("ATTENZIONE");
    modal.html("<div align='center'><u>ATTENZIONE</u></div>\n\
                <br>\n\
                Eliminando questo studente, si perderanno DEFINITIVAMENTE i seguenti dati:\n\
                <ul>\n\
                    <li>Tutti i registri di lavoro</li>\n\
                    <li>Tutte le valutazioni rilasciate alle aziende</li>\n\
                    <li>Tutte le valutazioni ricevute dalle aziende</li>\n\
                    <li>Tutte le assegnazioni a docenti referenti, docenti tutor, aziende e tutor aziendali</li>\n\
                </ul>");
    $("#SuperAlert").find(".modal-footer").html("<div class='row'> \n\
                                                    <div class='col col-sm-6' align='left'><h3 style='display:inline'>Procedere?</h3></div>\n\
                                                    <div class='col col-sm-6'> \n\
                                                        <button class='btn btn-success' onclick='deleteStudent("+progressiv+", "+id_studente+", "+id_classe+", "+id_anno+")'>Si</button>\n\
                                                        <button class='btn btn-danger' data-dismiss='modal'>No</button>\n\
                                                    </div> \n\
                                                 </div>");
}

function deleteStudent(progressiv, id_studente, id_classe, id_anno)
{
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerStudente/ajaxElimina.php',
        data : 
                {
                    'id' : id_studente,
            'classe' : id_classe,
            'anno' : id_anno
        },
        success : function (msg)
        {
            if (msg === "ok")
            {
                $("#SuperAlert").find(".modal-footer").html("<button type='button' class='btn btn-default' data-dismiss='modal'>Chiudi</button>");
                printSuccess("Eliminazione riuscita", "<div align='center'>Lo studente e tutti i dati ad esso affiliati sono stati rimossi con successo</div>", function (){
                    $("#VisibleBox"+progressiv).parents("tr").fadeOut("slow");
                });
            }
        }
    });
}

function closeEdit(numberId)
{
    $("#ButtonBox"+numberId).height($("#VisibleBox"+numberId).height() - $("#HiddenBox"+numberId).height());
    $("#HiddenBox"+numberId ).remove("br");
    $("#HiddenBox"+numberId ).remove();
    $("#modifica"+numberId).prop("disabled",false);
    $("#elimina"+numberId).prop("disabled",false);
    $("#registro"+numberId).prop("disabled",false);
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
    $("#classe"+numberId).change('input',((function (e){ $("#classe"+numberId).css('color','red'); })));
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
    $("#classe"+numberId).css('color','#555');
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
    };
    
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
        }
    });
}

function closeRegistro (numberId)
{
    $("#ButtonBox"+numberId).height($("#ButtonBox"+numberId).height() - $("#RegistroBox"+numberId).height())
    $("#RegistroBox"+numberId ).remove();    
    $("#modifica"+numberId).prop("disabled",false);
    $("#elimina"+numberId).prop("disabled",false);
    $("#registro"+numberId).prop("disabled",false);
}

function openMoveStudent(that)
{
    var studente = that.closest("td").attr('name');
    localStorage.setItem('stdstd', studente);
    var classe = localStorage.getItem("clstd"); 
    var anno = localStorage.getItem("anstd");
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerStudente/ajaxOtherClasses.php',
        cache : false,
        data : 
                {
                    'exception' : classe,
            'id_anno' : anno
        },
        success : function (xml)
        {
            $("#SuperAlert").modal();
            $("#SuperAlert").find(".modal-body").html("");
            $("#SuperAlert").find(".modal-body").append("<br><b>ATTENZIONE: questa funzionalita' è stata pensata solo per studenti non associati ad alcuno stage.<br>TUTTI i dati relativi allo stage di questo studente con questa classe NON possono essere trasferiti nella nuova classe</b><br><br>");
            var modal = $("#SuperAlert").find(".modal-body");
            
            $("#SuperAlert").find(".modal-title").html("Scegli la classe");
            modal.append("<table class=\"table table-bordered\"> \n\
                            <thead> <th style=\"text-align : center\">Nome della classe</th> <th style=\"text-align : center\">Azioni</th> </thead> \n\
                          </table>");
            
            $(xml).find("classi").find("classe").each(function (){
                modal.find("table").append("<tr><td><div align=\"center\"><label>"+$(this).find("nome").text()+"</label></div></td><td style='padding : 5px'> <div align='center'><input type=\"button\" class=\"btn btn-success\" value=\"Seleziona\" onclick=\"moveStudent("+$(this).find("id").text()+")\"></div> </td></tr>");
            });
            
        }
    });
}

function moveStudent(idclasse)
{
    $.ajax({
        url : 'ajaxOpsPerStudente/ajaxMoveStudent.php',
        type : 'POST',
        cache : false,
        data : 
                {
                    classenuova : idclasse,
            classevecchia : localStorage.getItem("clstd"),
            anno : localStorage.getItem("anstd"),
            studente : localStorage.getItem("stdstd")
        },
        success : function (msg)
        {
            if (msg === "ok")
            {
                $("#SuperAlert").modal("hide");
                $("#SuperAlert").find(".modal-body").html("");
                location.reload();
            }
        }
    });
}

function askForDeleteClass(id_classe, id_anno)
{
    $("#SuperAlert").modal("show");
    var modal = $("#SuperAlert").find(".modal-body");
    $("#SuperAlert").find(".modal-title").html("ATTENZIONE");
    modal.html("<div align='center'><u>ATTENZIONE</u></div>\n\
                <br>\n\
                Eliminando questa classe, si perderanno DEFINITIVAMENTE i seguenti dati:\n\
                <ul>\n\
                    <li>Tutti gli studenti</li>\n\
                    <li>Tutti i registri di lavoro</li>\n\
                    <li>Tutte le valutazioni rilasciate alle aziende</li>\n\
                    <li>Tutte le valutazioni ricevute dalle aziende</li>\n\
                    <li>Tutte le assegnazioni a docenti referenti, docenti tutor, aziende e tutor aziendali</li>\n\
                </ul>");
    $("#SuperAlert").find(".modal-footer").html("<div class='row'> \n\
                                                    <div class='col col-sm-6' align='left'><h3 style='display:inline'>Procedere?</h3></div>\n\
                                                    <div class='col col-sm-6'> \n\
                                                        <button class='btn btn-success' onclick='deleteClass("+id_classe+", "+id_anno+")'>Si</button>\n\
                                                        <button class='btn btn-danger' data-dismiss='modal'>No</button>\n\
                                                    </div> \n\
                                                 </div>");
}

function deleteClass(id_classe, id_anno)
{
    var errore = false;
    $(".iwrap").each(function (){
        var id_studente = $(this).attr("name");
        
        $.ajax({
            async : false,
            type : 'POST',
            url : 'ajaxOpsPerStudente/ajaxElimina.php',
            data : 
                    {
                        'id' : id_studente,
                'classe' : id_classe,
                'anno' : id_anno
            },
            success : function (msg)
            {
                if (msg !== "ok")
                {
                    errore = true;
                }
            }
        });
    });
    
    $.ajax({
        type : 'POST',
        url : 'ajaxOpsPerStudente/ajaxRemoveClassAssociations.php',
        data : 
                {
                    'classe' : id_classe,
            'anno' : id_anno
        },
        success : function (msg)
        {
            if (msg !== "ok")
            {
                errore = true;
            }
        }
    });
    
    if (errore)
    {
        printError("Errore durante l'eliminazione", "<div align='center'>Si è verificato un errore in fase di eliminazione. Si prega di riprovare.<br>Se l'errore persiste, contattare l'amministratore</div>");
    }
    else
    {
        $("#tablestudenti").fadeOut();
        $("#SuperAlert").find(".modal-footer").html("<button type=\"button\" class=\"btn btn-defaul\" data-dismiss=\"modal\">Chiudi</button>");
        printSuccess("Eliminazione avvenuta con successo", "<div align='center'>La classe è stata eliminata con successo!</div>", function (){
            location.href='../index.php';
        });
    }
}